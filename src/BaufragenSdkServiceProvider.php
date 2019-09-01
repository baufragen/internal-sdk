<?php

namespace Baufragen\Sdk;

use Illuminate\Support\ServiceProvider;

class BaufragenSdkServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/baufragensdk.php' => config_path('baufragensdk.php'),
        ], 'baufragensdk');

        $this->mergeConfigFrom(
            __DIR__.'/config/baufragensdk.php', 'baufragensdk'
        );
    }

    public function register()
    {
        $this->app->singleton('baufragen.container', function() {
            return new DataSyncContainer();
        });
    }

}