<?php
$key = "kjSGxqGE9f0zVDItAe2M0e3nBgCmfuCj";
$iv = "Cjs6fgLxkoWuIuiP";
$mid = "MS152585148";
$totalAmount = $_POST['total_amount'];
$data1 = http_build_query(array(
    'MerchantID' => $mid,
    'TimeStamp' => time(),
    'Version' => '2.0',
    'RespondType' => 'JSON',
    'MerchantOrderNo' => "" . time(),
    'Amt' => $totalAmount,
    'VACC' => '1',
    'ALIPAY' => '0',
    'WEBATM' => '1',
    'CVS' => '1',
    'CREDIT' => '1',
    'LoginType' => '0',
    'InstFlag' => '0',
    'ItemDesc' => '電話:0909-244722',
));

$edata1 = bin2hex(openssl_encrypt($data1, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv));
$hashs = "HashKey=" . $key . "&" . $edata1 . "&HashIV=" . $iv;
$hash = strtoupper(hash("sha256", $hashs));
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
</head>
<body>
<script>
    // 創建並提交表單
    (function() {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'https://ccore.newebpay.com/MPG/mpg_gateway';

        var midField = document.createElement('input');
        midField.type = 'hidden';
        midField.name = 'MerchantID';
        midField.value = '<?= $mid ?>';
        form.appendChild(midField);

        var versionField = document.createElement('input');
        versionField.type = 'hidden';
        versionField.name = 'Version';
        versionField.value = '2.0';
        form.appendChild(versionField);

        var tradeInfoField = document.createElement('input');
        tradeInfoField.type = 'hidden';
        tradeInfoField.name = 'TradeInfo';
        tradeInfoField.value = '<?= $edata1 ?>';
        form.appendChild(tradeInfoField);

        var tradeShaField = document.createElement('input');
        tradeShaField.type = 'hidden';
        tradeShaField.name = 'TradeSha';
        tradeShaField.value = '<?= $hash ?>';
        form.appendChild(tradeShaField);

        document.body.appendChild(form);
        form.submit();
    })();
</script>
</body>
</html>

