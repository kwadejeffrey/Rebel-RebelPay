<?php

namespace Rebel\RebelPay;

use Rebel\RebelPay\Commands\RebelPayCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class RebelPayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */

        $question = new ConfirmationQuestion('Would you like to star our package repository? (y/n) ', false);

        if ($this->app->runningInConsole() && $this->getHelper('question')->ask($this->app->make('Illuminate\Console\OutputStyle'), $question)) {
            exec('open https://github.com/RebelNii/Rebel-RebelPay');
        }
        $package
            ->name('rebel-rebelpay')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_rebel-rebelpay_table')
            ->hasCommand(RebelPayCommand::class);
    }
}
