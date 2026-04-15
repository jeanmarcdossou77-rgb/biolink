<?php

namespace App\Providers;

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
    if (config('app.env') === 'production') {
        \URL::forceScheme('https');
    }

    // Créer le lien storage si manquant
    $storagePath = public_path('storage');
    if (!file_exists($storagePath)) {
        try {
            \Artisan::call('storage:link');
        } catch (\Exception $e) {
            // Ignorer si déjà existant
        }
    }
}
}
