<?php

namespace Pharaoh\Paytool\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Pharaoh\Paytool\Events\PayNoticeEvent;
use Pharaoh\Paytool\Http\Requests\OrderCreateRequest;

class OrderController extends BaseController
{
    /**
     * 建立訂單
     *
     * @param OrderCreateRequest $request
     */
    public function create(OrderCreateRequest $request)
    {
        $driver = \App::make($request->input('driver'));
        $driver->createOrder($request->all());
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
