<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Hệ thống thi trắc nghiệm - Đại học Thủ Dầu Một</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color:rgb(138, 196, 254);
      font-family: 'Segoe UI', sans-serif;
      color: #333;
    }

    .hero {
      background: url('https://images.unsplash.com/photo-1581092334963-3544a03de2a4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') no-repeat center center/cover;
      color: white;
      position: relative;
    }

    .hero-overlay {
      background-color: rgba(11, 166, 233, 0.65);
      padding: 100px 20px;
      border-radius: 10px;
    }

    .card {
      border: none;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background-color: #ffffff;
      border-radius: 12px;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .card-title {
      color: #0d6efd;
    }

    .btn-dark {
      background-color: #0d6efd;
      border: none;
      transition: background-color 0.3s ease;
    }

    .btn-dark:hover {
      background-color: #084298;
    }

    footer {
      background-color: #0d6efd;
    }

    .modal-content {
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .alert {
      font-size: 0.95rem;
    }
  </style>
</head>
<body>

<?php require('inc/header.php'); ?>

<!-- Hero section -->
<section class="hero">
  <div class="hero-overlay text-center">
    <div class="container">
      <h1 class="display-4 fw-bold">Hệ thống thi trắc nghiệm trực tuyến</h1>
      <p class="lead">Dành cho sinh viên Đại học Thủ Dầu Một</p>
      <a href="subject_list.php" class="btn btn-light btn-lg mt-3 px-4 py-2" style="border-radius: 50px; font-weight: bold;">
        Bắt đầu thi ngay
      </a>
    </div>
  </div>
</section>

<!-- Features -->
<section class="py-5">
  <div class="container text-center">
    <h2 class="mb-4">Tính năng nổi bật</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-journal-text me-2 text-primary"></i>Ngân hàng câu hỏi phong phú
            </h5>
            <p class="card-text">Bao gồm nhiều môn học theo chương trình đào tạo của trường.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-clipboard2-check me-2 text-success"></i>Chấm điểm tự động
            </h5>
            <p class="card-text">Hệ thống tính điểm và hiển thị kết quả ngay sau khi hoàn thành bài thi.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-graph-up-arrow me-2 text-warning"></i>Thống kê kết quả
            </h5>
            <p class="card-text">Theo dõi tiến độ học tập và kết quả thi của bạn dễ dàng.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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

<!-- Footer -->
<footer class="text-white text-center py-3 mt-5">
  <div class="container">
    Đại học Thủ Dầu Một - Hệ thống thi trắc nghiệm
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php if (isset($_SESSION['open_modal'])): ?>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var modal = new bootstrap.Modal(document.getElementById("<?php echo $_SESSION['open_modal']; ?>"));
    modal.show();
  });
</script>
<?php unset($_SESSION['open_modal']); endif; ?>

<?php if (isset($_SESSION['register_success'])): ?>
  <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
    <?= $_SESSION['register_success']; unset($_SESSION['register_success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
  </div>
<?php endif; ?>

</body>
</html>
