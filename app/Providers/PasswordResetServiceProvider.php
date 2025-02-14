<?php

namespace App\Providers;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Password;

class PasswordResetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Password::createTokenUsing(function ($user) {
            // Here you can create the token logic, just returning user data for simplicity.
            return $user;
        });
    }

    public function register()
    {
        $this->app->bind(PasswordBroker::class, function ($app) {
            return new PasswordBroker(
                $app['auth.password.tokens'],
                $app['hash'],
                $app['config']['auth.passwords.users'],
                $app['mailer']
            );
        });
    }
}
