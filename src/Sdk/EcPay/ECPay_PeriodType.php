<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 定期定額的週期種類。
 */
abstract class ECPay_PeriodType
{
    /**
     * 無
     */
    public const None = '';

    /**
     * 年
     */
    public const Year = 'Y';

    /**
     * 月
     */
    public const Month = 'M';

    /**
     * 日
     */
    public const Day = 'D';
}
