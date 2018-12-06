<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'stripe' => [
      'model' => App\Models\Guest::class,
      'key' => env('STRIPE_KEY'),
      'secret' => env('STRIPE_SECRET'),
      'plans' => [
        'PlanName' => [
          'id' => '####',
          'name' => 'Exemple',
        ],
      ]
    ],

];
