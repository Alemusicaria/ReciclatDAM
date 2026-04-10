<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
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
   

public function boot()
{
    Gate::policy(User::class, UserPolicy::class);

    $locale = Session::get('locale', config('app.locale'));

    // Agregar log para depuración
    Log::info("AppServiceProvider - Locale obtenido: " . print_r($locale, true));

    if (is_string($locale) && in_array($locale, config('app.available_locales'))) {
        App::setLocale($locale);
    }
}
}
