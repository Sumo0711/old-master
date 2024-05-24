<?php
$servername = "localhost";
$username = "root";
$dbname = "old-master";

// 連接資料庫
$conn = new mysqli($servername, $username, '', $dbname);
$conn->set_charset("utf8");

// 獲取POST數據
$productId = $_POST['p_id'];
$newInventory = $_POST['inventory'];

// 更新庫存
$sql = "UPDATE product SET inventory = ? WHERE p_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $newInventory, $productId);

if ($stmt->execute()) {
    echo "Inventory updated successfully";
} else {
    http_response_code(500);
    echo "Failed to update inventory";
}

$stmt->close();
$conn->close();
?>
