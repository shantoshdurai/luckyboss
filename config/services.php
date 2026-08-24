<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'firebase' => [
        'project_id' => env('FIREBASE_PROJECT_ID', 'luckyboss-617d2'),
        'project_number' => env('FIREBASE_PROJECT_NUMBER', '655783263537'),
        'api_key' => env('FIREBASE_API_KEY', 'AIzaSyBIqaS9NX_hNPWMvOVehnaBC8cask2GxlI'),
        'storage_bucket' => env('FIREBASE_STORAGE_BUCKET', 'luckyboss-617d2.firebasestorage.app'),
        'apps' => [
            'employer' => 'com.app.luckybossemployer',
            'seeker' => 'com.userapp.luckyboss',
        ],
    ],

];
