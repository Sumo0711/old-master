<?php
$servername = "localhost";
$username = "root";
$dbname = "old-master";

// 連接資料庫
$conn = new mysqli($servername, $username, '', $dbname);
$conn->set_charset("utf8");

// 開始交易
$conn->begin_transaction();

try {
    // 將所有產品的庫存設置為0
    $sql = "UPDATE product SET inventory = 0";
    $stmt = $conn->prepare($sql);

    if (!$stmt->execute()) {
        throw new Exception("Failed to update inventory");
    }

    // 刪除購物車中所有產品
    $sql = "DELETE FROM shop_cart";
    if (!$conn->query($sql)) {
        throw new Exception("Failed to clear shop_cart");
    }

    // 提交交易
    $conn->commit();
    
    // 重定向到 admin.php
    header("Location: admin.php");
    exit();
} catch (Exception $e) {
    // 回滾交易
    $conn->rollback();
    http_response_code(500);
    // 提示更新庫存失敗
    echo $e->getMessage();
}

$stmt->close();
$conn->close();
?>
