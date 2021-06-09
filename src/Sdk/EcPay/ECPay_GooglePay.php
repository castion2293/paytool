<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 付款方式 : Google Pay
 */
class ECPay_GooglePay extends ECPay_Verification
{
    public $arPayMentExtend = array();

    public function filter_string($arExtend = array(), $InvoiceMark = '')
    {
        $arExtend = parent::filter_string($arExtend, $InvoiceMark);
        return $arExtend;
    }
}
