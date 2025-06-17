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
        // URL::forceScheme('https');
         if (app()->environment('local')) {
            \URL::forceScheme('https');
        }
    }
}
