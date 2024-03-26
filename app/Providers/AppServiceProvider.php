<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        /** set time zone */
        $generalSettings = GeneralSetting::first();
        Config::set('app.timezone', $generalSettings->time_zone);

        /** Share variable at all view */
        View::composer('*', function($view) use ($generalSettings) {
          $view->with('settings', $generalSettings );
        });
    }
}
