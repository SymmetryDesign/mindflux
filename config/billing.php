<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | Here you can set the default subscription billing service driver. This
    | package ships with two drivers which are braintree and stripe.
    |
    */

    'gateway' => env('BILLING_GATEWAY', 'stripe'),

    /*
    |--------------------------------------------------------------------------
    | Billing Service Driver
    |--------------------------------------------------------------------------
    |
    | Here are each of the billing service driver setup for your application.
    | Of course, examples of configuring each billing service that is
    | supported by this package is shown below.
    |
    */

    'drivers' => [
        'braintree' => [
            'environment' => env('BRAINTREE_ENV', 'sandbox'),
            'merchant_id' => env('BRAINTREE_MERCHANT_ID'),
            'public_key'  => env('BRAINTREE_PUBLIC_KEY'),
            'private_key' => env('BRAINTREE_PRIVATE_KEY'),
        ],

        'stripe' => [
            'publishable'    => env('STRIPE_PUBLISHABLE_KEY'),
            'secret'         => env('STRIPE_SECRET_KEY'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        ]
    ]
];
