<?php

namespace Pharaoh\Paytool\Drivers;

use Illuminate\Support\Arr;
use Pharaoh\Paytool\Exceptions\PaytoolException;

class NewebPayDriver extends AbstractDriver
{
    public function __construct()
    {
        $this->vendorCode = 'neweb_pay';
        $this->settings = config("paytool.driver.{$this->vendorCode}");
    }

    /**
     * 建立金流訂單
     *
     * @return mixed|void
     * @throws PaytoolException
     */
    public function createOrder(array $params)
    {
        try {
            $data = [
                'MerchantID' => $merchantId = Arr::get($this->settings, 'merchant_id'),
                'RespondType' => 'JSON',
                'TimeStamp' => time(),
                'Version' => $version = Arr::get($this->settings, 'version'),
                'MerchantOrderNo' => Arr::get($params, 'merchant_trade_no'),
                'Amt' => intval(Arr::get($params, 'total_amount')),
                'ItemDesc' => Arr::get($params, 'name'),
                'Email' => Arr::get($params, 'email'),
                'LoginType' => Arr::get($this->settings, 'login_type'),
                'NotifyURL' => config('app.url') . '/paytool/pay-notice/' . $this->vendorCode,
                'OrderComment' => Arr::get($params, 'comment')
            ];

            $choosePayment = Arr::get($params, 'choose_payment');
            $functionType = lcfirst(strtolower($choosePayment)) . 'Type';
            if (method_exists($this, $functionType)) {
                $this->$functionType($data);
            }

            $formData = [
                'MerchantID' => $merchantId,
                'TradeInfo' => $tradeInfo = $this->encryptDataForASE($data),
                'TradeSha' => $this->encryptDataForSHA256($tradeInfo),
                'Version' => $version
            ];

            return $formData;
        } catch (\Exception $exception) {
            throw new PaytoolException($exception->getMessage());
        }
    }

    /**
     *
     *
     * @param array $params
     * @return array
     */
    public function handleResponseData(array $params): array
    {
        $tradeInfo = Arr::get($params, 'TradeInfo');
        $params['decrypt_trade_info'] = json_decode($this->decryptDataForASE($tradeInfo), true);

        return $params;
    }

    /**
     * 超商代碼付款的專屬參數
     *
     * @param array $params
     */
    private function cvsType(array &$params)
    {
        $params['ExpireDate'] = now()->addDays(Arr::get($this->settings, 'type.CVS.expire_days'))->format('Ymd');
        $params['CVS'] = 1;
    }

    /**
     * 自動櫃員機付款的專屬參數
     *
     * @param array $params
     */
    private function atmType(array &$params)
    {
        $params['ExpireDate'] = now()->addDays(Arr::get($this->settings, 'type.ATM.expire_days'))->format('Ymd');
        $params['VACC'] = 1;
    }

    /**
     * 網路櫃員機付款的專屬參數
     *
     * @param array $params
     */
    private function webatmType(array &$params)
    {
        $params['ExpireDate'] = now()->addDays(Arr::get($this->settings, 'type.WebATM.expire_days'))->format('Ymd');
        $params['WEBATM'] = 1;
    }

    /**
     * 超商條碼付款的專屬參數
     *
     * @param array $params
     */
    private function barcodeType(array &$params)
    {
        $params['ExpireDate'] = now()->addDays(Arr::get($this->settings, 'type.BARCODE.expire_days'))->format('Ymd');
        $params['BARCODE'] = 1;
    }

    private function creditType(array &$params)
    {
        // 信用卡 分期付款
        $params['InstFlag'] = Arr::get($this->settings, 'type.Credit.credit_installment_enable');
        // 信用卡 紅利
        $params['CreditRed'] = Arr::get($this->settings, 'type.Credit.redeem');
        // 信用卡 銀聯卡
        $params['UNIONPAY'] = Arr::get($this->settings, 'type.Credit.union_pay');
        $params['CREDIT'] = 1;
    }

    /**
     * 交易資料 AES 加密
     *
     * @param array $formData
     * @return string
     */
    private function encryptDataForASE(array $params)
    {
        $returnStr = empty($params) ? '' : http_build_query($params);
        $returnStr = $this->addPadding($returnStr);

        return trim(
            bin2hex(
                openssl_encrypt(
                    $returnStr,
                    'AES-256-CBC',
                    $this->settings['hash_key'],
                    OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
                    $this->settings['hash_iv']
                )
            )
        );
    }

    /**
     * 交易資料 AES 解密
     *
     * @param string $aesString
     * @return bool|string
     */
    private function decryptDataForASE(string $aesString): string
    {
        return $this->stripPadding(
            openssl_decrypt(
                hex2bin($aesString),
                'AES-256-CBC',
                $this->settings['hash_key'],
                OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
                $this->settings['hash_iv']
            )
        );
    }

    /**
     * 交易資料 SHA256 加密
     *
     * @param string $aceString
     * @return string
     */
    private function encryptDataForSHA256(string $aceString): string
    {
        // 最前方加入 HashKey，最後方加入 HashIV
        $encryptString = "HashKey={$this->settings['hash_key']}&{$aceString}&HashIV={$this->settings['hash_iv']}";

        // 進行 Sha256 加密
        $encryptString = hash("sha256", $encryptString);

        // 轉為全大寫後回傳
        return strtoupper($encryptString);
    }

    /**
     * 加密字串修正
     *
     * @param $string
     * @param int $blockSize
     * @return string
     */
    private function addPadding($string, $blockSize = 32)
    {
        $len = strlen($string);
        $pad = $blockSize - ($len % $blockSize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    /**
     * 解密字串修正
     *
     * @param $string
     * @return bool|string
     */
    private function stripPadding($string)
    {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }
}
