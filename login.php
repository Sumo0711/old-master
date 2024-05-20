<?php
session_start(); // 開始 session

$servername = "localhost"; // MySQL位置
$username = "root"; // 帳號登入
$dbname = "old-master"; // 資料庫位置

// 連接到 MySQL 資料庫
$conn = new mysqli($servername, $username, '', $dbname);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 設置字元集編碼
$conn->set_charset("utf8");

// 如果是 POST 請求，進行使用者名稱和密碼的檢查
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // 查詢資料庫以檢查使用者是否存在
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 使用者名稱和密碼匹配，登錄成功
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["u_id"]; // 將使用者 id 存入 session
        // 重新導向到 index.php 頁面
        header("Location: index.php");
        exit; // 確保在重新導向後不再執行任何程式碼
    } else {
        // 使用者名稱和密碼不匹配，登錄失敗
        echo "<script>alert('使用者名稱或密碼錯誤');</script>";
    }    
}

// 關閉資料庫連接
$conn->close();
?>



<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>老師傅</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <header>
        <div class="logo" onclick="goToIndex()">
            <h1>老師傅</h1>
        </div>
    </header>
</head>
<body>
    <div class="container">
    <h2>會員登錄</h2>
        <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" id="username" placeholder="用戶名" required><br>
            <input type="password" name="password" id="password" placeholder="密碼" required><br>
            <input type="submit" value="登錄">
            <button onclick="redirectToRegister()">註冊</button>
        </form>
    </div>

    <script>
        function redirectToRegister() {
            // 在這裡指定註冊頁面的 URL
            window.location.href = "register.php";
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
