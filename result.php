<?php
session_start();
require('inc/db_config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$score = 0;

if (!isset($_POST['ans']) || !is_array($_POST['ans'])) {
    echo "<div class='alert alert-danger m-4'>Không có câu trả lời nào được gửi.</div>";
    exit;
}

// Tính điểm và lưu kết quả
foreach ($_POST['ans'] as $qid => $ans) {
    $qid = (int)$qid;
    $ans = $conn->real_escape_string($ans);

    $res = $conn->query("SELECT correct_option FROM questions WHERE id=$qid");
    if ($res && $row = $res->fetch_assoc()) {
        $is_correct = ($ans === $row['correct_option']) ? 1 : 0;
        $score += $is_correct;

        $conn->query("INSERT INTO user_answers (user_id, question_id, selected_option, is_correct)
                      VALUES ($user_id, $qid, '$ans', $is_correct)");
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Kết quả bài thi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5 text-center">
  <div class="card shadow p-4">
    <h2 class="text-success mb-4">Bạn đã hoàn thành bài kiểm tra!</h2>
    <h4 class="mb-3">Số câu đúng: <span class="text-primary fw-bold"><?= $score ?></span> / <?= count($_POST['ans']) ?></h4>

    <a href="index.php" class="btn btn-primary mt-4">Quay lại trang chủ</a>
  </div>
</div>

</body>
</html>
