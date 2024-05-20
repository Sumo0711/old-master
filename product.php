<?php
session_start();
$servername = "localhost";
$username = "root";
$dbname = "old-master";
$conn = new mysqli($servername, $username, '', $dbname);

// 確認連線
if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}

$conn->set_charset("utf8");

$user = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $sql = "SELECT name, price, slogan FROM product WHERE p_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $productDetails = $result->fetch_assoc();
    } else {
        header("Location: /404.php");
        exit();
    }
} else {
    header("Location: /404.php");
    exit();
}

function addToCart($user, $productId, $amount) {
    global $conn;

    $cartItem = array(
        'user_id' => $user,
        'product_id' => $productId,
        'amount' => $amount
    );

    $sql = "INSERT INTO `shop_cart`(`user_id`, `product_id`, `amount`) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $user, $productId, $amount);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>老師傅</title>
    <style>
body, h1, h2, p {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif; /* 設置字體 */
    text-align: center; /* 文字置中 */
}

/* 主體樣式 */
body {
    background-color: #f4f4f4; /* 背景顏色 */
    color: #333; /* 文字顏色 */
    display: flex; /* 使用 flex 布局 */
    flex-direction: column; /* 垂直排列 */
    align-items: center; /* 內容居中對齊 */
    background: #CDE8E5;  /* 背景顏色 */
}

/* 頁頭樣式 */
header {
    background-color: #7AB2B2; /* 背景顏色 */
    color: #EEF7FF; /* 文字顏色 */
    padding: 1rem; /* 內邊距 */
    width: 100%; /* 寬度 100% */
    text-align: center; /* 文字居中對齊 */
    min-height: 80px; /* 高度調整 */
}

h1 {
    color: #EEF7FF; /* 標題顏色 */
    text-align: center; /* 文字置中 */
    margin: 20px 0; /* 上下間距 */
}

/* 主內容樣式 */
main {
    padding: 2rem; /* 內邊距 */
    max-width: 1000px; /* 最大寬度 900px */
    width: 100%; /* 寬度 100% */
}

h2 {
    text-align: center; /* 文字居中對齊 */
    margin-bottom: 2rem; /* 底部外邊距 2rem */
    font-size: 2rem; /* 字體大小 2rem */
    color: #4D869C; /* 字體顏色 */
}

/* 產品樣式 */
.product {
    display: flex; /* 使用 flex 布局 */
    background-color: white; /* 背景顏色白色 */
    padding: 2rem; /* 內邊距 */
    border-radius: 8px; /* 圓角 */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* 投影效果 */
}

.product img {
    width: 60%; /* 寬度 70% */
    height: auto; /* 自動高度 */
    border-radius: 8px; /* 圓角 */
    margin-right: 2rem; /* 右邊距 2rem */
}

.product-info {
    flex: 1; /* 填滿剩餘空間 */
    display: flex; /* 使用 flex 布局 */
    flex-direction: column; /* 垂直排列 */
    justify-content: center; /* 垂直居中對齊 */
}

.product-info p {
    margin: 0.5rem 0; /* 垂直外邊距 0.5rem */
    font-size: 1.1rem; /* 字體大小 1.1rem */
    color: #666; /* 字體顏色 */
    text-align: center;
}

.product-info .price {
    font-size: 1.5rem; /* 字體大小 1.5rem */
    color: #e44d26; /* 字體顏色 */
    font-weight: bold; /* 粗體 */
    margin: 1rem 0; /* 垂直外邊距 1rem */
    text-align: center;
}

form {
    display: flex; /* 使用 flex 布局 */
    flex-direction: column; /* 垂直排列 */
    align-items: center; /* 水平居中對齊 */
}

.quantity {
    display: flex; /* 使用 flex 布局 */
    align-items: center; /* 垂直居中對齊 */
    margin-bottom: 1rem; /* 底部外邊距 1rem */
}

.quantity-button {
    background-color: #7AB2B2; /* 背景顏色 */
    color: white; /* 文字顏色 */
    border: none; /* 無邊框 */
    padding: 0.5rem 1rem; /* 內邊距 */
    cursor: pointer; /* 鼠標變成指針 */
    font-size: 1.2rem; /* 字體大小 1.2rem */
    transition: background-color 0.3s; /* 背景顏色過渡效果 */
    border-radius: 4px; /* 圓角 */
}

.quantity-button:hover {
    background-color: #7AB2B2; /* 懸停時背景顏色 */
}

form input[type="number"] {
    width: 60px; /* 寬度 60px */
    padding: 0.5rem; /* 內邊距 */
    margin: 0 0.5rem; /* 水平外邊距 0.5rem */
    border: 1px solid #7AB2B2; /* 邊框 */
    border-radius: 4px; /* 圓角 */
    text-align: center; /* 文字居中對齊 */
}

.add-to-cart-button {
    background-color: #7AB2B2; /* 背景顏色 */
    color: white; /* 文字顏色 */
    border: none; /* 無邊框 */
    padding: 0.75rem 1.5rem; /* 內邊距 */
    border-radius: 4px; /* 圓角 */
    cursor: pointer; /* 鼠標變成指針 */
    font-size: 1rem; /* 字體大小 1rem */
    transition: background-color 0.3s; /* 背景顏色過渡效果 */
    margin-top: 1rem; /* 頂部外邊距 1rem */
}

.add-to-cart-button:hover {
    background-color: #555; /* 懸停時背景顏色 */
}

/* 隱藏數字輸入框的上下按鈕 */
input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

/* 頁腳樣式 */
footer {
    background-color: #7AB2B2; /* 頁腳背景顏色 */
    color: #EEF7FF; /* 文字顏色 */
    text-align: center; /* 文字居中對齊 */
    padding: 1rem; /* 內邊距 */
    width: 100%; /* 寬度 100% */
    margin-top: auto; /* 確保頁腳在頁面底部 */
    min-height: 50px; /* 高度調整 */
}

    </style>
</head>
<body>
    <header>
        <div class="logo" onclick="goToIndex()">
            <h1>老師傅</h1>
        </div>
    </header>
    <main>
        <div class="product">
            <img src="image/<?php echo sprintf("%02d", $productId); ?>.png" alt="<?php echo $productDetails['name']; ?> Image">
            <div class="product-info">
                <h2><?php echo $productDetails['name']; ?></h2>
                <p><?php echo $productDetails['slogan']; ?></p>
                <p class="price">$<?php echo $productDetails['price']; ?></p>
                <form id="addToCartForm" method="post" action="shop_cart.php">
                    <input type="hidden" name="user_id" value="<?php echo $user; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                    <div class="quantity">
                        <button type="button" class="quantity-button" onclick="changeAmount(-1)">-</button>
                        <input id="amountInput" type="number" name="amount" value="1" min="1" style="font-size: 20px;">
                        <button type="button" class="quantity-button" onclick="changeAmount(1)">+</button>
                    </div>
                    <button id="addToCartButton" type="submit" class="add-to-cart-button">加入購物車</button>
                </form>
            </div>
        </div>
    </main>
    <script>
        function changeAmount(change) {
            const amountInput = document.getElementById('amountInput');
            let amount = parseInt(amountInput.value);
            amount = isNaN(amount) ? 1 : amount;
            amount = Math.max(1, amount + change);
            amountInput.value = amount;
        }

        function addToCart(user, productId, amount) {
            const quantity = parseInt(amount);

            if (quantity <= 0) {
                alert("Please select a valid quantity!");
                return;
            }

            console.log("User: " + user);
            console.log("Product ID: " + productId);
            console.log("Amount: " + amount);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const addToCartButton = document.getElementById('addToCartButton');

            addToCartButton.addEventListener('click', function() {
                const user = '<?php echo $user; ?>';
                const productId = '<?php echo $productId; ?>';
                const amount = document.getElementById('amountInput').value;

                addToCart(user, productId, amount);
            });
        });

        function goToIndex() {
            window.location.href = "index.php";
        }
    </script>
    <footer>
        <p>版權所有 &copy; 老師傅</p>
    </footer>
</body>
</html>
