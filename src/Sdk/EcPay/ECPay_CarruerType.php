<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 電子發票載具類別
 */
abstract class ECPay_CarruerType
{
    // 無載具
    public const None = '';

    // 會員載具
    public const Member = '1';

    // 買受人自然人憑證
    public const Citizen = '2';

    // 買受人手機條碼
    public const Cellphone = '3';
}
