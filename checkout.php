<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>老師傅</title>
    <link rel="stylesheet" type="text/css" href="css/checkout.css">
    <link rel="website icon" type="image/png" href="image/logo.png">
    <header>
        <div class="logo" onclick="goToIndex()">
            <h1>老師傅</h1>
        </div>
    </header>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>購物車結帳</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>商品圖片</th>
                <th>商品名稱</th>
                <th>商品單價</th>
                <th>數量</th>
                <th>價格合計</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // 開始 session
            session_start();

            $servername = "localhost";
            $username = "root";
            $dbname = "old-master";

            // 檢查用戶是否已登入
            if (!isset($_SESSION['user_id'])) {
                echo "<script>
                    alert('您還沒有登錄，請先登入!');
                    window.location.href = 'login.php';
                    </script>";
                exit();
            }

            // 建立連接
            $conn = new mysqli($servername, $username, '', $dbname);

            // 檢查連接
            if ($conn->connect_error) {
                die("連接失敗：" . $conn->connect_error);
            }

            // 設置字符集編碼
            $conn->set_charset("utf8");

            // 使用參數化查詢，只檢索與當前使用者 ID 相關的購物車內容
            $sql = "SELECT p_id,name, price, u_id, amount, order_number FROM user_cart WHERE u_id = ?"; // 這裡使用參數化查詢
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION['user_id']); // 將 u_id 綁定到參數
            $stmt->execute();
            $result = $stmt->get_result();

            // 初始化總金額
            $totalAmount = 0;

            // 檢查是否有結果
            if ($result->num_rows > 0) {
                // 輸出每一行數據
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    // 獲取產品ID
                    $productId = $row["p_id"];
                    // 根據產品ID生成圖片路徑
                    $formattedProductId = sprintf("%02d", $productId);
                    $imagePath = "image/{$formattedProductId}.png";
                    echo "<td><img src='{$imagePath}' alt='{$row["name"]} 圖片' class='product-image'></td>";
                    echo "<td>{$row["name"]}</td>";
                    echo "<td>$" . $row["price"] . "</td>";
                    echo "<td>{$row["amount"]}</td>";
                    // 計算並顯示小計
                    $subtotal = $row["price"] * $row["amount"];
                    echo "<td>$" . $subtotal . "</td>";
                    // 操作列包含刪除按鈕
                    echo "<td><button class='delete-button' onclick='deleteItem({$row["order_number"]})'>刪除</button></td>"; 
                    echo "</tr>";
                    // 累加小計到總金額
                    $totalAmount += $subtotal;
                }
            } else {
                echo "<tr><td colspan='6'>購物車是空的</td></tr>";
            }

            $stmt->close();
            $conn->close();
        ?>

        </tbody>
    </table>

    <!-- 刪除按鈕和總金額顯示 -->
    <div class="action-total">
        <div class="total">
            <p>總金額: $<?php echo $totalAmount; ?></p>
        </div>
            <form action="user_order_details.php" method="post">
            <input type="hidden" name="total_amount" value="<?php echo $totalAmount; ?>">
            <button type="submit" class="button">結帳</button>
        </form>
    </div>
</div>

<script>
    function deleteItem(orderNumber) {
        // 確認是否要刪除商品
        if (confirm("確定要刪除該商品嗎？")) {
            // 使用 AJAX 向後端發送刪除商品的請求
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // 顯示刪除成功的提示框
                    alert("已成功刪除該商品");
                    // 重新載入頁面以更新購物車內容
                    location.reload();
                }
            };
            xhr.open("POST", "delete.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("order_number=" + orderNumber); 
        }
    }
    function goToIndex() {
        window.location.href = "index.php";
    }
</script>
<footer>
    <p>版權所有 &copy; 老師傅</p>
</footer>
</body>
</html>
