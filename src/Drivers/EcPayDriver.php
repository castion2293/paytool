<?php

namespace Pharaoh\Paytool\Drivers;

use Illuminate\Support\Arr;
use Pharaoh\Paytool\Sdk\EcPay\ECPay_AllInOne;
use Pharaoh\Paytool\Exceptions\PaytoolException;

class EcPayDriver extends AbstractDriver
{
    public function __construct()
    {
        $this->settings = config('paytool.driver.ec_pay');
    }

    /**
     * 建立金流訂單
     *
     * @return mixed|void
     * @throws PaytoolException
     */
    public function createOrder(array $params)
    {
        try {
            $obj = new ECPay_AllInOne();

            //服務參數
            $obj->ServiceURL = Arr::get($this->settings, 'service_url');
            $obj->HashKey = Arr::get($this->settings, 'hash_key');
            $obj->HashIV = Arr::get($this->settings, 'hash_iv');
            $obj->MerchantID = Arr::get($this->settings, 'merchant_id');
            $obj->EncryptType = Arr::get($this->settings, 'encrypt_type');

            //基本參數(請依系統規劃自行調整)
            $obj->Send['ReturnURL'] = config('app.url') . '/pay-notice';
            $obj->Send['MerchantTradeNo'] = Arr::get($params, 'merchant_trade_no');
            $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
            $obj->Send['TotalAmount'] = Arr::get($params, 'total_amount');
            $obj->Send['TradeDesc'] = Arr::get($params, 'trade_desc');
            $obj->Send['ChoosePayment'] = Arr::get($params, 'choose_payment');

            //訂單的商品資料
            array_push(
                $obj->Send['Items'],
                [
                    'Name' => Arr::get($params, 'name', ''),
                    'Price' => (int)Arr::get($params, 'price', 0),
                    'Currency' => Arr::get($params, 'currency', "元"),
                    'Quantity' => (int)Arr::get($params, 'quantity', 1),
                ]
            );

            //Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
            //以下參數不可以跟信用卡定期定額參數一起設定
            $obj->SendExtend['CreditInstallment'] = '' ;    //分期期數，預設0(不分期)，信用卡分期可用參數為:3,6,12,18,24
            $obj->SendExtend['InstallmentAmount'] = 0 ;    //使用刷卡分期的付款金額，預設0(不分期)
            $obj->SendExtend['Redeem'] = false ;           //是否使用紅利折抵，預設false
            $obj->SendExtend['UnionPay'] = false;          //是否為聯營卡，預設false;

            //產生訂單(auto submit至ECPay)
            $obj->CheckOut();
        } catch (\Exception $exception) {
            throw new PaytoolException($exception->getMessage());
        }
    }
}
