<?php

namespace Modules\Reply\Providers;

use Illuminate\Support\ServiceProvider;

class ReplyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(base_path('Modules/Reply/database/migrations'));
        $this->loadViewsFrom(base_path('Modules/Reply/resources/views'), 'reply');
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
