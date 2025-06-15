<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Livewire\Mechanisms\FrontendAssets\FrontendAssets;

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
        if (app()->environment('local')) {
            URL::forceScheme('https');

            // Set custom script route for Livewire when using ngrok
            FrontendAssets::use(function () {
                return [
                    'js' => 'https://624d-118-101-168-70.ngrok-free.app/livewire/livewire.js',
                ];
            });
        }
    }
}
