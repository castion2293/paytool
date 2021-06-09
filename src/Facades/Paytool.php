<?php

namespace Pharaoh\Paytool\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Paytool
 *
 * @see \Pharaoh\Paytool\Paytool
 */
class Paytool extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        // 回傳 alias 的名稱
        return 'paytool';
    }
}
