<?php
require('../inc/db_config.php');

if (!isset($_GET['id'])) {
    header("Location: add_subjects.php");
    exit();
}

$id = intval($_GET['id']);

// Lấy dữ liệu hiện tại
$stmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$subject = $result->fetch_assoc();

if (!$subject) {
    echo "Môn học không tồn tại.";
    exit();
}

// Xử lý cập nhật
if (isset($_POST['update_subject'])) {
    $name = trim($_POST['subject_name']);
    $desc = trim($_POST['subject_description']);

    if (!empty($name)) {
        $stmt = $conn->prepare("UPDATE subjects SET name = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $desc, $id);
        if ($stmt->execute()) {
            header("Location: index.php?updated=1");
            exit();
        } else {
            $msg = "❌ Lỗi khi cập nhật môn học.";
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
    <title>Sửa môn học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4 text-center">Cập nhật môn học</h3>

    <?php if (isset($msg)): ?>
        <div class="alert alert-warning text-center"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Tên môn học</label>
            <input type="text" class="form-control" name="subject_name" required value="<?= htmlspecialchars($subject['name']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả môn học</label>
            <textarea class="form-control" name="subject_description" rows="3"><?= htmlspecialchars($subject['description']) ?></textarea>
        </div>
        <button type="submit" name="update_subject" class="btn btn-success">Cập nhật</button>
        <a href="index.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>
