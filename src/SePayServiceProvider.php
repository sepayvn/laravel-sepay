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
        $this->publishes([
            __DIR__.'/../config/sepay.php' => config_path('sepay.php'),
        ]);
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'courier');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ]);
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
