<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Hashing\Hasher;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // ...
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // PROVIDER PASSWORD PLAIN TEXT
        Auth::provider('plain', function ($app, array $config) {
            return new class($app['hash'], $config['model']) extends \Illuminate\Auth\EloquentUserProvider {

                public function validateCredentials($user, array $credentials)
                {
                    // Password tanpa hash (langsung dicocokkan)
                    return $user->password === $credentials['password'];
                }

            };
        });
    }
}
    