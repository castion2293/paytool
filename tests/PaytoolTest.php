<?php

namespace Pharaoh\Paytool\Tests;

use Pharaoh\Paytool\Facades\Paytool;

class PaytoolTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * 測試 建立訂單跳轉URL
     */
    public function testCreateOrderTempUrl()
    {
        // Arrange
        Paytool::routes();

        $params = [
            'order_id' => 123
        ];

        // Act
        $url = Paytool::vendor('ec_pay')->createOrderTempUrl($params);
        dump($url);
        // Assert
    }
}
