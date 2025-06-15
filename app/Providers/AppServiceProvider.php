<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Livewire\Livewire;
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
            Livewire::setScriptRoute(function () {
                return 'https://a605-118-101-168-70.ngrok-free.app/livewire/livewire.js';
            });
        }
    }
}
