<?php
$servername = "localhost"; // MySQL位置
$username = "root"; // 帳號登入
$dbname = "old-master"; // 資料庫位置

// 連接
$conn = new mysqli($servername, $username, '', $dbname);

// 檢查連接是否成功
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 設置字符集編碼
$conn->set_charset("utf8");

// 定義用於顯示錯誤信息的變量
$error_message = "";

// 處理用戶註冊
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $phone = $_POST["phone"];

    // 確認兩次輸入的密碼一致
    if ($password !== $confirmPassword) {
        $error_message = "兩次輸入的密碼不一致";
    }

    // 確認手機號格式是否正確
    if (!preg_match("/^09\d{8}$/", $phone)) {
        $error_message = "手機號碼格式不正確，請輸入正確的手機號碼";
    }

    // 檢查用戶名、電子郵箱和手機號是否已存在
    $sql_check_existing = "SELECT * FROM user WHERE username='$username' OR  phone='$phone'";
    $result_check_existing = $conn->query($sql_check_existing);
    if ($result_check_existing->num_rows > 0) {
        $error_message = "該用戶名、電子郵箱或手機號已被註冊，請嘗試其他信息";
    }

    // 如果沒有錯誤，則將用戶訊息寫進資料庫
    if ($error_message == "") {
        $sql = "INSERT INTO user (username, password, phone)
                VALUES ('$username', '$password', '$phone')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('註冊成功'); window.location.href = 'login.php';</script>";
        exit();
    } 
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>老師傅</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <header>
        <div class="logo" onclick="goToIndex()">
            <h1>老師傅</h1>
        </div>
    </header>
</head>
<body>
    <div class="container">
        <h2>會員註冊</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" id="username" placeholder="用戶名" required><br>
            <input type="password" name="password" id="password" placeholder="密碼" required><br>
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="確認密碼" required><br>
            <input type="tel" name="phone" id="phone" placeholder="電話號碼" required><br>
            <input type="submit" value="註冊">
        </form>
        <?php if($error_message != ""): ?>
            <script>
                alert("<?php echo $error_message; ?>");
            </script>
        <?php endif; ?>
    </div>
    <script>
        function goToIndex() {
            window.location.href = "index.php";
        }
    </script>
    <footer>
        <p>版權所有 &copy; 老師傅</p>
    </footer>
</body>
</html>
