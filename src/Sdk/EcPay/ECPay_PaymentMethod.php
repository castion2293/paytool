<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 付款方式。
 */
abstract class ECPay_PaymentMethod
{
    /**
     * 不指定付款方式。
     */
    public const ALL = 'ALL';

    /**
     * 信用卡付費。
     */
    public const Credit = 'Credit';

    /**
     * 網路 ATM。
     */
    public const WebATM = 'WebATM';

    /**
     * 自動櫃員機。
     */
    public const ATM = 'ATM';

    /**
     * 超商代碼。
     */
    public const CVS = 'CVS';

    /**
     * 超商條碼。
     */
    public const BARCODE = 'BARCODE';

    /**
     * AndroidPay。(同 GooglePay)
     */
    public const AndroidPay = 'GooglePay';

    /**
     * GooglePay。
     */
    public const GooglePay = 'GooglePay';
}
