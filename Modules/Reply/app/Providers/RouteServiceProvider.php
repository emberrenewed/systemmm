<?php

namespace Modules\Reply\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    // public function boot(): void
    // {
    //     parent::boot();
    // }

    public function map(): void
    {
        $this->ApiRoutes();
        $this->WebRoutes();
    }

    protected function WebRoutes(): void
    {
        Route::middleware('web')->group(base_path('Modules/Reply/routes/web.php'));
    }

    protected function ApiRoutes(): void
    {
        Route::middleware('api')->prefix('api')->name('api.')->group(base_path('Modules/Reply/routes/api.php'));
    }
}
