<?php

namespace Pharaoh\Paytool\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Pharaoh\Paytool\Events\PayNoticeEvent;
use Pharaoh\Paytool\Exceptions\PaytoolException;
use Pharaoh\Paytool\Http\Requests\OrderCreateRequest;

class OrderController extends BaseController
{
    /**
     * 建立訂單
     *
     * @param OrderCreateRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws PaytoolException
     */
    public function create(OrderCreateRequest $request)
    {
        $driver = \App::make($request->input('driver'));
        $viewData = $driver->createOrder($request->all());

        $vendorBladeName = str_replace('_', '-', $request->input('vendor_code'));
        $bladeFile = __DIR__ . '/../../Views/' . $vendorBladeName . '.blade.php';
        if (!file_exists($bladeFile)) {
            throw new PaytoolException("{$vendorBladeName}.blade.php is not found");
        }

        return view("pharaoh_paytool::{$vendorBladeName}", $viewData);
    }

    /**
     * 付款確認回戳
     *
     * @param Request $request
     * @param $vendorCode
     * @return string
     */
    public function payNotice(Request $request, $vendorCode): string
    {
        $driver = \App::make('Pharaoh\\Paytool\\Drivers\\' . Str::studly($vendorCode) . 'Driver');
        $responseData = $driver->handleResponseData($request->all());

        // 發送 Pay Notice 事件
        PayNoticeEvent::dispatch($responseData);

        return '1|OK';
    }
}
