<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 信用卡訂單處理動作資訊。
 */
abstract class ECPay_ActionType
{
    /**
     * 關帳
     */
    public const C = 'C';

    /**
     * 退刷
     */
    public const R = 'R';

    /**
     * 取消
     */
    public const E = 'E';

    /**
     * 放棄
     */
    public const N = 'N';
}
