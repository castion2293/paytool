<?php

namespace Pharaoh\Paytool\Tests;

use Illuminate\Support\Str;
use Pharaoh\Paytool\Facades\Paytool;

class PaytoolTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * 測試 建立訂單跳轉URL
     *
     * @see \Pharaoh\Paytool\Paytool::createOrderTempUrl
     */
    public function testCreateOrderTempUrl()
    {
        // Arrange
        Paytool::routes();

        $params = [
            'merchant_trade_no' => Str::random(2) . time(),
            'total_amount' => 2000,
            'trade_desc' => '交易描述',
            'choose_payment' => 'Credit',
            'name' => '歐付寶黑芝麻豆漿',
            'price' => '2000',
            'currency' => '元',
            'quantity' => '1',
        ];

        // Act
        $url = Paytool::vendor('ec_pay')->createOrderTempUrl($params);

        // Assert
        $this->assertTrue(filter_var($url, FILTER_VALIDATE_URL) !== false);
    }
}
