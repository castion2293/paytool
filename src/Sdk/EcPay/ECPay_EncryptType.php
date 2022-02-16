<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

abstract class ECPay_EncryptType
{
    // MD5(預設)
    public const ENC_MD5 = 0;

    // SHA256
    public const ENC_SHA256 = 1;
}
