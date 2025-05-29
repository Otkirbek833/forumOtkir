<?php
session_start();
include('../includes/db.php');
if (!isset($_SESSION['user_id'])) exit();

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$comment = $_POST['comment'];

$stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iis", $post_id, $user_id, $comment);
$stmt->execute();

header("Location: ../pages/forum.php");
exit();
?>