<?php

namespace Modules\Ticket\Providers;

use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(base_path('Modules/Ticket/database/migrations'));
        $this->loadViewsFrom(base_path('Modules/Ticket/resources/views'), 'ticket');
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
