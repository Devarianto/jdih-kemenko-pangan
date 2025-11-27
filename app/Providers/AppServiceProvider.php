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
        if ($this->app->environment('fe') != true) {
            $this->app->register(\Intervention\Image\ImageServiceProvider::class);
            $this->app->register(\Cactuar\Admin\CactuarAdminServiceProvider::class);
        }
    }
}
