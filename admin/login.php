<?php
session_start();
include('../inc/db_config.php');

if (isset($_POST['login'])) {
    $name = $_POST['name'];
    $pass = $_POST['pass'];

    // Truy vấn người dùng có quyền admin
    $stmt = $conn->prepare("SELECT * FROM admin WHERE name = ? AND pass = ?");
    $stmt->bind_param("ss", $name, $pass);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['pass'] === $pass) {
        $_SESSION['admin'] = $user['name'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Sai tên hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            margin: 100px auto;
        }
        .custom-bg {
            background-color: #0d6efd;
        }
        .custom-bg:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>

<div class="login-form text-center rounded bg-white shadow overflow-hidden">
    <form method="POST">
        <h4 class="bg-dark text-white py-3">Đăng nhập cho quản trị</h4>
        <div class="p-4">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <input name="name" required type="text" class="form-control shadow-none text-center" placeholder="Tên đăng nhập">
            </div>
            <div class="mb-4">
                <input name="pass" required type="password" class="form-control shadow-none text-center" placeholder="Mật khẩu">
            </div>
            <button name="login" type="submit" class="btn btn-dark text-white shadow-none w-100">Đăng nhập</button>
        </div>
    </form>
</div>

</body>
</html>
