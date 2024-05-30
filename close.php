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
    <link rel="website icon" type="image/png" href="image/logo.png">
    <title>老師傅</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
			background-image: url("image/006.png") ;
			background-repeat: no-repeat;
			background-size: cover;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
			border: 2px solid #6b8e23
			
        }
        .message {
            padding: 40px;
            background-color: #cde8e5;
            border: 1px solid #ccc;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
			border-radius: 15px; /* 圆角 */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            <?php if (isset($closed) && $closed): ?>
                <h1>店家已經打烊囉</h1>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>