<?php

namespace Pharaoh\Paytool;

use Illuminate\Foundation\AliasLoader;

class PaytoolServiceProvider
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
