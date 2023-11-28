<?php

namespace SePay\SePay;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use SePay\SePay\Commands\SePayCommand;

class SePayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-sepay')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-sepay_table')
            ->hasCommand(SePayCommand::class);
    }
}
