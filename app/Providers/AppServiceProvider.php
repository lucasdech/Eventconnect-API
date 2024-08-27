<?php

namespace App\Providers;

use App\Guards\JwtGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::extend('jwt', function (Application $app, string $name, array $config) {
            $userProvider = Auth::createUserProvider($config['provider']);
        
            if (!$userProvider) {
                // Handle the null case, e.g., throw an exception or provide a default UserProvider
                throw new \Exception("User provider cannot be null.");
            }
        
            return new JwtGuard(
                $userProvider,
                $app->make('request')
            );
        });
    }
}
