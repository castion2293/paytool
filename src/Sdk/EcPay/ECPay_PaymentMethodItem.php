<?php

namespace Pharaoh\Paytool\Sdk\EcPay;

/**
 * 付款方式子項目。
 */
abstract class ECPay_PaymentMethodItem
{
    /**
     * 不指定。
     */
    public const None = '';
    // WebATM 類(001~100)
    /**
     * 台新銀行。
     */
    public const WebATM_TAISHIN = 'TAISHIN';

    /**
     * 玉山銀行。
     */
    public const WebATM_ESUN = 'ESUN';

    /**
     * 華南銀行。
     */
    public const WebATM_HUANAN = 'HUANAN';

    /**
     * 台灣銀行。
     */
    public const WebATM_BOT = 'BOT';

    /**
     * 台北富邦。
     */
    public const WebATM_FUBON = 'FUBON';

    /**
     * 中國信託。
     */
    public const WebATM_CHINATRUST = 'CHINATRUST';

    /**
     * 第一銀行。
     */
    public const WebATM_FIRST = 'FIRST';

    /**
     * 國泰世華。
     */
    public const WebATM_CATHAY = 'CATHAY';

    /**
     * 兆豐銀行。
     */
    public const WebATM_MEGA = 'MEGA';

    /**
     * 元大銀行。
     */
    public const WebATM_YUANTA = 'YUANTA';

    /**
     * 土地銀行。
     */
    public const WebATM_LAND = 'LAND';
    // ATM 類(101~200)
    /**
     * 台新銀行。
     */
    public const ATM_TAISHIN = 'TAISHIN';

    /**
     * 玉山銀行。
     */
    public const ATM_ESUN = 'ESUN';

    /**
     * 華南銀行。
     */
    public const ATM_HUANAN = 'HUANAN';

    /**
     * 台灣銀行。
     */
    public const ATM_BOT = 'BOT';

    /**
     * 台北富邦。
     */
    public const ATM_FUBON = 'FUBON';

    /**
     * 中國信託。
     */
    public const ATM_CHINATRUST = 'CHINATRUST';

    /**
     * 土地銀行。
     */
    public const ATM_LAND = 'LAND';

    /**
     * 國泰世華銀行。
     */
    public const ATM_CATHAY = 'CATHAY';

    /**
     * 大眾銀行。
     */
    public const ATM_Tachong = 'Tachong';

    /**
     * 永豐銀行。
     */
    public const ATM_Sinopac = 'Sinopac';

    /**
     * 彰化銀行。
     */
    public const ATM_CHB = 'CHB';

    /**
     * 第一銀行。
     */
    public const ATM_FIRST = 'FIRST';

    // 超商類(201~300)
    /**
     * 超商代碼繳款。
     */
    public const CVS = 'CVS';

    /**
     * OK超商代碼繳款。
     */
    public const CVS_OK = 'OK';

    /**
     * 全家超商代碼繳款。
     */
    public const CVS_FAMILY = 'FAMILY';

    /**
     * 萊爾富超商代碼繳款。
     */
    public const CVS_HILIFE = 'HILIFE';

    /**
     * 7-11 ibon代碼繳款。
     */
    public const CVS_IBON = 'IBON';

    // 其他類(901~999)
    /**
     * 超商條碼繳款。
     */
    public const BARCODE = 'BARCODE';

    /**
     * 信用卡(MasterCard/JCB/VISA)。
     */
    public const Credit = 'Credit';

    /**
     * 貨到付款。
     */
    public const COD = 'COD';
}
