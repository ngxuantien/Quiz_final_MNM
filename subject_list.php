<?php
session_start();
require('inc/db_config.php');

// Lấy danh sách môn học từ CSDL
$result = $conn->query("SELECT id, name, description FROM subjects");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chọn môn học</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #eaf4fc;
      font-family: 'Segoe UI', sans-serif;
    }

    h2 {
      color: #0d6efd;
    }

    .card {
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .card-title {
      font-weight: bold;
      color: #0d6efd;
    }

    .btn-primary {
      background-color: #0d6efd;
      border: none;
      font-weight: 500;
      border-radius: 50px;
      padding: 8px 20px;
    }

    .btn-primary:hover {
      background-color: #084298;
    }

    footer {
      background-color: #0d6efd;
      color: white;
      padding: 10px 0;
    }

    .subject-icon {
      font-size: 2.5rem;
      color: #0d6efd;
    }
  </style>
</head>
<body>

<?php require('inc/header.php'); ?>

<div class="container my-5">
  <h2 class="mb-4 text-center">📚 Danh sách môn học</h2>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col">
        <div class="card h-100 text-center">
          <div class="card-body">
            <div class="mb-3">
              <i class="bi bi-book subject-icon"></i>
            </div>
            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
            <a href="quiz.php?sub_id=<?php echo $row['id']; ?>" class="btn btn-primary mt-2">Làm bài</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- <footer class="text-center">
  <div class="container">
    Hệ thống thi trắc nghiệm - Đại học Thủ Dầu Một
  </div>
</footer> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
