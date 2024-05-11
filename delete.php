<?php
// 建立資料庫連線
$servername = "localhost";
$username = "root";
$dbname = "old-master";

// 建立連線
$conn = new mysqli($servername, $username, '', $dbname);

// 檢查連線是否成功
if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}

// 獲取POST請求中的order_number
$orderNumber = $_POST['order_number']; 

// 使用參數化查詢刪除相應商品
$sql = "DELETE FROM shop_cart WHERE order_number = ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderNumber); 
$stmt->execute();

// 關閉連線
$stmt->close();
$conn->close();
?>
