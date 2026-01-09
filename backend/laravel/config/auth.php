<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
<<<<<<< HEAD
        'guard' => 'web',
        'passwords' => 'users',
    ],
=======
    'guard' => 'web',
],
>>>>>>> 9355417c7faa822932c453e26ca20dc29b33da27

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [

<<<<<<< HEAD
        // FRONTEND (SESSION / BLADE / PHP)
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // API (JWT)
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
=======
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
>>>>>>> 9355417c7faa822932c453e26ca20dc29b33da27
    ],

    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],



    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
