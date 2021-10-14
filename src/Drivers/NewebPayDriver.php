<?php

namespace Pharaoh\Paytool\Drivers;

use Illuminate\Support\Arr;
use Pharaoh\Paytool\Exceptions\PaytoolException;

class NewebPayDriver extends AbstractDriver
{
    public function __construct()
    {
        $this->settings = config('paytool.driver.neweb_pay');
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
                'NotifyURL' => config('app.url') . '/paytool/pay-notice',
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
     * 超商代碼付款的專屬參數
     *
     * @param array $params
     */
    private function cvsType(array &$params)
    {
        $params['ExpireDate'] = now()->addDays(Arr::get($this->settings, 'CVS.expire_days'))->format('Ymd');
        $params['CVS'] = 1;
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
}
