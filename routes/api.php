<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\JobController;
use App\Http\Controllers\Api\V1\PortalController;
use App\Http\Controllers\Api\V1\ProfilePhotoController;
use App\Http\Controllers\Api\V1\ResumeParseController;
use App\Http\Controllers\Api\V1\SeekerProfileController;
use App\Http\Controllers\Api\V1\SkillController;
use App\Http\Controllers\Api\V1\NavigationController;
use App\Http\Controllers\Api\V1\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/ai-chat', \App\Http\Controllers\Api\AiChatController::class);

Route::prefix('v1')->group(function (): void {
    Route::post('/webhooks/payments/{gateway}', [WebhookController::class,'payment'])->middleware('throttle:30,1');
    Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::post('/auth/job-seekers/register', [AuthController::class, 'registerSeeker']);
    // Read-only demo sign-in for the mobile "See how it works" button.
    Route::post('/auth/demo', [AuthController::class, 'demo'])->middleware('throttle:10,1');
    Route::post('/auth/employers/register', [AuthController::class, 'registerEmployer']);
    // Skill taxonomy. Public: the onboarding wizard runs these before a
    // candidate has finished creating their profile, and they expose no user data.
    Route::get('/skills/search', [SkillController::class, 'search'])->middleware('throttle:120,1');
    Route::get('/skills/suggested', [SkillController::class, 'suggested'])->middleware('throttle:60,1');
    Route::post('/skills/related', [SkillController::class, 'related'])->middleware('throttle:60,1');

    Route::get('/jobs', [JobController::class, 'index'])->name('api.v1.jobs.index');
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('api.v1.jobs.show');
    Route::post('/jobs', [PortalController::class, 'postEmployerJob']);
    Route::post('/employer/jobs', [PortalController::class, 'postEmployerJob']);

    // demo.readonly refuses POST/PUT/PATCH/DELETE from the demo account. It sits
    // on the group rather than on individual routes so a future write endpoint is
    // covered by default instead of being forgotten (spec section 93).
    Route::middleware(['auth:sanctum', 'demo.readonly'])->group(function (): void {
        Route::get('/navigation', NavigationController::class);
        Route::get('/job-seeker/dashboard', [PortalController::class, 'seekerDashboard']);
        // The profile the app reads on launch and writes on every edit. Without
        // these the wizard's answers lived only in memory.
        Route::get('/job-seeker/profile', [SeekerProfileController::class, 'show']);
        Route::put('/job-seeker/profile', [SeekerProfileController::class, 'update']);
        Route::post('/job-seeker/jobs/{job}/apply', [PortalController::class, 'apply']);
        // Vision parsing is gated on two admin flags inside the controller —
        // see spec section 93 on server-side entitlement checks.
        Route::post('/resume/parse', ResumeParseController::class)->middleware('throttle:10,1');
        Route::post('/job-seeker/photo', [ProfilePhotoController::class, 'store']);
        Route::delete('/job-seeker/photo', [ProfilePhotoController::class, 'destroy']);
        Route::get('/employer/dashboard', [PortalController::class, 'employerDashboard']);
        Route::get('/employer/candidates', [PortalController::class, 'employerCandidates']);
        Route::get('/employer/jobs/{job}/candidates', [PortalController::class, 'employerCandidates']);
        Route::put('/employer/candidates/{application}/status', [PortalController::class, 'updateCandidateStatus']);
        Route::post('/fcm-token', function (Request $request) {
            $request->validate([
                'fcm_token' => 'required|string',
                'device_type' => 'nullable|string|max:30',
            ]);
            $request->user()->update([
                'fcm_token' => $request->input('fcm_token'),
                'device_type' => $request->input('device_type', 'android'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'FCM device token registered successfully.',
            ]);
        });
    });
});
