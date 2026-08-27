<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function seekerDashboard(Request $request)
    {
        $this->role($request, 'job-seeker'); $user = $request->user();
        return response()->json(['profile' => $user->candidateProfile, 'applications' => $user->applications()->with('job.company')->latest('applied_at')->get(), 'recommended_jobs' => Job::with('company')->where('status', 'published')->take(10)->get()]);
    }

    public function apply(Request $request, Job $job)
    {
        $this->role($request, 'job-seeker'); abort_unless($job->status === 'published', 404);
        abort_if($job->is_paid_apply, 422, 'Payment is required before applying to this job.');
        
        $match = app(\App\Services\AIRecruitmentEngineService::class)->calculateMatch($job, $request->user());
        
        $application = JobApplication::firstOrCreate(
            ['job_id' => $job->id, 'candidate_id' => $request->user()->id],
            ['status' => 'New', 'match_score' => $match['score'], 'applied_at' => now(), 'last_activity_at' => now()]
        );
        
        return response()->json([
            'application' => $application, 
            'match' => $match,
            'created' => $application->wasRecentlyCreated
        ], $application->wasRecentlyCreated ? 201 : 200);
    }

    public function employerDashboard(Request $request)
    {
        $this->role($request, 'employer');
        $company = $request->user()->companies()->firstOrFail();
        $jobs = Job::where('company_id', $company->id)->withCount('applications')->latest()->get();
        return response()->json([
            'company' => $company,
            'jobs' => $jobs,
            'totals' => [
                'active_jobs' => $jobs->where('status', 'published')->count(),
                'applications' => $jobs->sum('applications_count'),
            ]
        ]);
    }

    public function employerCandidates(Request $request, ?Job $job = null)
    {
        $this->role($request, 'employer');
        $company = $request->user()->companies()->firstOrFail();

        $query = JobApplication::whereHas('job', function ($q) use ($company, $job) {
            $q->where('company_id', $company->id);
            if ($job) {
                $q->where('id', $job->id);
            }
        })->with(['candidate.candidateProfile', 'job']);

        $candidates = $query->latest('applied_at')->get()->map(function ($app) {
            return [
                'id' => 'cand-' . $app->id,
                'job_id' => 'emp-j' . $app->job_id,
                'job_title' => $app->job->title ?? 'Position',
                'candidate_name' => $app->candidate->name ?? 'Applicant',
                'candidate_phone' => $app->candidate->phone ?? '+65 8000 0000',
                'candidate_email' => $app->candidate->email ?? 'applicant@example.com',
                'headline' => $app->candidate->candidateProfile->headline ?? 'Professional',
                'experience' => ($app->candidate->candidateProfile->experience_years ?? 3) . ' yrs',
                'location' => $app->candidate->candidateProfile->city ?? 'Singapore',
                'skills' => is_array($app->candidate->candidateProfile?->skills) ? $app->candidate->candidateProfile->skills : ['General'],
                'ai_match_score' => $app->match_score ?? 85,
                'status' => $app->status ?? 'New',
                'source' => 'applied',
                'contact_revealed' => true,
                'last_activity' => $app->last_activity_at ?? $app->created_at,
            ];
        });

        return response()->json(['candidates' => $candidates]);
    }

    public function updateCandidateStatus(Request $request, JobApplication $application)
    {
        $this->role($request, 'employer');
        $data = $request->validate([
            'status' => 'required|string|max:60',
            'archive_reason' => 'nullable|string|max:120',
        ]);

        $application->update([
            'status' => $data['status'],
            'last_activity_at' => now(),
        ]);

        return response()->json([
            'message' => 'Candidate status updated successfully.',
            'application' => $application,
        ]);
    }

    public function postEmployerJob(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:190',
            'category' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:190',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'currency_code' => 'nullable|string|size:3',
            'country_code' => 'nullable|string|size:2',
            'work_mode' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $company = $request->user()?->companies()->first() ?? \App\Models\Company::first();

        $job = Job::create([
            'company_id' => $company?->id ?? 1,
            'title' => $data['title'],
            'slug' => \Illuminate\Support\Str::slug($data['title']) . '-' . rand(1000, 9999),
            'category_id' => \App\Models\Category::first()?->id ?? 1,
            'location' => $data['location'] ?? 'Singapore',
            'country_code' => $data['country_code'] ?? 'SG',
            'currency_code' => $data['currency_code'] ?? 'SGD',
            'min_salary' => $data['salary_min'] ?? 4000,
            'max_salary' => $data['salary_max'] ?? 7000,
            'work_mode' => $data['work_mode'] ?? 'On-site',
            'description' => $data['description'] ?? 'Position details',
            'status' => 'published',
            'published_at' => now(),
        ]);

        return response()->json([
            'message' => 'Job posted successfully.',
            'job' => $job,
        ], 201);
    }

    private function role(Request $request, string $role): void
    {
        abort_unless($request->user()?->hasRole($role), 403);
    }
}