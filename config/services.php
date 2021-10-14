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
            'pubic' => 'pub_test_t4FgtjamokNSyaEr7mccPFrZQyiTFFlX',
            'private' => 'prv_test_XZQDovyp2M2v9X6TWSLIbM8TkHHOWLxR',
            'events' => 'test_events_ieX3KzX5awW8VUVSpLPasfnUFWhSdMT8',
            'endpoint' => ''
        ],
        'prod' => [
            'public' => '',
            'private' => '',
            'events' => '',
            'endpoint' => ''
        ]
    ]

];
