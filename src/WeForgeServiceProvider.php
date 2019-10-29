<?php

declare(strict_types=1);

namespace WeForge;

use Illuminate\Support\ServiceProvider;

class WeForgeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        WeForge::$runningInLaravel = true;
    }
}
