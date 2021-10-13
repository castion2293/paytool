# 遊戲API串接模組

## 安裝
使用 composer 做安裝
```bash
composer require thoth-pharaoh/paytool
```

添加 .env 支付工具必要環境參數
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


##### <a name="ec_pay">綠界-金流支費相關資料</a>


