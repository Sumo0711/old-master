<?php
session_start();

$servername = "localhost";
$username = "root";
$dbname = "old-master";

$conn = new mysqli($servername, $username, '', $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 檢查用戶是否登入
    if (!isset($_SESSION["user_id"])) {
        echo "<script>
                alert('您還沒有登錄，請先登入!');
                window.location.href = 'login.php';
              </script>";
        exit();
    }

    $user = $_SESSION["user_id"];
    $product_id = $_POST['product_id'];
    $amount = $_POST['amount'];

    $sql = "INSERT INTO `shop_cart`(`user_id`, `product_id`, `amount`) VALUES ('$user','$product_id','$amount')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                if(confirm('已成功加入購物車！')) {
                    window.location.href = 'index.php';
                }
              </script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
