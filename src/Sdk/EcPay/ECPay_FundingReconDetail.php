<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

class ECPay_FundingReconDetail extends ECPay_Aio
{
    public static function CheckOut($target = "_self", $arParameters = array(), $HashKey = '', $HashIV = '', $ServiceURL = '')
    {
        //產生檢查碼
        $EncryptType = $arParameters["EncryptType"];
        unset($arParameters["EncryptType"]);

        $szCheckMacValue = ECPay_CheckMacValue::generate($arParameters, $HashKey, $HashIV, $EncryptType);

        //生成表單，自動送出
        $szHtml = parent::HtmlEncode($target, $arParameters, $ServiceURL, $szCheckMacValue, '');
        echo $szHtml;
        exit;
    }
}
