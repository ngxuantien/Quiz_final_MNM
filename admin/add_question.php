<?php
require('../inc/db_config.php');

// Lấy danh sách môn học để hiển thị trong select box
$subjects = $conn->query("SELECT id, name FROM subjects");

if (isset($_POST['add'])) {
    $sub_id = $_POST['sub_id'];
    $q = $_POST['question'];
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $d = $_POST['d'];
    $correct = strtolower($_POST['correct']); // đưa về chữ thường để đồng bộ DB

    // Thêm vào bảng questions
    $stmt = $conn->prepare("INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_option, sub_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $q, $a, $b, $c, $d, $correct, $sub_id);
    
    if ($stmt->execute()) {
        $success_msg = "✅ Đã thêm câu hỏi thành công!";
    } else {
        $error_msg = "❌ Thêm thất bại. Vui lòng kiểm tra dữ liệu.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thêm câu hỏi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
  <h2 class="mb-4">Thêm câu hỏi trắc nghiệm</h2>

  <?php if (isset($success_msg)): ?>
    <div class="alert alert-success"><?php echo $success_msg; ?></div>
  <?php elseif (isset($error_msg)): ?>
    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
  <?php endif; ?>

  <form method="post" class="p-4 border rounded bg-light shadow-sm">
    <div class="mb-3">
      <label class="form-label">Chọn môn học</label>
      <select name="sub_id" class="form-select" required>
        <option value="">-- Chọn môn học --</option>
        <?php while ($row = $subjects->fetch_assoc()): ?>
          <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Câu hỏi</label>
      <input type="text" name="question" class="form-control" required>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Đáp án A</label>
        <input type="text" name="a" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Đáp án B</label>
        <input type="text" name="b" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Đáp án C</label>
        <input type="text" name="c" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Đáp án D</label>
        <input type="text" name="d" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Đáp án đúng (a, b, c, d)</label>
      <input type="text" name="correct" class="form-control" pattern="[a-dA-D]" required>
    </div>

    <button type="submit" name="add" class="btn btn-primary">Thêm câu hỏi</button>
    <div class="mt-3">
      <a href="index.php" class="btn btn-secondary">Quay lại trang chủ</a>
    </div>
  </form>
</div>
</body>
</html>
