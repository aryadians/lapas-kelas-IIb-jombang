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

    'google' => [
        'tts' => [
            'credentials' => env('GOOGLE_APPLICATION_CREDENTIALS'),
            'language_code' => env('GOOGLE_TTS_LANG', 'id-ID'),
            'voice' => env('GOOGLE_TTS_VOICE', 'id-ID-Wavenet-A'),
            'speaking_rate' => (float) env('GOOGLE_TTS_RATE', 1.0),
            'pitch' => (float) env('GOOGLE_TTS_PITCH', 0.0),
        ],
    ],

];
