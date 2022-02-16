<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 額外付款資訊。
 */
abstract class ECPay_ExtraPaymentInfo
{
    /**
     * 需要額外付款資訊。
     */
    public const Yes = 'Y';

    /**
     * 不需要額外付款資訊。
     */
    public const No = 'N';
}
