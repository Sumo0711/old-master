<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>管理員控制台</title>
    <link rel="stylesheet" type="text/css" href="css/admin_order_control.css">
    <link rel="website icon" type="image/png" href="image/logo.png">
</head>

<body>
    <header>
        <div class="logo" onclick="goToIndex()">
            <h1>管理員控制台</h1>
        </div>
    </header>
    <nav>
        <div class="nav-block">
            <form method="post" style="display:inline;">
                <input type="hidden" name="show_history" value="0">
                <button type="submit" class="nav-button">目前訂單</button>
            </form>
            <form method="post" style="display:inline;">
                <input type="hidden" name="show_history" value="1">
                <button type="submit" class="nav-button">歷史訂單</button>
            </form>
        </div>
    </nav>

    <?php
    // 數據庫連接參數
    $servername = "localhost";
    $username = "root";
    $password = ""; // 如果沒有密碼，留空即可
    $dbname = "old-master";

    // 創建數據庫連接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 檢查連接是否成功
    if ($conn->connect_error) {
        die("連接數據庫失敗: " . $conn->connect_error);
    }

    // 處理表單提交
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["order_details"])) {
            $order_details_id = $_POST["order_details"];
            if (isset($_POST["finish"])) {
                $finish = $_POST["finish"];
                $update_sql = "UPDATE user_order_details SET Finish = ? WHERE order_details = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param('ii', $finish, $order_details_id);
                $update_stmt->execute();
            } elseif (isset($_POST["restore"]) && $_POST["restore"] == "1") {
                $restore_sql = "UPDATE user_order_details SET Finish = 0 WHERE order_details = ?";
                $restore_stmt = $conn->prepare($restore_sql);
                $restore_stmt->bind_param('i', $order_details_id);
                $restore_stmt->execute();
            }
        }
    }

    // 根據按鈕狀態選擇查詢訂單詳情數據
    if (isset($_POST["show_history"]) && $_POST["show_history"] == "1") {
        $sql = "SELECT * FROM user_order_details WHERE Finish != 0";
        $button_text = "隱藏歷史訂單";
        $button_value = "0";
    } else {
        $sql = "SELECT * FROM user_order_details WHERE Finish = 0";
        $button_text = "顯示歷史訂單";
        $button_value = "1";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='order-container'>";
            echo "<form method='post'>";
            echo "<strong>單號:</strong> " . $row["order_details"] . "<br>";
            echo "<strong>用戶名:</strong> " . $row["username"] . "<br>";
            echo "<strong>餐點:</strong> " . $row["products"] . "<br>";
            echo "<strong>總金額:</strong> " . $row["total"] . "<br>";
            echo "<input type='hidden' name='order_details' value='" . $row["order_details"] . "'>";

            if ($row["Finish"] == 0) {
                echo "<input type='hidden' name='finish' value='1'>";
                echo "<input type='submit' value='完成訂單'>";
            } else {
                echo "<div class='completed-status'>";
                echo "<strong>狀態:</strong> 已出餐<br>";
                echo "<input type='hidden' name='restore' value='1'>";
                echo "<input type='submit' value='復原'>";
                echo "</div>";
            }

            echo "</form>";
            echo "</div>";
        }
    }

    $conn->close();
    ?>

    <script>
        function goToIndex() {
            window.location.href = "admin.php";
        }
    </script>
</body>

</html>