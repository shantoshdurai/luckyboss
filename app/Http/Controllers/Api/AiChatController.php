<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $groqKey = config('services.groq.api_key', env('GROQ_API_KEY'));
        $openaiKey = config('services.openai.api_key', env('OPENAI_API_KEY'));

        // If Groq API Key is configured
        if ($groqKey) {
            try {
                $response = Http::withToken($groqKey)
                    ->timeout(10)
                    ->post('https://api.groq.com/openai/v1/chat/completions', [
                        'model' => 'llama-3.3-70b-versatile',
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => 'You are Lucky AI, an elite AI recruitment copilot for the Lucky Boss Portal (Singapore, Malaysia, India). You give concise, inspiring, highly professional advice on job search, interview preparation, salary expectations, and employer hiring.'
                            ],
                            ['role' => 'user', 'content' => $message]
                        ],
                        'temperature' => 0.7,
                        'max_tokens' => 300,
                    ]);

                if ($response->successful()) {
                    $reply = $response->json('choices.0.message.content');
                    return response()->json([
                        'reply' => $reply,
                        'actions' => [
                            ['label' => 'Explore Jobs', 'url' => route('jobs.index')]
                        ]
                    ]);
                }
            } catch (\Throwable $e) {
                Log::warning('Groq AI API error: ' . $e->getMessage());
            }
        }

        // If OpenAI API Key is configured
        if ($openaiKey) {
            try {
                $response = Http::withToken($openaiKey)
                    ->timeout(10)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-4o-mini',
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => 'You are Lucky AI, an elite AI recruitment copilot for the Lucky Boss Portal (Singapore, Malaysia, India). Give concise, structured, helpful answers.'
                            ],
                            ['role' => 'user', 'content' => $message]
                        ],
                        'temperature' => 0.7,
                        'max_tokens' => 300,
                    ]);

                if ($response->successful()) {
                    $reply = $response->json('choices.0.message.content');
                    return response()->json([
                        'reply' => $reply,
                        'actions' => [
                            ['label' => 'Explore Jobs', 'url' => route('jobs.index')]
                        ]
                    ]);
                }
            } catch (\Throwable $e) {
                Log::warning('OpenAI API error: ' . $e->getMessage());
            }
        }

        // Intelligent Local Matching Engine
        $q = strtolower($message);
        $reply = "I'm here to accelerate your career! Browse our verified listings across Singapore, Malaysia, and India with real-time application tracking.";
        $actions = [['label' => 'Search Jobs', 'url' => route('jobs.index')]];

        if (str_contains($q, 'warehouse') || str_contains($q, 'logistics') || str_contains($q, 'supervisor')) {
            $matchingJobs = Job::where('status', 'published')
                ->where(fn($query) => $query->where('title', 'like', '%warehouse%')->orWhere('title', 'like', '%logistics%'))
                ->take(3)
                ->get();

            $reply = "We have " . $matchingJobs->count() . " featured openings in logistics & warehousing, including Supervisor and Operations roles (SGD 2,800 - 4,500/mo).";
            $actions = [['label' => 'View Logistics Roles', 'url' => route('jobs.index', ['keyword' => 'warehouse'])]];
        } elseif (str_contains($q, 'resume') || str_contains($q, 'score') || str_contains($q, 'profile')) {
            $reply = "Your profile match score improves significantly when you include specific certifications, 3+ past employment milestones, and set clear location preferences.";
            $actions = [
                ['label' => 'Complete Candidate Profile', 'url' => route('register.seeker')],
                ['label' => 'Read Resume Guide', 'url' => route('blogs.index')]
            ];
        } elseif (str_contains($q, 'interview') || str_contains($q, 'prepare')) {
            $reply = "Interview prep tip: Structure your answers using the STAR method (Situation, Task, Action, Result) with measurable metrics to stand out to employers.";
            $actions = [['label' => 'Interview Guides', 'url' => route('blogs.index')]];
        } elseif (str_contains($q, 'employer') || str_contains($q, 'post') || str_contains($q, 'hire') || str_contains($q, 'pricing')) {
            $reply = "Employers can post jobs in under 2 minutes, access instant AI candidate ranking, and manage multi-stage interviews directly from the portal.";
            $actions = [
                ['label' => 'Register as Employer', 'url' => route('register.employer')],
                ['label' => 'View Pricing Plans', 'url' => route('employers.public')]
            ];
        } elseif (str_contains($q, 'salary') || str_contains($q, 'pay')) {
            $reply = "Current average salaries on Lucky Boss: Logistics (SGD 2,800 - 4,500), Quality Engineering (MYR 4,500 - 6,500), Management (SGD 4,200 - 5,800).";
            $actions = [['label' => 'Filter by Salary', 'url' => route('jobs.index')]];
        }

        return response()->json([
            'reply' => $reply,
            'actions' => $actions,
        ]);
    }
}
