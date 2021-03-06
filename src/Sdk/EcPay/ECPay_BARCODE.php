<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 付款方式 : BARCODE
 */
class ECPay_BARCODE extends ECPay_Verification
{
    public $arPayMentExtend = array(
        'Desc_1' => '',
        'Desc_2' => '',
        'Desc_3' => '',
        'Desc_4' => '',
        'PaymentInfoURL' => '',
        'ClientRedirectURL' => '',
        'StoreExpireDate' => ''
    );

    //過濾多餘參數
    public function filter_string($arExtend = array(), $InvoiceMark = '')
    {
        $arExtend = parent::filter_string($arExtend, $InvoiceMark);
        return $arExtend;
    }
}
