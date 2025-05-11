<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- <style>
    body {
        background-color:rgb(93, 183, 252);
    }
</style> -->

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">Trắc nghiệm TDMU</a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link me-2" href="../index.php">Trang chủ</a>
            </li>
            <li class="nav-item">
            <a class="nav-link me-2" href="../subject_list.php">Môn học</a>
            </li>
            <li class="nav-item">
            <a class="nav-link me-2" href="#">Thông tin thêm</a>
            </li>
        </ul>
        <div class="d-flex">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="me-3 btn btn-outline-dark shadow-none">Xin chào, <?php echo $_SESSION['name']; ?></span>
            <a href="logout.php" class="btn btn-outline-danger shadow-none">Đăng xuất</a>
            <?php else: ?>
            <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                Đăng nhập
            </button>
            <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
                Đăng ký
            </button>
            <?php endif; ?>
        </div>
        </div>
    </div>
    </nav>

    <!-- Modal đăng nhập -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" action="login.php">
            <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-person-circle fs-3 me-2"></i> Đăng nhập</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
                <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    loginModal.show();
                });
                </script>
            <?php endif; ?>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control shadow-none" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control shadow-none" required>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" name="login" class="btn btn-dark shadow-none">Đăng nhập</button>
                <a href="#" class="text-secondary">Quên mật khẩu?</a>
            </div>
            </div>
        </form>
        </div>
    </div>
    </div>

    <!-- Modal đăng ký -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <!-- Hiển thị lỗi -->
        <?php if (isset($_SESSION['register_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <?= $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        <?php endif; ?>
        
        <form action="register.php" method="POST">
            <div class="modal-header">
            <h5 class="modal-title" id="registerModalLabel">Đăng ký tài khoản</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Họ tên</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" name="pass" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" name="cpass" required>
            </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
            <button type="submit" class="btn btn-dark shadow-none">Đăng ký</button>
            <a href="#" class="text-secondary" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Đăng nhập ngay</a>
            </div>
        </form>
        </div>
    </div>
    </div>
</body>
