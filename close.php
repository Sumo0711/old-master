<?php
session_start();
$servername = "localhost"; // MySQL位置
$username = "root"; // 帳號登入
$dbname = "old-master"; // 資料庫位置

// 連接
$conn = new mysqli($servername, $username, '', $dbname); // ‘’為密碼，root預設沒有密碼所以空著

// 設置字符集編碼
$conn->set_charset("utf8");

// 查詢資料庫
$sql = "SELECT inventory FROM product WHERE inventory > 0";
$result = $conn->query($sql);

// 檢查是否還有庫存大於0的商品
if ($result->num_rows > 0) {
    // 如果還有庫存大於0的商品，重定向回 index.php
    header("Location: index.php");
    exit();
} else {
    // 如果所有商品都缺貨，顯示 "店家已打烊"
    $closed = true;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>老師傅</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message {
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            <?php if (isset($closed) && $closed): ?>
                <h1>店家已打烊</h1>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>