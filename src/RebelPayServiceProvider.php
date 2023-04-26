<?php

namespace Rebel\RebelPay;

use Rebel\RebelPay\Commands\RebelPayCommand;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            // ->hasViews()
            // ->hasMigration('create_rebel-rebelpay_table')
            ->publishesServiceProvider('RebelPayServiceProvider')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub('RebelNii/Rebel-RebelPay');
            })
            ->hasCommand(RebelPayCommand::class);
    }
}
