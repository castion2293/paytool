<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 額外付款資訊。
 */
abstract class ECPay_DeviceType
{

    /**
     * 桌機版付費頁面。
     */
    const PC = 'P';

    /**
     * 行動裝置版付費頁面。
     */
    const Mobile = 'M';
}
