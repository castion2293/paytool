<?php

return [
    'driver' => [
        'ec_pay' => [
            //服務位置
            'service_url' => env('EC_PAY_SERVICE_URL', 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5'),
            // HashKey
            'hash_key' => env('EC_PAY_HASH_KEY', '5294y06JbISpM5x9'),
            // HashIV
            'hash_iv' => env('EC_PAY_HASH_IV', 'v77hoKGq4kWxNNIS'),
            // 特店編號
            'merchant_id' => env('EC_PAY_MERCHANT_ID', '2000132'),
            // CheckMacValue加密類型
            'encrypt_type' => '1',
            // Client 端回 傳付款相關 資訊
            'client_redirect_url' => env('EC_PAY_ClientRedirectURL', ''),
            // 付款類型
            'type' => [
                // 信用卡
                'Credit' => [
                    // 分期功能，預設false
                    'credit_installment_enable' => false,
                    // 是否使用紅利折抵，預設false
                    'redeem' => false,
                    // 是否為聯營卡，預設false
                    'union_pay' => false
                ],

                // 網路 ATM
                'WebATM' => [],

                // 自動櫃員機
                'ATM' => [
                    //繳費期限 (預設3天，最長60天，最短1天)
                    'expire_date' => 1,
                ],

                // 超商代碼
                'CVS' => [
                    // 超商繳費 截止時間 以分鐘為單位
                    'store_expire_date' => 1440
                ],

                // 超商條碼
                'BARCODE' => [
                    // 超商條碼 截止時間 以天為單位
                    'store_expire_date' => 1
                ],
            ],
        ],
        'neweb_pay' => [
            //服務位置
            'service_url' => env('NEWEB_PAY_SERVICE_URL', 'https://ccore.newebpay.com/MPG/mpg_gateway'),
            // 商店代號
            'merchant_id' => env('NEWEB_PAY_MERCHANT_ID'),
            // HashKey
            'hash_key' => env('NEWEB_PAY_HASH_KEY'),
            // HashIV
            'hash_iv' => env('NEWEB_PAY_HASH_IV'),
            // 版本號
            'version' => env('NEWEB_PAY_VERSION', '1.6'),
            // 藍新金流會員
            'login_type' => env('NEWEB_PAY_LOGIN_TYPE', 0),
            // 付款類型
            'type' => [
                // 信用卡
                'Credit' => [
                    // 分期功能，預設 不啟用
                    'credit_installment_enable' => 0,
                    // 是否使用紅利折抵，預設 不啟用
                    'redeem' => 0,
                    // 是否為聯營卡，預設 不啟用
                    'union_pay' => 0,
                ],

                // 超商代碼
                'CVS' => [
                    // 繳費有效天數
                    'expire_days' => 7,
                ],

                // 超商條碼
                'BARCODE' => [
                    // 超商條碼 截止時間 以天為單位
                    'expire_days' => 1
                ],

                // 自動櫃員機
                'ATM' => [
                    // 繳費有效天數
                    'expire_days' => 7
                ],

                'WebATM' => [
                    // 繳費有效天數
                    'expire_days' => 7
                ],
            ]
        ]
    ]
];
