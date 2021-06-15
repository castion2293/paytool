<?php

namespace Pharaoh\Paytool\Drivers;

interface DriverInterface
{
    /**
     * 建立金流訂單
     *
     * @return mixed
     */
    public function createOrder(array $params);
}
