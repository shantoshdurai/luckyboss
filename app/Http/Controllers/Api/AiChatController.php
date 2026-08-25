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
            return response()->json(['reply' => 'Please ask a question about jobs, employers, or career guidance.']);
        }

        // Check if Platform AI is toggled ON in Admin Panel
        $isAiEnabled = FeatureFlag::where('key', 'platform_ai_enabled')->value('is_enabled') ?? true;
        $geminiKey = config('services.gemini.api_key', env('GEMINI_API_KEY'));
        $geminiModel = config('services.gemini.model', env('GEMINI_MODEL', 'gemini-2.5-flash'));
        $openaiKey = config('services.openai.api_key', env('OPENAI_API_KEY'));
        $groqKey = config('services.groq.api_key', env('GROQ_API_KEY'));

        // ─── 1. If AI Toggle is ON, try Cloud LLM API (Gemini / OpenAI / Groq) ───
        if ($isAiEnabled) {
            // A. Google Gemini Live API
            if ($geminiKey) {
                try {
                    $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$geminiModel}:generateContent?key=" . urlencode($geminiKey);
                    
                    $systemInstruction = "You are Lucky AI, an elite AI recruitment copilot for the Lucky Boss Job & Recruitment Marketplace (operating across Singapore, Malaysia, and India). Provide concise, inspiring, highly actionable advice on job openings, career development, resume matching, and employer hiring. Format key takeaways clearly with bullet points where appropriate.";
                    
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
                                'maxOutputTokens' => 450,
                            ]
                        ]);

                    if ($response->successful()) {
                        $replyText = $response->json('candidates.0.content.parts.0.text');
                        if (!empty(trim($replyText))) {
                            // Record API usage counter in database
                            ApiIntegration::where('key', 'platform_openai')
                                ->orWhere('provider', 'like', '%Gemini%')
                                ->orWhere('provider', 'like', '%OpenAI%')
                                ->increment('usage_count');

                            $actions = $this->determineContextualActions($message);

                            return response()->json([
                                'reply' => trim($replyText),
                                'actions' => $actions,
                                'engine' => 'gemini_cloud_api_live',
                            ]);
                        }
                    } else {
                        Log::warning('Gemini Chat API returned non-200: ' . $response->body());
                    }
                } catch (\Throwable $e) {
                    Log::warning('Gemini Chat API exception: ' . $e->getMessage());
                }
            }

            // B. Groq / OpenAI Fallbacks
            if ($groqKey || $openaiKey) {
                try {
                    $url = $groqKey ? 'https://api.groq.com/openai/v1/chat/completions' : 'https://api.openai.com/v1/chat/completions';
                    $key = $groqKey ?: $openaiKey;
                    $model = $groqKey ? 'llama-3.3-70b-versatile' : 'gpt-4o-mini';

                    $response = Http::withoutVerifying()
                        ->withToken($key)
                        ->timeout(6)
                        ->post($url, [
                            'model' => $model,
                            'messages' => [
                                ['role' => 'system', 'content' => 'You are Lucky AI recruitment copilot for Lucky Boss. Give concise, structured, helpful answers.'],
                                ['role' => 'user', 'content' => $message]
                            ],
                            'temperature' => 0.7,
                            'max_tokens' => 300,
                        ]);

                    if ($response->successful()) {
                        $reply = $response->json('choices.0.message.content');
                        return response()->json([
                            'reply' => trim($reply),
                            'actions' => $this->determineContextualActions($message),
                            'engine' => 'llm_fallback_api',
                        ]);
                    }
                } catch (\Throwable $e) {
                    Log::warning('Alternative LLM Chat API error: ' . $e->getMessage());
                }
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
        $reply = "I'm here to accelerate your career! Browse our verified listings across Singapore, Malaysia, and India with real-time application tracking and AI resume matching.";
        $actions = [['label' => 'Search All Jobs', 'url' => route('jobs.index')]];

        if (str_contains($q, 'warehouse') || str_contains($q, 'logistics') || str_contains($q, 'supervisor')) {
            $matchingJobs = Job::where('status', 'published')
                ->where(fn($query) => $query->where('title', 'like', '%warehouse%')->orWhere('title', 'like', '%logistics%'))
                ->take(3)
                ->get();

            $count = $matchingJobs->count();
            $reply = "We currently have {$count} active openings in logistics & warehousing, including Warehouse Supervisor and Operations Executive roles in Singapore (SGD 2,800 - 4,500/month).";
            $actions = [
                ['label' => 'View Warehouse Jobs', 'url' => route('jobs.index', ['keyword' => 'Warehouse'])],
                ['label' => 'Apply to Supervisor Role', 'url' => route('jobs.index')]
            ];
        } elseif (str_contains($q, 'construction') || str_contains($q, 'engineer') || str_contains($q, 'site')) {
            $reply = "We have high-priority openings for Construction Site Supervisors and Civil Engineers in Singapore and Malaysia (SGD 4,200 - 5,800/month).";
            $actions = [['label' => 'Explore Construction Roles', 'url' => route('jobs.index', ['keyword' => 'Construction'])]];
        } elseif (str_contains($q, 'resume') || str_contains($q, 'score') || str_contains($q, 'match')) {
            $reply = "To achieve a 90%+ match score on Lucky Boss: complete your profile experience history, list 5+ core technical skills, set your target location, and upload your latest resume PDF.";
            $actions = [
                ['label' => 'Update Job Seeker Profile', 'url' => route('seeker.profile.edit')],
                ['label' => 'Upload Resume PDF', 'url' => route('seeker.profile.edit')]
            ];
        } elseif (str_contains($q, 'employer') || str_contains($q, 'post') || str_contains($q, 'hire') || str_contains($q, 'recruiter')) {
            $reply = "Employers on Lucky Boss can post vacancies, access 50,000+ verified talent profiles, schedule video interviews, and use automated AI candidate ranking.";
            $actions = [
                ['label' => 'Post Vacancy as Employer', 'url' => route('register.employer')],
                ['label' => 'Employer Pricing Packages', 'url' => route('login')]
            ];
        } elseif (str_contains($q, 'salary') || str_contains($q, 'paying') || str_contains($q, 'pay')) {
            $reply = "Top published roles on Lucky Boss range from SGD 3,500 to SGD 6,500/month across Technology, Engineering, Logistics, and Healthcare.";
            $actions = [['label' => 'Browse High-Paying Jobs', 'url' => route('jobs.index')]];
        } elseif (str_contains($q, 'interview') || str_contains($q, 'tips') || str_contains($q, 'prepare')) {
            $reply = "Top interview advice: prepare measurable examples from past projects, review the job requirements, test your webcam for virtual rounds, and ask engaging questions.";
            $actions = [['label' => 'Read Career Blog', 'url' => route('blog.index')]];
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