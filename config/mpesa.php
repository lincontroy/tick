<?php

return [
    'env' => env('MPESA_ENV', 'sandbox'),
    
    'sandbox' => [
        'consumer_key' => env('MPESA_CONSUMER_KEY'),
        'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
        'shortcode' => env('MPESA_BUSINESS_SHORTCODE'),
        'passkey' => env('MPESA_PASSKEY'),
        'callback_url' => env('MPESA_CALLBACK_URL'),
    ],
    
    'production' => [
        'consumer_key' => env('MPESA_CONSUMER_KEY'),
        'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
        'shortcode' => env('MPESA_BUSINESS_SHORTCODE'),
        'passkey' => env('MPESA_PASSKEY'),
        'callback_url' => env('MPESA_CALLBACK_URL'),
    ],
];