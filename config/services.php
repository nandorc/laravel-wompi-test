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

    'wompi' => [
        'testMode' => true,
        'sandbox' => [
            'pubic' => env('WOMPI_TEST_PUBLIC'),
            'private' => env('WOMPI_TEST_PRIVATE'),
            'events' => env('WOMPI_TEST_EVENTS'),
            'endpoint' => 'https://sandbox.wompi.co/v1'
        ],
        'prod' => [
            'public' => env('WOMPI_PUBLIC'),
            'private' => env('WOMPI_PRIVATE'),
            'events' => env('WOMPI_EVENTS'),
            'endpoint' => 'https://production.wompi.co/v1'
        ]
    ]

];
