<?php

declare(strict_types=1);

namespace WeForge\Integrations\Laravel;

use Illuminate\Support\ServiceProvider;
use WeForge\WeForge;

class WeForgeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config.php', 'weforge'
        );
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
