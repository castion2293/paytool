<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 付款方式 : 信用卡
 */
class ECPay_Credit extends ECPay_Verification
{
    public $arPayMentExtend = array(
        "CreditInstallment" => '',
        "InstallmentAmount" => 0,
        "Redeem" => false,
        "UnionPay" => false,
        "Language" => '',
        "BindingCard" => '',
        "MerchantMemberID" => '',
        "PeriodAmount" => '',
        "PeriodType" => '',
        "Frequency" => '',
        "ExecTimes" => '',
        "PeriodReturnURL" => ''
    );

    public function filter_string($arExtend = array(), $InvoiceMark = '')
    {
        $arExtend = parent::filter_string($arExtend, $InvoiceMark);
        return $arExtend;
    }
}
