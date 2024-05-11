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
    <link rel="stylesheet" type="text/css" href="css/product.css">
    <header>
        <div class="logo" onclick="goToIndex()">
            <h1>老師傅</h1>
        </div>
    </header>
</head>
<body>
    <h2><?php echo $productDetails['name']; ?></h2>
    <main>
        <div class="product">
            <img src="image/<?php echo sprintf("%02d", $productId); ?>.png" alt="<?php echo $productDetails['name']; ?> Image">
            <div class="product-info">
                <p><?php echo $productDetails['slogan']; ?></p>
                <p class="price">$<?php echo $productDetails['price']; ?></p>
                <form id="addToCartForm" method="post" action="shop_cart.php">
                    <input type="hidden" name="user_id" value="<?php echo $user; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                    <input id="amountInput" type="number" name="amount" value="1" min="1">
                    <button id="addToCartButton" type="submit" class="add-to-cart-button">加入購物車</button>
                </form>
            </div>
        </div>
    </main>
    <script>
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