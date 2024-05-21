<?php
session_start();
$servername = "localhost"; // MySQL位置
$username = "root"; // 帳號登入
$dbname = "old-master"; // 資料庫位置

// 連接
$conn = new mysqli($servername, $username, '', $dbname); // ‘’為密碼，root預設沒有密碼所以空著

// 設置字符集編碼
$conn->set_charset("utf8");

// 查詢資料庫
$sql = "SELECT name, price FROM product";
$result = $conn->query($sql);

// 獲取資料庫內所有數據
$productData = [];
while ($row = $result->fetch_assoc()) {
    $productData[] = $row;
}

// 檢查是否有抓到使用者 ID
$user = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>老師傅</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="website icon" type="image/png" href="image/logo.png">
</head>

<body>
    <header>
        <h1>老師傅</h1>
    </header>
   
    <nav>
        <div class="nav-block">
            <?php if($user): ?>
                <a href="logout.php">會員登出</a>
            <?php else: ?>
                <a href="login.php">會員登入</a>
            <?php endif; ?>
            <a href="checkout.php">購物車</a>
        </div>
    </nav>


    <h2>電話:0909-244722</h2>
    <section>
    <?php
    for ($i = 0; $i < count($productData); $i++) {
        $image = sprintf("image/%02d.png", $i + 1);
        $name = $productData[$i]["name"];
        $price = $productData[$i]["price"];
        $productId = $i + 1; // 使用索引作為產品的ID
    ?>

        <div class="product" data-product-id="<?php echo $productId; ?>">
            <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
            <div class="product-info">
                <h2><?php echo $name; ?></h2>
                <p class="price">$<?php echo $price; ?></p>
            </div>
        </div>

    <?php
    }
    ?>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 選擇所有具有 'product' 類別的元素
        document.querySelectorAll('.product').forEach(function (product) {
            // 為每個產品元素添加點擊事件監聽器
            product.addEventListener('click', function () {
            // 獲取產品的唯一ID
                var productId = product.getAttribute('data-product-id');
        
                // 構建跳轉到相應網頁的URL，假設每個網頁以 'product_1.php' 命名
                window.location.href = 'product' + '.php?id=' + + productId;
            });
        });
    });
</script>

<footer>
    <p>版權所有 &copy; 老師傅</p>
</footer>

</body>
</html>