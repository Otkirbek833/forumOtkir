<?php
session_start();
include('../includes/db.php');

// Foydalanuvchi tizimga kirganligini tekshirish
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $post_id = intval($_POST['post_id']);
    $content = trim($_POST['content']);

    if ($content !== '') {
       
        $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $post_id, $user_id, $content);
        $stmt->execute();
        $stmt->close();
    }
}

// Forum aynasına qaytıw
header('Location: ../pages/forum.php');
exit();
?>
