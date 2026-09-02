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

        // Whether this plan may see contact details at all. Spec §14: "Phone
        // and email should be shown based on package permission and candidate
        // privacy rules." This used to be hardcoded true, so every plan saw
        // every number and the contact-view limit sold in the packages meant
        // nothing.
        $entitlements = $company->subscriptions()
            ->where('status', 'active')
            ->whereDate('expires_at', '>=', today())
            ->latest('expires_at')
            ->value('entitlements') ?? [];

        $maySeeContacts = (int) data_get($entitlements, 'candidate_views', 0) !== 0;

        $candidates = $query->latest('applied_at')->get()->map(function ($app) use ($maySeeContacts) {
            $profile = $app->candidate?->candidateProfile;

            // NOTHING BELOW IS INVENTED.
            //
            // This map used to substitute a default for every missing field: a
            // phone number of "+65 8000 0000", an email of
            // "applicant@example.com", "3 yrs" of experience, a location of
            // "Singapore", skills of ["General"] and an AI match score of 85.
            // An employer saw a complete, confident profile of a person who had
            // filled in almost none of it, and would have dialled a number that
            // belongs to nobody.
            //
            // A missing field is now null, and the app shows "Not provided".
            // An incomplete profile is a fact the employer needs — it is the
            // difference between a candidate worth calling and one worth
            // chasing for details first.
            return [
                'id' => 'cand-' . $app->id,
                // The real application id, so the portal can act on this
                // candidate — draft a letter, move their stage — without
                // parsing it back out of a display string.
                'application_id' => $app->id,
                'job_id' => $app->job_id,
                'job_title' => $app->job?->title,
                'candidate_name' => $app->candidate?->name,
                'candidate_phone' => $maySeeContacts ? $app->candidate?->phone : null,
                'candidate_email' => $maySeeContacts ? $app->candidate?->email : null,
                'headline' => $profile?->headline,
                'current_title' => $profile?->current_title,
                'years_experience' => $profile?->years_experience === null ? null : (int) $profile->years_experience,
                'location' => $profile?->current_location,
                'skills' => is_array($profile?->skills) ? $profile->skills : [],
                'languages' => is_array($profile?->languages) ? $profile->languages : [],
                'availability' => $profile?->availability,
                // Null rather than a flattering default. A score of 85 that
                // nothing computed is the most persuasive number on the screen
                // and the least true.
                // Cast, because the column is `numeric` and SQLite hands it
                // back as a string — which a typed client parses as null and
                // then renders as "no match".
                'ai_match_score' => $app->match_score === null ? null : (float) $app->match_score,
                'status' => $app->status,
                'source' => 'applied',
                'contact_revealed' => $maySeeContacts,
                'profile_completion' => $profile?->profile_completion,
                'applied_at' => $app->applied_at,
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