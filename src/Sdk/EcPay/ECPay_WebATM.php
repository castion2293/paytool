<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 *  付款方式 WebATM
 */
class ECPay_WebATM extends ECPay_Verification
{
    public $arPayMentExtend = array();

    //過濾多餘參數
    public function filter_string($arExtend = array(), $InvoiceMark = '')
    {
        $arExtend = parent::filter_string($arExtend, $InvoiceMark);
        return $arExtend;
    }
}
