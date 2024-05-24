<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>管理員控制台</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="website icon" type="image/png" href="image/logo.png">
</head>

<body>
    <header>
        <div class="logo" onclick="goToIndex()">
            <h1>管理員控制台</h1>
        </div>
    </header>

    <?php
    $servername = "localhost";
    $username = "root";
    $dbname = "old-master";
    
    // 連接資料庫
    $conn = new mysqli($servername, $username, '', $dbname);
    $conn->set_charset("utf8");

    // 查詢資料庫
    $sql = "SELECT SUM(total) AS total_finished_orders
            FROM user_order_details
            WHERE Finish = 1;";
    $result = $conn->query($sql);

    // 檢查是否有結果
    if ($result->num_rows > 0) {
        // 將結果取出
        $row = $result->fetch_assoc();
        $total_finished_orders = $row["total_finished_orders"];
        echo "<p class='big-number'>新台幣＄$total_finished_orders</p>";
    } else {
        echo "<p class='big-number'>新台幣＄0</p>";
    }

    // 關閉連接
    $conn->close();
    ?>

    <script>
        function goToIndex() {
            window.location.href = "admin.php";
        }
    </script>
</body>

</html>
