<?php
session_start();
require('inc/db_config.php');

$error_msg = ''; // Khởi tạo thông báo lỗi

// Kiểm tra phương thức POST và dữ liệu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Kiểm tra nếu email hoặc mật khẩu rỗng
    if (empty($email) || empty($password)) {
        $error_msg = "Vui lòng nhập đầy đủ email và mật khẩu!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $user = $res->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                header("Location: index.php");
                exit();
            } else {
                $error_msg = "Sai mật khẩu!";
            }
        } else {
            $error_msg = "Email không tồn tại!";
        }
    }
}

// Gửi thông báo lỗi trở lại trang đăng nhập
$_SESSION['login_error'] = $error_msg;
header("Location: index.php#loginModal");
exit();
?>
