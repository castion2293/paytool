<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

;

/**
 * 抽象類
 */
abstract class ECPay_Aio
{
    protected static function ServerPost($parameters, $ServiceURL)
    {
        $ch = curl_init();

        if (false === $ch) {
            throw new Exception('curl failed to initialize');
        }

        curl_setopt($ch, CURLOPT_URL, $ServiceURL);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        $rs = curl_exec($ch);

        if (false === $rs) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }

        curl_close($ch);

        return $rs;
    }

    protected static function HtmlEncode(
        $target = "_self",
        $arParameters,
        $ServiceURL,
        $szCheckMacValue,
        $paymentButton = ''
    ) {
        //生成表單，自動送出
        $szHtml = '<!DOCTYPE html>';
        $szHtml .= '<html>';
        $szHtml .= '<head>';
        $szHtml .= '<meta charset="utf-8">';
        $szHtml .= '</head>';
        $szHtml .= '<body>';
        $szHtml .= "<form id=\"__ecpayForm\" method=\"post\" target=\"{$target}\" action=\"{$ServiceURL}\">";

        foreach ($arParameters as $keys => $value) {
            $szHtml .= "<input type=\"hidden\" name=\"{$keys}\" value=\"" . htmlentities($value) . "\" />";
        }

        $szHtml .= "<input type=\"hidden\" name=\"CheckMacValue\" value=\"{$szCheckMacValue}\" />";

        if (!empty($paymentButton)) {
            $szHtml .= "<input type=\"submit\" id=\"__paymentButton\" value=\"{$paymentButton}\" />";
        }

        $szHtml .= '</form>';

        if (empty($paymentButton)) {
            $szHtml .= '<script type="text/javascript">document.getElementById("__ecpayForm").submit();</script>';
        }

        $szHtml .= '</body>';
        $szHtml .= '</html>';


        return $szHtml;
    }
}
