<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require('../inc/db_config.php');

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php");
    exit();
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!DOCTYPE html>
<html>
<head>
    <title>Quản trị hệ thống</title>
</head>
<body>
<body class="bg-light">

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
                                  <a class="nav-link text-white" href="#">Quản lí người dùng</a>
                              </li>
                          </ul>
                      </div>
                  </div>
              </nav>
          </div>

          <!-- Main Content (right side) -->
          <div class="col-lg-10 mt-5">
              <div class="container">
                  <h4>Danh sách môn học</h4>
                  <!-- Success or error messages -->
                  <?php if (isset($_GET['success'])): ?>
                      <div class="alert alert-success text-center">✅ Xóa môn học thành công!</div>
                  <?php elseif (isset($msg)): ?>
                      <div class="alert alert-warning text-center"><?= $msg ?></div>
                  <?php endif; ?>
                  <a href="add_subjects.php" class="btn btn-dark mb-3">Thêm môn học</a>

                  <!-- Subject List Table -->
                  <table class="table table-bordered table-striped">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>Tên</th>
                              <th>Mô tả</th>
                              <th>Hành động</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                      
                      $result = $conn->query("SELECT * FROM subjects");
                      if ($result->num_rows > 0):
                          while ($row = $result->fetch_assoc()):
                      ?>
                          <tr>
                              <td><?= $row['id'] ?></td>
                              <td><?= htmlspecialchars($row['name']) ?></td>
                              <td><?= htmlspecialchars($row['description']) ?></td>
                              <td>
                                  <a href="edit_subjects.php?id=<?= $row['id'] ?>" class="btn btn-dark btn-sm">Sửa</a>
                                  <a href="index.php?delete=<?= $row['id'] ?>" onclick="return confirm('Xóa môn học này?')" class="btn btn-dark btn-sm">Xóa</a>
                              </td>
                          </tr>
                      <?php endwhile; else: ?>
                          <tr><td colspan="4">Không có môn học nào.</td></tr>
                      <?php endif; ?>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>

</body>
</html>
