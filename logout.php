<?php
session_start();
session_unset();    // Xoá tất cả biến session
session_destroy();  // Hủy session
header("Location: index.php"); // Chuyển hướng về trang chủ
exit();
