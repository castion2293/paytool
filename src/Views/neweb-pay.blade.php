<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
</head>
    <body class="antialiased">
        <form name='Newebpay' method='post' action='{{ config('paytool.driver.neweb_pay.service_url') }}'>
            <input hidden type='text' name='MerchantID' value='{{ $MerchantID }}'>
            <input hidden type='text' name='TradeInfo' value='{{ $TradeInfo }}'>
            <input hidden type='text' name='TradeSha' value='{{ $TradeSha }}'>
            <input hidden type='text' name='Version' value='{{ $Version }}'>
            <input hidden id="btn" type='submit' value='Submit'>
        </form>
    </div>

    <script>
        setInterval(function(){
            document.getElementById('btn').click()
        }, 1000);

    </script>
</body>
</html>
