<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Http\Middleware\EnsureUserIsAdmin;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(base_path('Modules/Auth/database/migrations'));
        $this->loadViewsFrom(base_path('Modules/Auth/resources/views'), 'auth');

    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
