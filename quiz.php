<?php
session_start();
require('inc/db_config.php');

// Kiểm tra đăng nhập
$loggedIn = isset($_SESSION['user_id']);
if (!$loggedIn) {
    $_SESSION['login_error'] = "Bạn cần đăng nhập để làm bài!";
    header('Location: index.php');
    exit();
}

// Lấy sub_id từ URL
if (!isset($_GET['sub_id']) || !is_numeric($_GET['sub_id'])) {
    echo "❌ Không tìm thấy môn học!";
    exit();
}
$sub_id = (int) $_GET['sub_id'];


// Lấy 5 câu hỏi ngẫu nhiên theo môn học (sub_id)
$stmt = $conn->prepare("SELECT * FROM questions WHERE sub_id = ? ORDER BY RAND() LIMIT 5");
$stmt->bind_param("i", $sub_id);
$stmt->execute();
$res = $stmt->get_result();
// $res = $conn->query("SELECT * FROM questions ORDER BY RAND() LIMIT 5");

// Kiểm tra nếu không có câu hỏi
if ($res->num_rows === 0) {
    echo '
    <div class="text-center mt-5">
        <div class="alert alert-warning d-inline-block">
            Hiện chưa có câu hỏi nào cho môn học này.
        </div>
        <div class="mt-3">
            <a href="subject_list.php" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>';
    exit();
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Làm bài trắc nghiệm</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<?php require('inc/header.php'); ?>

<div class="container my-5">
  <h2 class="mb-4">Bài kiểm tra trắc nghiệm</h2>

  <form method="post" action="result.php" id="quizForm">
    <?php while ($row = $res->fetch_assoc()): ?>
      <div class="card mb-4 shadow-sm">
        <div class="card-body">
          <h5 class="card-title"><?php echo htmlspecialchars($row['question_text']); ?></h5>
          <?php foreach (['a','b','c','d'] as $opt): ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="ans[<?php echo $row['id']; ?>]" value="<?php echo $opt; ?>" required>
              <label class="form-check-label">
                <?php echo htmlspecialchars($row['option_' . $opt]); ?>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endwhile; ?>

    <button type="submit" class="btn btn-success">Nộp bài</button>
    <a href="subject_list.php" class="btn btn-secondary ms-2">Quay lại</a>
  </form>

  <?php if (!$loggedIn): ?>
    <div class="alert alert-warning mt-3">Bạn cần đăng nhập để làm bài!</div>
  <?php endif; ?>
</div>

<!-- Script hiển thị modal đăng nhập nếu chưa đăng nhập -->
<?php if (!$loggedIn): ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
      loginModal.show();

      // Ngăn nộp bài khi chưa đăng nhập
      document.getElementById("quizForm").addEventListener("submit", function (e) {
        e.preventDefault();
        loginModal.show();
      });
    });
  </script>
<?php endif; ?>

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

</body>
</html>
