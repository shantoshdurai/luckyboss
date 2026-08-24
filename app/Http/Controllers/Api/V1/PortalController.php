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
        $this->role($request, 'employer'); $company = $request->user()->companies()->firstOrFail(); $jobs = Job::where('company_id', $company->id)->withCount('applications')->latest()->get();
        return response()->json(['company' => $company, 'jobs' => $jobs, 'totals' => ['active_jobs' => $jobs->where('status', 'published')->count(), 'applications' => $jobs->sum('applications_count')]]);
    }

    private function role(Request $request, string $role): void
    {
        abort_unless($request->user()?->hasRole($role), 403);
    }
}