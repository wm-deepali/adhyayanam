<?php

return [
    //These are for the Marketplace
    'appID' => env('APP_ID'),
    'secretKey' => env('SECRET_KEY'),
    'testURL' => 'https://ces-gamma.cashfree.com',
    'prodURL' => 'https://ces-api.cashfree.com',
    'maxReturn' => 100, //this is for request pagination
    'isLive' => false,

    //For the PaymentGateway.
    'PG' => [
        'appID' => env('APP_ID'),
        'secretKey' => env('SECRET_KEY'),
        'testURL' => 'https://test.cashfree.com',
        'prodURL' => 'https://api.cashfree.com',
        'isLive' => false
    ]
];
