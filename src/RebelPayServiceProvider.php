<?php

namespace Rebel\RebelPay;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Rebel\RebelPay\Commands\RebelPayCommand;

class RebelPayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('rebel-rebelpay')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_rebel-rebelpay_table')
            ->hasCommand(RebelPayCommand::class);
    }
}
