<?php

namespace Baufragen\Sdk;

use Baufragen\Sdk\Services\UserService;
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
        $this->app->singleton('baufragen.userService', function() {
            return new UserService();
        });
    }

}