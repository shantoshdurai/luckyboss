<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Offer;
use App\Models\Interview;
use App\Models\PlatformNotification;
use App\Services\AIRecruitmentEngineService;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        if (!$user || !$user->hasRole('job-seeker')) {
            if ($user?->hasRole('super-admin')) {
                return redirect()->route('admin.dashboard')->with('info', 'Logged in as Administrator. Redirected to Admin Command Center.');
            }
            if ($user?->hasRole('employer')) {
                return redirect()->route('employer.dashboard')->with('info', 'Logged in as Employer. Redirected to Employer Portal.');
            }
            return redirect()->route('login')->with('info', 'Please sign in as a Job Seeker to access this portal.');
        }

        $tab = $request->string('tab')->toString() ?: 'dashboard';
        $applications = $user->applications()->with('job.company')->latest('applied_at')->get();
        $offers = Offer::with('application.job.company')->whereHas('application', fn ($query) => $query->where('candidate_id', $user->id))->latest()->get();
        $interviews = Interview::with('application.job.company')->whereHas('application', fn ($query) => $query->where('candidate_id', $user->id))->latest('scheduled_at')->get();
        $savedJobIds = $user->savedJobs()->pluck('job_id')->all();
        $savedJobs = Job::with('company')->whereIn('id', $savedJobIds)->get();
        $allMatchingJobs = Job::with('company')->where('status', 'published')->latest('published_at')->get();

        return view('seeker.dashboard', [
            'user' => $user,
            'tab' => $tab,
            'profile' => $user->candidateProfile,
            'applications' => $applications,
            'recommendedJobs' => $allMatchingJobs->take(6),
            'allMatchingJobs' => $allMatchingJobs,
            'savedJobIds' => $savedJobIds,
            'savedJobs' => $savedJobs,
            'offers' => $offers,
            'interviews' => $interviews,
            'unreadNotifications' => PlatformNotification::where('user_id', $user->id)->whereNull('read_at')->count(),
            'stats' => [
                'applications' => $applications->count(),
                'shortlisted' => $applications->where('status', 'Shortlisted')->count(),
                'interviews' => $interviews->where('scheduled_at', '>=', now())->count(),
                'offers' => $offers->whereIn('status', ['sent', 'accepted'])->count()
            ],
        ]);
    }

    public function apply(Request $request, Job $job): RedirectResponse
    {
        abort_unless(auth()->user()?->hasRole('job-seeker'), 403);
        abort_unless($job->status === 'published', 404);

        $user = auth()->user();
        $match = app(AIRecruitmentEngineService::class)->calculateMatch($job, $user);

        $application = JobApplication::firstOrCreate(
            ['job_id' => $job->id, 'candidate_id' => $user->id],
            ['status' => 'New', 'match_score' => $match['score'], 'applied_at' => now(), 'last_activity_at' => now(), 'source' => 'Direct Candidate Portal']
        );

        // Notify employer
        $employerUser = $job->company?->users()->first();
        if ($employerUser) {
            app(NotificationService::class)->send(
                $employerUser,
                'applicant_alert',
                "New Application: {$user->name}",
                "{$user->name} applied for {$job->title} ({$match['score']}% match)",
                ['job_id' => $job->id, 'application_id' => $application->id]
            );
        }

        return back()->with('success', "Application for {$job->title} submitted successfully with a {$match['score']}% AI Match score!");
    }

    public function withdraw(JobApplication $application): RedirectResponse
    {
        abort_unless(auth()->user()?->hasRole('job-seeker'), 403);
        abort_unless($application->candidate_id === auth()->id(), 403);

        $application->update(['status' => 'Withdrawn', 'last_activity_at' => now()]);
        return back()->with('success', 'Application withdrawn.');
    }
}