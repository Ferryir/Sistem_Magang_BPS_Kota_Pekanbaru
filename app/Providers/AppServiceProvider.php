<?php

namespace App\Providers;

use App\Guards\PegawaiSessionGuard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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
        Carbon::setLocale('id');

        // Register the custom guard
        Auth::extend('pegawai', function ($app, $name, array $config) {
            $provider = Auth::createUserProvider($config['provider']);

            return new PegawaiSessionGuard($name, $provider, $app['session.store'], $app['request']);
        });
    }
}
