<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }

    public function boot()
    {
        $this->app->bind(
            'App\Exports\Contracts\ReportExportInterface',
            'App\Exports\ReportExport'
        );
    }
}
