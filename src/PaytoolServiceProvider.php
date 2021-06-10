<?php

namespace Pharaoh\Paytool;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class PaytoolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/paytool.php', 'paytool');

        $this->publishes(
            [
                __DIR__ . '/../config/paytool.php' => config_path('paytool.php')
            ],
            'paytool-config'
        );
    }

    public function register()
    {
        parent::register();

        $loader = AliasLoader::getInstance();
        $loader->alias('paytool', 'Pharaoh\Paytool\Paytool');
    }
}
