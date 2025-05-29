<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_GET['id'] ?? null;

if (!$post_id) {
    die("Post ID anıqlanbadı.");
}

// posttı óshiriw ózine tiyisli
$stmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();


$stmt_img = $conn->prepare("SELECT image_path FROM post_images WHERE post_id = ?");
$stmt_img->bind_param("i", $post_id);
$stmt_img->execute();
$res = $stmt_img->get_result();
while ($row = $res->fetch_assoc()) {
    $img_path = '../' . $row['image_path'];
    if (file_exists($img_path)) {
        unlink($img_path);
    }
}
$conn->query("DELETE FROM post_images WHERE post_id = $post_id");
$conn->query("DELETE FROM comments WHERE post_id = $post_id");

header('Location: ../pages/forum.php');
exit();
?>
