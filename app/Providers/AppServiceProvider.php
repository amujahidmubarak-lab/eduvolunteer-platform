<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
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
        \Illuminate\Support\Facades\View::composer('layouts.dashboard', function ($view) {
            $unreadNotifications = collect();
            if (auth()->check()) {
                $unreadNotifications = auth()->user()->unreadNotifications;
            }
            $view->with('unreadNotifications', $unreadNotifications);
        });

        // Catch N+1 queries and mass assignment issues during development
        Model::preventLazyLoading(!app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());
    }
}
