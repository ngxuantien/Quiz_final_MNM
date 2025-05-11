<?php
require('../inc/db_config.php');

// Xử lý thêm mới
if (isset($_POST['add_subject'])) {
    $name = trim($_POST['subject_name']);
    $desc = trim($_POST['subject_description']);

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO subjects (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $desc);
        if ($stmt->execute()) {
            header("Location: add_subjects.php?success=1");
            exit();
        } else {
            $msg = "❌ Lỗi khi thêm môn học.";
        }
    } else {
        $msg = "❗Tên môn học không được để trống!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý môn học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .h-font { font-family: 'Segoe UI', sans-serif; }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .alert-custom {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

  <!-- Header -->
  <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
      <h3 class="mb-0 h-font">TDMU Quiz app</h3>
      <a href="logout.php" class="btn btn-light btn-sm">Đăng xuất</a>
  </div>

  <!-- Dashboard Layout -->
  <div class="container-fluid">
      <div class="row">
          <!-- Sidebar -->
          <div class="col-lg-2 bg-dark border-top border-3 border-secondary vh-100" id="dashboard-menu">
              <nav class="navbar navbar-expand-lg navbar-dark">
                  <div class="container-fluid flex-lg-column align-items-stretch">
                      <h4 class="mt-2 text-light">Trang quản lí</h4>
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropdown">
                          <ul class="nav nav-pills flex-column">
                              <li class="nav-item">
                                  <a class="nav-link text-white" href="index.php">Quản lí môn học</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link text-white" href="add_question.php">Quản lí câu hỏi</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link text-white" href="dashboard.php">Quản lí người dùng</a>
                              </li>
                          </ul>
                      </div>
                  </div>
              </nav>
          </div>

          <!-- Main Content (right side) -->
          <div class="col-lg-10 mt-5">
              <div class="form-container">
                  <h3 class="form-title">Thêm môn học</h3>

                  <!-- Success or error messages -->
                  <?php if (isset($_GET['success'])): ?>
                      <div class="alert alert-success alert-custom text-center">✅ Thêm môn học thành công!</div>
                  <?php elseif (isset($msg)): ?>
                      <div class="alert alert-warning alert-custom text-center"><?= $msg ?></div>
                  <?php endif; ?>

                  <!-- Form to add subject -->
                  <form method="post">
                      <div class="mb-3">
                          <label class="form-label">Tên môn học</label>
                          <input type="text" class="form-control" name="subject_name" required>
                      </div>
                      <div class="mb-3">
                          <label class="form-label">Mô tả môn học</label>
                          <textarea class="form-control" name="subject_description" rows="3"></textarea>
                      </div>
                      <button type="submit" name="add_subject" class="btn btn-primary w-100">Thêm môn</button>
                  </form>
              </div>
          </div>
      </div>
  </div>

</body>
</html>
