<?php
return [
    'etranzact' => [
        'tid' => [
            'live' => env('ET_TID_LIVE'),
            'test' => env('ET_TID_TEST'),
        ],
        'pin_enc' => [
            'live' => env('ET_PIN_ENC_LIVE'),
            'test' => env('ET_PIN_ENC_TEST'),
        ],
        'url' => [
            'live' => env('ET_URL_LIVE'),
            'test' => env('ET_URL_TEST'),
        ]
    ],

    'spout' => [
        'token' => env('SPOUT_TOKEN'),
        'key' => env('SPOUT_API_KEY'),
        'email' => 'info@linkspectech.com',
        'identifier' => env('SPOUT_IDENTIFIER'),
        'pin' => env('SPOUT_PIN'),
        'url' => [
            'live' => env('SPOUT_URL_LIVE'),
            'test' => env('SPOUT_URL_TEST'),
        ]
    ]
];
