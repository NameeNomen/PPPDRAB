<?php

namespace App\Providers;
use Illuminate\Support\Facades\URL;
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
    URL::forceScheme('https');
    if (env('CODESPACE_NAME')) {
            URL::forceRootUrl('https://' . env('CODESPACE_NAME') . '-8000.app.github.dev');
            URL::forceScheme('https');
        }
    
}
}
