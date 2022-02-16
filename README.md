# 遊戲API串接模組

## 版本匹配

| Laravel          | package               |
| ----------------- |:----------------------- |
| 8.X       | 1.X   |
| 9.X       | 2.X   |

## 安裝
使用 composer 做安裝
```bash
composer require thoth-pharaoh/paytool
```

## 匯出 Config
```bash
php artisan vendor:publish --tag=paytoo-config --force
```


## 添加 .env 支付工具必要環境參數
```bash
# ------------------
#  綠界
# ------------------
EC_PAY_SERVICE_URL="https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5"
EC_PAY_HASH_KEY="5294y06JbISpM5x9"
EC_PAY_HASH_IV="v77hoKGq4kWxNNIS"
EC_PAY_MERCHANT_ID="2000132"
EC_PAY_ClientRedirectURL=""
```

## 使用方法

### 先引入門面
```
use Pharaoh\Paytool\Facades\Paytool;
```

### 註冊金流相關路由
```bash
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        // 註冊金流相關路由
        Paytool::routes();
    }
}
```

### 建立訂單
```bash
Paytool::vendor($vendor)->createOrderTempUrl($params);
```
| 參數 | 說明 | 類型 | 範例 |
| ------------|:----------------------- | :------| :------|
| $vendor | 金流商 | string | ec_pay |
| $params | 支費相關資料 | array | 依據各家金流定義 |

#### 各家金流支費相關資料
- 綠界
    ##### 信用卡
  | 欄位 | 說明 | 類型 | 範例 |
  | ------------|:----------------------- | :------| :------|
  | merchant_trade_no | 自訂交易流水號 | string | ab12345678 |
  | total_amount | 總金額 | int | 1000 |
  | trade_desc | 交易描述 | string | 一瓶 |
  | choose_payment | 付款類別 | string | Credit |
  | name | 商品名稱 | string | 黑芝麻豆漿 |
  | price | 單價 | string | 1000 |
  | currency | 幣別名稱 | string | 元 |
  | quantity | 數量 | string | 1 |

    ##### 網路ATM
  | 欄位 | 說明 | 類型 | 範例 |
  | ------------|:----------------------- | :------| :------|
  | merchant_trade_no | 自訂交易流水號 | string | ab12345678 |
  | total_amount | 總金額 | int | 1000 |
  | trade_desc | 交易描述 | string | 一瓶 |
  | choose_payment | 付款類別 | string | WebATM |
  | name | 商品名稱 | string | 黑芝麻豆漿 |
  | price | 單價 | string | 1000 |
  | currency | 幣別名稱 | string | 元 |
  | quantity | 數量 | string | 1 |

    ##### 自動櫃員機
  | 欄位 | 說明 | 類型 | 範例 |
  | ------------|:----------------------- | :------| :------|
  | merchant_trade_no | 自訂交易流水號 | string | ab12345678 |
  | total_amount | 總金額 | int | 1000 |
  | trade_desc | 交易描述 | string | 一瓶 |
  | choose_payment | 付款類別 | string | ATM |
  | name | 商品名稱 | string | 黑芝麻豆漿 |
  | price | 單價 | string | 1000 |
  | currency | 幣別名稱 | string | 元 |
  | quantity | 數量 | string | 1 |

    ##### 超商代碼
  | 欄位 | 說明 | 類型 | 範例 |
  | ------------|:----------------------- | :------| :------|
  | merchant_trade_no | 自訂交易流水號 | string | ab12345678 |
  | total_amount | 總金額 | int | 1000 |
  | trade_desc | 交易描述 | string | 一瓶 |
  | choose_payment | 付款類別 | string | CVS |
  | name | 商品名稱 | string | 黑芝麻豆漿 |
  | price | 單價 | string | 1000 |
  | currency | 幣別名稱 | string | 元 |
  | quantity | 數量 | string | 1 |
  | desc_1 | 描述1 | string | |
  | desc_2 | 描述2 | string | |
  | desc_3 | 描述3 | string | |
  | desc_4 | 描述4 | string | |

    ##### 超商條碼
  | 欄位 | 說明 | 類型 | 範例 |
  | ------------|:----------------------- | :------| :------|
  | merchant_trade_no | 自訂交易流水號 | string | ab12345678 |
  | total_amount | 總金額 | int | 1000 |
  | trade_desc | 交易描述 | string | 一瓶 |
  | choose_payment | 付款類別 | string | BARCODE |
  | name | 商品名稱 | string | 黑芝麻豆漿 |
  | price | 單價 | string | 1000 |
  | currency | 幣別名稱 | string | 元 |
  | quantity | 數量 | string | 1 |
  | desc_1 | 描述1 | string | |
  | desc_2 | 描述2 | string | |
  | desc_3 | 描述3 | string | |
  | desc_4 | 描述4 | string | |
  
- 藍新
  ##### 信用卡
  | 欄位 | 說明 | 類型 | 範例 |
  | ------------|:----------------------- | :------| :------|
  | merchant_trade_no | 自訂交易流水號 | string | ab12345678 |
  | total_amount | 總金額 | int | 1000 |
  | trade_desc | 交易描述 | string | 一瓶 |
  | choose_payment | 付款類別 | string | Credit |
  | name | 商品名稱 | string | 黑芝麻豆漿 |
  | email | 電子郵件 | string | my@example.com |

  ##### 網路ATM
  | 欄位 | 說明 | 類型 | 範例 |
  | ------------|:----------------------- | :------| :------|
  | merchant_trade_no | 自訂交易流水號 | string | ab12345678 |
  | total_amount | 總金額 | int | 1000 |
  | trade_desc | 交易描述 | string | 一瓶 |
  | choose_payment | 付款類別 | string | WebATM |
  | name | 商品名稱 | string | 黑芝麻豆漿 |
  | email | 電子郵件 | string | my@example.com |

  ##### 自動櫃員機
  | 欄位 | 說明 | 類型 | 範例 |
  | ------------|:----------------------- | :------| :------|
  | merchant_trade_no | 自訂交易流水號 | string | ab12345678 |
  | total_amount | 總金額 | int | 1000 |
  | trade_desc | 交易描述 | string | 一瓶 |
  | choose_payment | 付款類別 | string | ATM |
  | name | 商品名稱 | string | 黑芝麻豆漿 |
  | email | 電子郵件 | string | my@example.com |
  
  ##### 超商代碼
  | 欄位 | 說明 | 類型 | 範例 |
  | ------------|:----------------------- | :------| :------|
  | merchant_trade_no | 自訂交易流水號 | string | ab12345678 |
  | total_amount | 總金額 | int | 1000 |
  | trade_desc | 交易描述 | string | 一瓶 |
  | choose_payment | 付款類別 | string | CVS |
  | name | 商品名稱 | string | 黑芝麻豆漿 |
  | email | 電子郵件 | string | my@example.com |

  ##### 超商條碼
  | 欄位 | 說明 | 類型 | 範例 |
  | ------------|:----------------------- | :------| :------|
  | merchant_trade_no | 自訂交易流水號 | string | ab12345678 |
  | total_amount | 總金額 | int | 1000 |
  | trade_desc | 交易描述 | string | 一瓶 |
  | choose_payment | 付款類別 | string | BARCODE |
  | name | 商品名稱 | string | 黑芝麻豆漿 |
  | email | 電子郵件 | string | my@example.com |
    

### 付款確認回戳
```bash
use Pharaoh\Paytool\Events\PayNoticeEvent;

class EventServiceProvider extends ServiceProvider
{
    PayNoticeEvent::class => [
        PayNoticeListener::class
    ]
}
```
付款成功處理任務請在專案中的 PayNoticeListener 實作


