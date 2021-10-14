<?php

namespace Pharaoh\Paytool\Drivers;

abstract class AbstractDriver implements DriverInterface
{
    /**
     * 支付工具的設定參數
     *
     * @var array
     */
    protected $settings = [];

    /**
     * 支付工具代碼
     *
     * @var string
     */
    protected $vendorCode = '';
}
