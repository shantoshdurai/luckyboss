<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\JobController;
use App\Http\Controllers\Api\V1\PortalController;
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
    Route::post('/auth/employers/register', [AuthController::class, 'registerEmployer']);
    Route::get('/jobs', [JobController::class, 'index'])->name('api.v1.jobs.index');
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('api.v1.jobs.show');
    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('/navigation', NavigationController::class);
        Route::get('/job-seeker/dashboard', [PortalController::class, 'seekerDashboard']);
        Route::post('/job-seeker/jobs/{job}/apply', [PortalController::class, 'apply']);
        Route::get('/employer/dashboard', [PortalController::class, 'employerDashboard']);
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
