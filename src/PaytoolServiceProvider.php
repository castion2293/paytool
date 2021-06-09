<?php

namespace Pharaoh\Paytool;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class PaytoolServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        parent::register();

        $loader = AliasLoader::getInstance();
        $loader->alias('paytool', 'Pharaoh\Paytool\Paytool');
    }
}
