<?php

namespace Pharaoh\Paytool\Tests;

use Illuminate\Support\Facades\Event;
use Pharaoh\Paytool\Events\PayNoticeEvent;
use Pharaoh\Paytool\Facades\Paytool;

class OrderControllerTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * 測試 付款確認回戳
     *
     * @see \Pharaoh\Paytool\Http\Controllers\OrderController::payNotice()
     */
    public function testPayNotice()
    {
        // Arrange
        Paytool::routes();

        // 模擬綠界回戳的參數資料
        $params = [
            "PaymentType" => "BARCODE_BARCODE",
            "RtnMsg" => "付款成功",
            "SimulatePaid" => "1",
            "CustomField2" => null,
            "PaymentDate" => "2021/10/13 11:57:54",
            "TradeNo" => "2110131157040659",
            "TradeAmt" => "2000",
            "MerchantID" => "2000132",
            "StoreID" => null,
            "CustomField3" => null,
            "MerchantTradeNo" => "UG1634097418",
            "CustomField4" => null,
            "CheckMacValue" => "C64C01BEB00224EE9F1FC463B5617435A10C2B3A1204AF558086CAD07416314F",
            "TradeDate" => "2021/10/13 11:57:04",
            "CustomField1" => null,
            "RtnCode" => "1",
            "PaymentTypeChargeFee" => "0"
        ];

        Event::fake();

        // Act
        $response = $this->post('/paytool/pay-notice', $params);

        // Assert
        $this->assertEquals('1|OK', $response->content());

        Event::assertDispatched(PayNoticeEvent::class);

        Event::assertDispatched(function (PayNoticeEvent $event) use ($params) {
            return $event->params === $params;
        });
    }
}
