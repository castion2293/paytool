<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 *  付款方式：全功能
 */
class ECPay_ALL extends ECPay_Verification
{
    public $arPayMentExtend = array();

    public function filter_string($arExtend = array(), $InvoiceMark = '')
    {
        return $arExtend;
    }
}
