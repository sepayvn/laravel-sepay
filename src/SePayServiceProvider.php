<?php

namespace SePay\SePay;

use Illuminate\Support\ServiceProvider;

class SePayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sepay.php', 'sepay');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sepay');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/sepay.php' => config_path('sepay.php'),
            ], 'sepay-config');
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/sepay'),
            ], 'sepay-config');
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/sepay'),
            ], 'sepay-config');
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'sepay-migrations');
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/sepay.php', 'sepay'
        );
    }
}
