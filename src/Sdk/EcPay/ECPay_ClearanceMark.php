<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 通關方式
 */
abstract class ECPay_ClearanceMark
{
    // 經海關出口
    const Yes = '1';

    // 非經海關出口
    const No = '2';
}
