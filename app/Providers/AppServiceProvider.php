<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Livewire\Mechanisms\FrontendAssets\FrontendAssets;
use Livewire\Livewire;

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
            \Illuminate\Support\Facades\URL::forceScheme('https');

            // This will tell Livewire where to load its script from (your ngrok URL)
            Livewire::setScriptRoute(function () {
                return 'https://624d-118-101-168-70.ngrok-free.app/livewire/livewire.js';
            });
        }
    }
}
