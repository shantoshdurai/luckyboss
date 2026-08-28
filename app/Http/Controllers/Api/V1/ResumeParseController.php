<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\FeatureFlag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Resume parsing — POST /api/v1/resume/parse
 *
 * CLAUDE.md has documented this route as shipped since the project began. It
 * never existed. This is it.
 *
 * Two gates, both server-side, because spec §93 is explicit that hiding a button
 * in Flutter is not a control:
 *   1. `platform_ai_enabled` — the master AI switch (spec §3).
 *   2. `ai_resume_parser_enabled` — vision parsing specifically, so an admin can
 *      run the chatbot while leaving document upload off.
 *
 * With either off the endpoint returns 403 and the app falls back to manual
 * entry. It never returns invented data: a resume parser that guesses puts a
 * fabricated work history on a real person's profile and sends it to employers.
 */
class ResumeParseController extends Controller
{
    /** Gemini's inline-data limit for a single request, with headroom. */
    private const MAX_KB = 4096;

    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'resume' => [
                'required', 'file',
                'mimes:pdf,doc,docx',
                'max:'.self::MAX_KB,
            ],
        ], [
            'resume.mimes' => 'Upload a PDF or Word document.',
            'resume.max' => 'That file is too large. Keep it under 4 MB.',
        ]);

        $aiEnabled = FeatureFlag::where('key', 'platform_ai_enabled')->value('is_enabled') ?? true;
        $parserEnabled = FeatureFlag::where('key', 'ai_resume_parser_enabled')->value('is_enabled') ?? false;

        if (! $aiEnabled || ! $parserEnabled) {
            return response()->json([
                'status' => 'disabled',
                'message' => 'Resume autofill is switched off. Please enter your details manually.',
            ], 403);
        }

        $key = config('services.gemini.api_key', env('GEMINI_API_KEY'));
        if (! $key) {
            Log::warning('[ResumeParse] parser flag on but no Gemini key configured.');

            return response()->json([
                'status' => 'unavailable',
                'message' => 'Resume autofill is temporarily unavailable. Please enter your details manually.',
            ], 503);
        }

        /** @var UploadedFile $file */
        $file = $request->file('resume');

        try {
            $extracted = $this->extract($file, $key);
        } catch (\Throwable $e) {
            Log::warning('[ResumeParse] '.$e->getMessage());
            $extracted = null;
        }

        if ($extracted === null) {
            return response()->json([
                'status' => 'unreadable',
                'message' => 'We could not read that resume. Please enter your details manually.',
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            // Explicitly flagged as unverified. The client must present these as
            // values to check, not as though the candidate typed them.
            'requires_review' => true,
            'data' => $extracted,
        ]);
    }

    /**
     * Sends the document to Gemini's multimodal endpoint and returns structured
     * fields, or null when nothing usable came back.
     */
    private function extract(UploadedFile $file, string $key): ?array
    {
        $model = config('services.gemini.model', env('GEMINI_MODEL', 'gemini-2.5-flash'));

        $prompt = <<<'PROMPT'
Extract the candidate's details from this resume.

Return ONLY a JSON object, no prose and no markdown fence, with these keys:
  "name": string
  "email": string
  "phone": string
  "current_title": string
  "current_company": string
  "years_experience": integer
  "qualification": one of "Doctorate","Post Graduate","Graduate","Class XII","Class X","Below Class X"
  "course": string
  "passing_year": string
  "current_city": string
  "skills": array of strings, concrete and searchable, no soft-skill filler
  "summary": string, at most 3 sentences

Use an empty string for anything the resume does not state. Never invent a
value: a guessed employer or date is worse than a blank field the candidate
fills in themselves.
PROMPT;

        $response = Http::withoutVerifying()
            ->timeout(45)
            ->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=".urlencode($key),
                [
                    'contents' => [[
                        'parts' => [
                            ['text' => $prompt],
                            [
                                'inline_data' => [
                                    'mime_type' => $file->getMimeType(),
                                    'data' => base64_encode(file_get_contents($file->getRealPath())),
                                ],
                            ],
                        ],
                    ]],
                    // Generous, and deliberately so: gemini-2.5-flash spends part
                    // of its budget on reasoning before emitting output, and a
                    // tight cap truncates the JSON mid-object so the whole reply
                    // parses as nothing. SkillController hit exactly this.
                    'generationConfig' => [
                        'temperature' => 0.1,
                        'maxOutputTokens' => 2048,
                    ],
                ]
            );

        if (! $response->successful()) {
            Log::warning('[ResumeParse] HTTP '.$response->status().': '.mb_substr($response->body(), 0, 300));

            return null;
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text', '');
        $clean = trim(preg_replace('/^```(?:json)?|```$/m', '', trim($text)) ?? '');

        $decoded = json_decode($clean, true);
        if (! is_array($decoded)) {
            Log::warning('[ResumeParse] unparseable reply: '.mb_substr($text, 0, 300));

            return null;
        }

        return $this->normalise($decoded);
    }

    /**
     * Coerces the model's output into the shape the app expects.
     *
     * Whitelisting keys matters: without it a hallucinated extra field flows
     * into the client and, eventually, onto a profile.
     */
    private function normalise(array $raw): array
    {
        $string = fn (string $k) => is_string($raw[$k] ?? null) ? trim($raw[$k]) : '';

        $skills = [];
        if (is_array($raw['skills'] ?? null)) {
            $skills = collect($raw['skills'])
                ->filter(fn ($s) => is_string($s) && trim($s) !== '' && mb_strlen($s) <= 60)
                ->map(fn (string $s) => trim($s))
                ->unique()
                ->take(30)
                ->values()
                ->all();
        }

        return [
            'name' => $string('name'),
            'email' => $string('email'),
            'phone' => $string('phone'),
            'current_title' => $string('current_title'),
            'current_company' => $string('current_company'),
            'years_experience' => (int) ($raw['years_experience'] ?? 0),
            'qualification' => $string('qualification'),
            'course' => $string('course'),
            'passing_year' => $string('passing_year'),
            'current_city' => $string('current_city'),
            'skills' => $skills,
            'summary' => $string('summary'),
        ];
    }
}
