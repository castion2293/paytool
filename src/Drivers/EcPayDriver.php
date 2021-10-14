<?php

namespace Pharaoh\Paytool\Drivers;

use Illuminate\Support\Arr;
use Pharaoh\Paytool\Sdk\EcPay\ECPay_AllInOne;
use Pharaoh\Paytool\Exceptions\PaytoolException;

class EcPayDriver extends AbstractDriver
{
    /**
     * EcPay SDK Object
     *
     * @var
     */
    protected $obj;

    public function __construct()
    {
        $this->settings = config('paytool.driver.ec_pay');
        $this->obj = new ECPay_AllInOne();
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
            //服務參數
            $this->obj->ServiceURL = Arr::get($this->settings, 'service_url');
            $this->obj->HashKey = Arr::get($this->settings, 'hash_key');
            $this->obj->HashIV = Arr::get($this->settings, 'hash_iv');
            $this->obj->MerchantID = Arr::get($this->settings, 'merchant_id');
            $this->obj->EncryptType = Arr::get($this->settings, 'encrypt_type');

            //基本參數(請依系統規劃自行調整)
            $this->obj->Send['ReturnURL'] = config('app.url') . '/paytool/pay-notice';
            $this->obj->Send['MerchantTradeNo'] = Arr::get($params, 'merchant_trade_no');
            $this->obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
            $this->obj->Send['TotalAmount'] = Arr::get($params, 'total_amount');
            $this->obj->Send['TradeDesc'] = Arr::get($params, 'trade_desc');
            $this->obj->Send['ChoosePayment'] = $choosePayment = Arr::get($params, 'choose_payment');

            //訂單的商品資料
            array_push(
                $this->obj->Send['Items'],
                [
                    'Name' => Arr::get($params, 'name', ''),
                    'Price' => (int)Arr::get($params, 'price', 0),
                    'Currency' => Arr::get($params, 'currency', "元"),
                    'Quantity' => (int)Arr::get($params, 'quantity', 1),
                ]
            );

            $functionType = lcfirst(strtolower($choosePayment)) . 'Type';
            if (method_exists($this, $functionType)) {
                $this->$functionType($params);
            }

            //產生訂單(auto submit至ECPay)
            $this->obj->CheckOut();
        } catch (\Exception $exception) {
            throw new PaytoolException($exception->getMessage());
        }
    }

    /**
     * 信用卡付款的專屬參數
     *
     * @param array $params
     */
    private function creditType(array $params)
    {
        //Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
        //以下參數不可以跟信用卡定期定額參數一起設定
        $creditType = Arr::get($this->settings, 'type.Credit');

        //信用卡分期可用參數為:3,6,12,18,24
        //使用刷卡分期的付款金額，預設0(不分期)
        $isCreditInstallmentEnable = Arr::get($creditType, 'credit_installment_enable');
        $this->obj->SendExtend['CreditInstallment'] = $isCreditInstallmentEnable
            ? Arr::get($params, 'credit_installment')
            : '';
        $this->obj->SendExtend['InstallmentAmount'] = $isCreditInstallmentEnable
            ? Arr::get($params, 'installment_amount')
            : 0;

        $this->obj->SendExtend['Redeem'] = Arr::get($creditType, 'redeem');
        $this->obj->SendExtend['UnionPay'] = Arr::get($creditType, 'union_pay');
    }

    /**
     * 自動櫃員機付款的專屬參數
     *
     * @param array $params
     */
    private function atmType(array $params)
    {
        // ATM 延伸參數(可依系統需求選擇是否代入)
        $atmType = Arr::get($this->settings, 'type.ATM');

        $this->obj->SendExtend['ExpireDate'] = Arr::get($atmType, 'expire_date');
        $this->obj->SendExtend['PaymentInfoURL'] = config('app.url') . '/paytool/pay-information';
    }

    /**
     * 超商代碼付款的專屬參數
     *
     * @param array $params
     */
    private function cvsType(array $params)
    {
        // CVS超商代碼延伸參數(可依系統需求選擇是否代入)
        $cvsType = Arr::get($this->settings, 'type.CVS');

        // 交易描述 會顯示在超商繳費平台的螢幕上。預設空值
        $this->obj->SendExtend['Desc_1'] = Arr::get($params, 'desc_1', '');
        $this->obj->SendExtend['Desc_2'] = Arr::get($params, 'desc_2', '');
        $this->obj->SendExtend['Desc_3'] = Arr::get($params, 'desc_3', '');
        $this->obj->SendExtend['Desc_4'] = Arr::get($params, 'desc_4', '');
        $this->obj->SendExtend['PaymentInfoURL'] = config('app.url') . '/paytool/pay-information';
        $this->obj->SendExtend['ClientRedirectURL'] = Arr::get($this->settings, 'client_redirect_url');
        $this->obj->SendExtend['StoreExpireDate'] = Arr::get($cvsType, 'store_expire_date');
    }

    private function barcodeType(array $params)
    {
        // BARCODE超商條碼延伸參數(可依系統需求選擇是否代入)
        $barcodeType = Arr::get($this->settings, 'type.BARCODE');

        // 交易描述 會顯示在超商繳費平台的螢幕上。預設空值
        $this->obj->SendExtend['Desc_1'] = Arr::get($params, 'desc_1', '');
        $this->obj->SendExtend['Desc_2'] = Arr::get($params, 'desc_2', '');
        $this->obj->SendExtend['Desc_3'] = Arr::get($params, 'desc_3', '');
        $this->obj->SendExtend['Desc_4'] = Arr::get($params, 'desc_4', '');
        $this->obj->SendExtend['PaymentInfoURL'] = config('app.url') . '/paytool/pay-information';
        $this->obj->SendExtend['ClientRedirectURL'] = Arr::get($this->settings, 'client_redirect_url');
        $this->obj->SendExtend['StoreExpireDate'] = Arr::get($barcodeType, 'store_expire_date');
    }
}
