<?php

namespace Pharaoh\Paytool;

use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Orchestra\Testbench\Http\Middleware\TrustProxies;
use Pharaoh\Paytool\Exceptions\PaytoolException;
use Pharaoh\Paytool\Http\Controllers\OrderController;

class Paytool
{
    /**
     * 支付工具
     *
     * @var
     */
    private $driver;

    /**
     * 支付工具代碼
     *
     * @var string
     */
    private string $driverCode;

    public function __construct()
    {
    }

    /**
     * 設定支付工具
     *
     * @param string $driver
     * @return Paytool
     * @throws \Exception
     */
    public function vendor(string $driver)
    {
        $configDrivers = array_keys(config('paytool.driver'));
        if (!in_array($driver, $configDrivers)) {
            throw new PaytoolException("{$driver} driver not found");
        }

        // 設定 paytool driver
        $this->driverCode = $driver;
        $this->driver = \App::make('Pharaoh\\Paytool\\Drivers\\' . Str::studly($driver) . 'Driver');

        return $this;
    }

    /**
     * 註冊金流相關路由
     */
    public function routes()
    {
        Route::prefix('paytool')->group(
            function () {
                // 建立訂單
                Route::get('create-order', [OrderController::class, 'create'])
                    ->name('create-order')
                    ->middleware(ValidateSignature::class);

                // 付款確認回戳
                Route::post('pay-notice', [OrderController::class, 'payNotice'])
                    ->name('pay-notice');

                // 付款資訊回戳
                Route::post('pay-information', function () {
                    Log::info('pay-information');
                    Log::info(json_encode(request()->all()));
                });
            }
        );
    }

    /**
     * 建立訂單跳轉URL
     *
     * @param array $params
     * @return string
     */
    public function createOrderTempUrl(array $params)
    {
        $params = array_merge(
            $params,
            [
                'driver' => $this->driver::class,
                'driver_code' => $this->driverCode
            ]
        );

        return URL::temporarySignedRoute(
            'create-order',
            now()->addSeconds(5),
            $params
        );
    }
}
