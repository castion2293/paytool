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

    /**
     * 處理付款成功回傳資訊
     *
     * @param array $params
     * @return array
     */
    public function handleResponseData(array $params);
}
