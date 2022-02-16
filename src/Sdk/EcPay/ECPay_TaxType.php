<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 課稅類別
 */
abstract class ECPay_TaxType
{
    // 應稅
    public const Dutiable = '1';

    // 零稅率
    public const Zero = '2';

    // 免稅
    public const Free = '3';

    // 應稅與免稅混合(限收銀機發票無法分辦時使用，且需通過申請核可)
    public const Mix = '9';
}
