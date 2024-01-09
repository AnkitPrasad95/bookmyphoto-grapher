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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook'      => [
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => env('FACEBOOK_CALLBACK_URL')
    ],

    'google' => [
        'client_id' => '532250156495-dnnqc1dplcdo0nf4ivpu4cdh09mrjhr6.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://gautamgupta.info/auth/google/callback',
    ],
    
    // config/services.php
    'mailjet' => [
        'key' => env('MAILJET_APIKEY_PUBLIC'),
        'secret' => env('MAILJET_APIKEY_PRIVATE'),
    ],

];
