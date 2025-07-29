<?php

namespace Aci\EmployeeReports;

use Illuminate\Support\ServiceProvider;

class EmployeeReportsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'employeereports');
        $this->publishes([
            __DIR__ . '/../config/employeereports.php' => config_path('employeereports.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/employeereports.php',
            'employeereports'
        );

        $this->app->singleton('employeereports', function () {
            return new EmployeeReports();
        });
    }
}
