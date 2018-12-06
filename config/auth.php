<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Authentication Defaults
  |--------------------------------------------------------------------------
  |
  | This option controls the default authentication "guard" and password
  | reset options for your application. You may change these defaults
  | as required, but they're a perfect start for most applications.
  |
  */





  'defaults' => [
    'guard' => 'frontuser',
    'passwords' => 'frontuser',
  ],

  /*
  |--------------------------------------------------------------------------
  | Authentication Guards
  |--------------------------------------------------------------------------
  |
  | Next, you may define every authentication guard for your application.
  | Of course, a great default configuration has been defined for you
  | here which uses session storage and the Eloquent user provider.
  |
  | All authentication drivers have a user provider. This defines how the
  | users are actually retrieved out of your database or other storage
  | mechanisms used by this application to persist your user's data.
  |
  | Supported: "session", "token"
  |___
      |----------------------------------------------------------------------
      | Guards's architecture
      |----------------------------------------------------------------------
      |
      | guest                    =>  guest
      | user                     =>  frontuser
      | seller/shopkeeper        =>  backuser
      | administrator            =>  admin
      | superAdministrator/root  =>  master
      |
      */

  'guards' => [
    /*-----------------
     |   WEB Guards   |
     -----------------*/
    'frontuser'  => [
      'driver' => 'session',
      'provider' => 'frontuser',

      'api' => [
        'driver' => 'token',
        'provider' => 'frontuser',
      ]
    ],
    /*TAG_GUARDS_WEB*/


    /*-----------------
     |   API Guards   |
     -----------------*/
    /*TAG_GUARDS_API*/
  ],

  /*
  |--------------------------------------------------------------------------
  | Web & Api Providers
  |--------------------------------------------------------------------------
  |
  | All authentication drivers have a user provider. This defines how the
  | users are actually retrieved out of your database or other storage
  | mechanisms used by this application to persist your user's data.
  |
  | If you have multiple user tables or models you may configure multiple
  | sources which represent each model / table. These sources may then
  | be assigned to any extra authentication guards you have defined.
  |
  | Supported: "database", "eloquent"
  |
  */

  'providers' => [
    'frontuser'  => [
      'driver' => 'eloquent',
      'model' => App\Models\Frontuser::class,
    ],
    /*TAG_PROVIDERS*/
  ],

  /*
  |--------------------------------------------------------------------------
  | Resetting Passwords
  |--------------------------------------------------------------------------
  |
  | You may specify multiple password reset configurations if you have more
  | than one user table or model in the application and you want to have
  | separate password reset settings based on the specific user types.
  |
  | The expire time is the number of minutes that the reset token should be
  | considered valid. This security feature keeps tokens short-lived so
  | they have less time to be guessed. You may change this as needed.
  |
  */

  'passwords' => [
    'frontuser'  => [
      'provider' => 'frontuser',
      'table' => 'frontusers_password_resets',
      'expire' => '60',
    ],
    /*TAG_PASSWORDS*/
  ],

];
