<?php
$servername = "localhost";
$username = "root";
$dbname = "old-master";

// 連接資料庫
$conn = new mysqli($servername, $username, '', $dbname);
$conn->set_charset("utf8");

session_start();

// 準備插入使用者訂單詳情資料
$user_id = $_SESSION["user_id"]; // 從 session 中獲取使用者ID
$insert_sql = "INSERT INTO user_order_details (username, products, total, Finish)
                SELECT
                    m.username AS username,
                    GROUP_CONCAT(p.name, ' * ', IFNULL(s.amount, 0) SEPARATOR ', ') AS products,
                    SUM(p.price * IFNULL(s.amount, 0)) AS total,
                    FALSE AS Finish
                FROM
                    user m
                LEFT JOIN
                    shop_cart s ON m.u_id = s.user_id AND m.u_id = ?
                LEFT JOIN
                    product p ON s.product_id = p.p_id
                WHERE
                    m.u_id = ?
                GROUP BY
                    m.u_id";

// 使用預處理語句來插入資料
$insert_stmt = $conn->prepare($insert_sql);

// 綁定參數
$insert_stmt->bind_param('ii', $user_id, $user_id);

// 執行插入資料操作
if ($insert_stmt->execute()) {
    // 取得剛插入的訂單ID
    $order_id_result = $conn->query("SELECT LAST_INSERT_ID()");
    $order_id_row = $order_id_result->fetch_assoc();
    $order_id = $order_id_row['LAST_INSERT_ID()'];

    // 清空使用者的購物車
    $clear_cart_sql = "DELETE FROM shop_cart WHERE user_id = ?";
    $clear_cart_stmt = $conn->prepare($clear_cart_sql);
    $clear_cart_stmt->bind_param('i', $user_id);
    $clear_cart_stmt->execute();

    // 關閉資料庫連接
    $conn->close();

    // 顯示取餐號碼給使用者
    echo "<script>alert('您的取餐號碼是：$order_id');</script>";

    // 透過表單提交 POST 請求，將 total_amount 傳遞到下一個 PHP 頁面
    echo '<form id="redirectForm" action="newebpay.php" method="post">';
    echo '<input type="hidden" name="total_amount" value="' . $_POST['total_amount'] . '">';
    echo '</form>';
    echo '<script type="text/javascript"> document.getElementById("redirectForm").submit(); </script>';
} else {
    echo "插入使用者訂單詳情資料時出錯：" . $conn->error . "<br>";
    // 關閉資料庫連接
    $conn->close();
}
?>
