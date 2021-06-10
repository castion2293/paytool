<?php

namespace Pharaoh\Paytool\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
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
        dd($request->all());
    }
}
