<?php
session_start();
include('../includes/db.php');
if (!isset($_SESSION['user_id'])) exit();

$user_id = $_SESSION['user_id'];
$content = $_POST['content'];

$stmt = $conn->prepare("INSERT INTO posts (user_id, content, created_at) VALUES (?, ?, NOW())");
$stmt->bind_param("is", $user_id, $content);
$stmt->execute();
$post_id = $stmt->insert_id;

if (!empty($_FILES['image']['name'])) {
    $file_name = basename($_FILES["image"]["name"]);
    $target_dir = "../uploads/";
    $target_file = $target_dir . time() . "_" . $file_name;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $image_path = "uploads/" . basename($target_file);
    $img_stmt = $conn->prepare("INSERT INTO post_images (post_id, image_path) VALUES (?, ?)");
    $img_stmt->bind_param("is", $post_id, $image_path);
    $img_stmt->execute();
}

header("Location: ../pages/forum.php");
exit();
?>