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
            ], 'sepay-views');
            $this->publishes([
                __DIR__.'/../database/migrations/create_sepay_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_sepay_table.php'),
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
