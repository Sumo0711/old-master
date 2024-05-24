<?php
$servername = "localhost";
$username = "root";
$dbname = "old-master";

// 連接資料庫
$conn = new mysqli($servername, $username, '', $dbname);
$conn->set_charset("utf8");

// 更新庫存
$sql = "UPDATE product SET inventory = 1"; // 將所有產品的庫存設置為1
$stmt = $conn->prepare($sql);

// 執行庫存更新
if ($stmt->execute()) {
    // 重定向到 admin.php
    header("Location: admin.php");
    exit();
} else {
    http_response_code(500);
    // 提示更新庫存失敗
    echo "Failed to update inventory"; 
}

$stmt->close();
$conn->close();
?>
