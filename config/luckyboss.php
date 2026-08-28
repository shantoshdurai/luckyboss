<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Public demo account
    |---------------------------------------------------------------------------
    |
    | Powers the "See how it works" button on the mobile sign-in screen. The
    | account is a real, seeded, read-only candidate — writes are refused by the
    | BlockDemoWrites middleware, not by hiding buttons in the app.
    |
    | Set LUCKYBOSS_DEMO_ENABLED=false in production if the demo should not be
    | reachable there; POST /api/v1/auth/demo then returns 404.
    |
    */

    'demo_account_enabled' => env('LUCKYBOSS_DEMO_ENABLED', true),

    'demo_email' => env('LUCKYBOSS_DEMO_EMAIL', 'candidate@luckyboss.test'),

    /*
    |---------------------------------------------------------------------------
    | Profile photo uploads
    |---------------------------------------------------------------------------
    |
    | Candidates attach a photo from the camera or the device gallery. Limits
    | are enforced server-side; the client's own compression is a courtesy to
    | the user's data plan, never a security control.
    |
    | 'disk' is deliberately configurable: local disk today, swap to 's3' with
    | no code change once a bucket exists.
    |
    */

    'profile_photo' => [
        'disk' => env('LUCKYBOSS_PHOTO_DISK', 'public'),
        'path' => 'profile-photos',

        // Kilobytes. A phone camera JPEG is comfortably under this once the
        // client downscales; the ceiling stops someone posting a 40MB raw file.
        'max_kb' => (int) env('LUCKYBOSS_PHOTO_MAX_KB', 5120),

        // Longest edge, in pixels, after server-side downscaling.
        'max_dimension' => (int) env('LUCKYBOSS_PHOTO_MAX_DIMENSION', 1024),

        'mimes' => ['jpeg', 'jpg', 'png', 'webp'],
    ],

];
