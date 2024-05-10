<?php
session_start();

// 銷毀所有會話資訊
session_destroy();

// 重新導向到登入頁面
header("Location: index.php");
exit;
?>
