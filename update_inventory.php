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

// 開始交易
$conn->begin_transaction();

try {
    // 更新庫存
    $sql = "UPDATE product SET inventory = ? WHERE p_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $newInventory, $productId);

    if (!$stmt->execute()) {
        throw new Exception("Failed to update inventory");
    }

    // 如果庫存更新成功，檢查購物車
    if ($newInventory == 0) {
        $sql = "DELETE FROM shop_cart WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);

        if (!$stmt->execute()) {
            throw new Exception("Failed to delete product from shop_cart");
        }
    }

    // 提交交易
    $conn->commit();
    echo "Inventory updated successfully and product removed from cart if necessary";
} catch (Exception $e) {
    // 回滾交易
    $conn->rollback();
    http_response_code(500);
    echo $e->getMessage();
}

$stmt->close();
$conn->close();
?>
