<?php

namespace Wepa\Surveys;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Wepa\Surveys\Commands\SurveysInstallCommand;

class SurveysServiceProvider extends PackageServiceProvider
{
    public function bootingPackage()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Pages
        $this->publishes([
            __DIR__.'/../resources/js/Pages' => resource_path('js/Pages/Vendor/Surveys'),
        ], ['surveys', 'surveys-pages']);

        // Components
//        $this->publishes([
//            __DIR__.'/../resources/js/Components' => resource_path('js/Vendor/Surveys'),
//        ], ['surveys', 'surveys-components']);

//        $this->publishes([
//            __DIR__.'/../tests/Unit' => base_path('tests/Unit/Surveys'),
//            __DIR__.'/../tests/Feature' => base_path('tests/Feature/Surveys'),
//        ], ['surveys-tests']);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('surveys')
            ->hasConfigFile()
            ->hasRoutes(['web', 'admin', 'api'])
            ->hasCommand(SurveysInstallCommand::class);
    }
}
