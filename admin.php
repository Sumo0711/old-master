<?php
$servername = "localhost";
$username = "root";
$dbname = "old-master";

// 連接資料庫
$conn = new mysqli($servername, $username, '', $dbname);
$conn->set_charset("utf8");

// 查詢資料庫
$sql = "SELECT p_id, name, inventory FROM product";
$result = $conn->query($sql);

// 獲取資料庫內所有數據
$productData = [];
while ($row = $result->fetch_assoc()) {
    $productData[] = $row;
}
?>

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
        <h1>管理員控制台</h1>
    </header>
    <nav>
        <div class="nav-block">
            <a href="open_store.php">開店</a>
            <a href="close_store.php">關店</a>
            <a href="admin_order_control.php">餐點管理</a>
            <a href="admin_income.php">總營收</a>
        </div>
    </nav>
    <section>
        <?php foreach ($productData as $product): ?>
            <div class="product <?php echo $product['inventory'] == 0 ? 'out-of-stock' : ''; ?>" data-product-id="<?php echo $product['p_id']; ?>">
                <img src="image/<?php printf('%02d', $product['p_id']); ?>.png" alt="<?php echo $product['name']; ?>">
                <div class="product-info">
                    <h2><?php echo $product['name']; ?></h2>
                    <div class="inventory-control">
                        <button class="toggle-inventory"><?php echo $product['inventory'] == 0 ? '有貨' : '完售'; ?></button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.product').forEach(function (product) {
                var productId = product.getAttribute('data-product-id');
                var toggleButton = product.querySelector('.toggle-inventory');

                toggleButton.addEventListener('click', function () {
                    var newInventory = toggleButton.textContent === '完售' ? 0 : 1;
                    updateInventory(productId, newInventory, product, toggleButton);
                });
            });

            function updateInventory(productId, newInventory, product, toggleButton) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_inventory.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        toggleButton.textContent = newInventory === 0 ? '有貨' : '完售';
                        product.classList.toggle('out-of-stock', newInventory === 0);
                    } else {
                        alert('Failed to update inventory');
                    }
                };
                xhr.send('p_id=' + productId + '&inventory=' + newInventory);
            }
        });
    </script>
</body>

</html>
