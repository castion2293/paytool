<?php

namespace Pharaoh\Paytool\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
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

        $driverBladeName = str_replace('_', '-', $request->input('driver_code'));
        $bladeFile = __DIR__ . '/../../Views/' . $driverBladeName . '.blade.php';
        if (!file_exists($bladeFile)) {
            throw new PaytoolException("{$driverBladeName}.blade.php is not found");
        }

        return view("pharaoh_paytool::{$driverBladeName}", $viewData);
    }

    /**
     * 付款確認回戳
     *
     * @param Request $request
     * @return string
     */
    public function payNotice(Request $request): string
    {
        // 發送 Pay Notice 事件
        PayNoticeEvent::dispatch($request->all());

        return '1|OK';
    }
}
