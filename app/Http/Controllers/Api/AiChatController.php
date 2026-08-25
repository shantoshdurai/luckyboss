<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiIntegration;
use App\Models\FeatureFlag;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $message = trim($request->input('message', ''));
        if (empty($message)) {
            return response()->json(['reply' => 'How can I assist your career or hiring search today?']);
        }

        // Check if Platform AI is toggled ON in Admin Panel
        $isAiEnabled = FeatureFlag::where('key', 'platform_ai_enabled')->value('is_enabled') ?? true;
        $geminiKey = config('services.gemini.api_key', env('GEMINI_API_KEY'));
        $geminiModel = config('services.gemini.model', env('GEMINI_MODEL', 'gemini-2.5-flash'));
        $openaiKey = config('services.openai.api_key', env('OPENAI_API_KEY'));
        $groqKey = config('services.groq.api_key', env('GROQ_API_KEY'));

        // ─── 1. If AI Toggle is ON, try Cloud LLM API (Gemini) ───
        if ($isAiEnabled && $geminiKey) {
            try {
                $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$geminiModel}:generateContent?key=" . urlencode($geminiKey);
                
                $systemInstruction = "You are Lucky AI, an intelligent, friendly, and ultra-concise recruitment copilot for the Lucky Boss Marketplace (Singapore, Malaysia, India).
GUIDELINES:
- Keep answers SHORT and NEAT (2 to 4 sentences maximum).
- If listing options, use bullet points with clean spacing.
- Always maintain an encouraging, professional tone.
- Do NOT generate huge walls of text or repeat disclaimer paragraphs.";
                
                $response = Http::withoutVerifying()
                    ->timeout(8)
                    ->post($endpoint, [
                        'systemInstruction' => [
                            'parts' => [['text' => $systemInstruction]]
                        ],
                        'contents' => [
                            ['parts' => [['text' => $message]]]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'maxOutputTokens' => 250,
                        ]
                    ]);

                if ($response->successful()) {
                    $replyText = $response->json('candidates.0.content.parts.0.text');
                    if (!empty(trim($replyText))) {
                        ApiIntegration::where('key', 'platform_gemini')
                            ->orWhere('key', 'platform_openai')
                            ->increment('usage_count');

                        return response()->json([
                            'reply' => trim($replyText),
                            'actions' => $this->determineContextualActions($message),
                            'engine' => 'gemini_cloud_api_live',
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Gemini Chat API exception: ' . $e->getMessage());
            }
        }

        // ─── 2. Local Intelligent Deterministic Heuristic Engine (Code Script Fallback) ───
        return response()->json($this->runLocalChatScript($message));
    }

    /**
     * Deterministic Local Heuristic NLP Chat Engine
     */
    private function runLocalChatScript(string $message): array
    {
        $q = strtolower($message);
        $reply = "Hello! I am Lucky AI. You can explore thousands of verified job listings across Singapore, Malaysia, and India, or upload your resume for automated matching.";
        $actions = [['label' => 'Search All Jobs', 'url' => route('jobs.index')]];

        if (str_contains($q, 'hi') || str_contains($q, 'hello') || str_contains($q, 'hey')) {
            $reply = "Hello! Welcome to Lucky Boss. How can I help you today? You can search active jobs, check salaries, or post a new vacancy.";
            $actions = [
                ['label' => 'Explore Jobs', 'url' => route('jobs.index')],
                ['label' => 'Post a Vacancy', 'url' => route('register.employer')]
            ];
        } elseif (str_contains($q, 'warehouse') || str_contains($q, 'logistics') || str_contains($q, 'supervisor')) {
            $matchingJobs = Job::where('status', 'published')
                ->where(fn($query) => $query->where('title', 'like', '%warehouse%')->orWhere('title', 'like', '%logistics%'))
                ->take(3)
                ->get();

            $reply = "We have active openings in Logistics & Warehousing in Singapore (SGD 2,800 - 4,500/month), including Warehouse Supervisor and Operations Executive roles.";
            $actions = [
                ['label' => 'View Warehouse Jobs', 'url' => route('jobs.index', ['keyword' => 'Warehouse'])],
                ['label' => 'Browse All Roles', 'url' => route('jobs.index')]
            ];
        } elseif (str_contains($q, 'construction') || str_contains($q, 'engineer') || str_contains($q, 'site')) {
            $reply = "We have verified openings for Site Supervisors and Civil Engineers in Singapore and Malaysia (SGD 4,200 - 5,800/month).";
            $actions = [['label' => 'Explore Construction Roles', 'url' => route('jobs.index', ['keyword' => 'Construction'])]];
        } elseif (str_contains($q, 'resume') || str_contains($q, 'score') || str_contains($q, 'match')) {
            $reply = "To boost your resume match score: list 5+ core technical skills, add your past responsibilities with measurable results, and keep your contact details updated.";
            $actions = [
                ['label' => 'Update Profile & Resume', 'url' => route('seeker.profile.edit')]
            ];
        } elseif (str_contains($q, 'employer') || str_contains($q, 'post') || str_contains($q, 'hire') || str_contains($q, 'recruiter')) {
            $reply = "Employers can register to post vacancies, search candidate profiles, schedule video interviews, and access AI screening.";
            $actions = [
                ['label' => 'Post Vacancy as Employer', 'url' => route('register.employer')]
            ];
        } elseif (str_contains($q, 'salary') || str_contains($q, 'paying') || str_contains($q, 'pay')) {
            $reply = "Top published roles range from SGD 3,500 to SGD 6,500/month across Engineering, Technology, Logistics, and Healthcare.";
            $actions = [['label' => 'Browse High-Paying Jobs', 'url' => route('jobs.index')]];
        }

        return [
            'reply' => $reply,
            'actions' => $actions,
            'engine' => 'local_heuristic_nlp_script',
        ];
    }

    /**
     * Contextual action buttons generator
     */
    private function determineContextualActions(string $message): array
    {
        $q = strtolower($message);
        if (str_contains($q, 'warehouse') || str_contains($q, 'logistics')) {
            return [['label' => 'View Logistics Jobs', 'url' => route('jobs.index', ['keyword' => 'Warehouse'])]];
        }
        if (str_contains($q, 'resume') || str_contains($q, 'profile')) {
            return [['label' => 'Go to Profile', 'url' => route('seeker.profile.edit')]];
        }
        if (str_contains($q, 'employer') || str_contains($q, 'post') || str_contains($q, 'hire')) {
            return [['label' => 'Employer Portal', 'url' => route('register.employer')]];
        }
        return [['label' => 'Explore Jobs', 'url' => route('jobs.index')]];
    }
}