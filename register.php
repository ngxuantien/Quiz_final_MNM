<?php
session_start();
require('inc/db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['pass'];
    $confirm_password = $_POST['cpass'];

    // Nếu mật khẩu không khớp
    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = 'Mật khẩu và xác nhận không khớp!';
        $_SESSION['open_modal'] = 'registerModal';
        header("Location: index.php");
        exit();
    }

    // Kiểm tra email đã tồn tại chưa
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $_SESSION['register_error'] = 'Email đã được sử dụng!';
        $_SESSION['open_modal'] = 'registerModal';
        header("Location: index.php");
        exit();
    }

    // Mã hóa mật khẩu và thêm người dùng
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['register_success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['register_error'] = 'Có lỗi xảy ra. Vui lòng thử lại!';
        $_SESSION['open_modal'] = 'registerModal';
        header("Location: index.php");
        exit();
    }
}
?>


