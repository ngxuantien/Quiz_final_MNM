<?php
require('../inc/db_config.php');
$res = $conn->query("SELECT users.name, COUNT(*) as total, SUM(is_correct) as correct
                     FROM user_answers
                     JOIN users ON users.id = user_answers.user_id
                     GROUP BY user_id");
while ($row = $res->fetch_assoc()) {
    echo "<p>{$row['name']}: {$row['correct']} đúng / {$row['total']} câu</p>";
}
?>