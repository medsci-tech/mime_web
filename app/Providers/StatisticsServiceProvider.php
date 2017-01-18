<?php

namespace App\Providers;

use App\Helpers\Statistics\Statistics;
use Illuminate\Support\ServiceProvider;

class StatisticsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('statistics', function ($app) {
            return new Statistics();
        });
    }
}