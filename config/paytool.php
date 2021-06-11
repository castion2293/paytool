<?php

return [
    'driver' => [
        'ec_pay' => [
            //服務位置
            'service_url' => env('SERVICE_URL', 'https://payment-stage.ecpay.com.tw/Cashier/QueryTradeInfo/V5'),
            // HashKey
            'hash_key' => env('HASH_KEY', '5294y06JbISpM5x9'),
            // HashIV
            'hash_iv' => env('HASH_IV', 'v77hoKGq4kWxNNIS'),
            // 特店編號
            'merchant_id' => env('MERCHANT_ID', '2000132'),
            // CheckMacValue加密類型
            'encrypt_type' => '1',
            // 付款類型
            'type' => [
                // 信用卡
                'Credit' => [],

                // 網路 ATM
                'WebATM' => [],

                // 自動櫃員機
                'ATM' => [],

                // 超商代碼
                'CVS' => [],

                // 超商條碼
                'BARCODE' => [],
            ],
        ],
    ]
];
