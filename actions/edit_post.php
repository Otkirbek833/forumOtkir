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
    die("Post ID aniqlanbadı.");
}

// POST MAǴLUWMATLARIN ALIW
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Bul post sizge tiyisli emes.");
}

$post = $result->fetch_assoc();

// SÚWRET ALIW
$image_res = $conn->query("SELECT * FROM post_images WHERE post_id = $post_id LIMIT 1");
$current_image = $image_res->fetch_assoc();

// FORM JIBERILGENDE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content']);

    if (empty($content)) {
        $error = "Xabar bos bolıw múmkin emes.";
    } else {
        // Xabar jańalaw
        $stmt = $conn->prepare("UPDATE posts SET content = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $content, $post_id, $user_id);
        $stmt->execute();

        // Súwret jańalandı
        if (!empty($_FILES['image']['name'])) {
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            $target_dir = "../uploads/";
            $target_file = $target_dir . $image_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_path = "uploads/" . $image_name;

                // aldınǵı súwrret óshiriw
                if ($current_image && file_exists('../' . $current_image['image_path'])) {
                    unlink('../' . $current_image['image_path']);
                    $conn->query("DELETE FROM post_images WHERE id = " . $current_image['id']);
                }

                // Jańa súwret qosıw
                $stmt = $conn->prepare("INSERT INTO post_images (post_id, image_path) VALUES (?, ?)");
                $stmt->bind_param("is", $post_id, $image_path);
                $stmt->execute();
            }
        }

        header('Location: ../pages/forum.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>Posttı Ózgertiw</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Posttı ózgertiw</h4>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Xabar:</label>
                    <textarea name="content" class="form-control" rows="5" required><?= htmlspecialchars($post['content']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Házirgi súwret:</label><br>
                    <?php if ($current_image): ?>
                        <img src="../<?= htmlspecialchars($current_image['image_path']) ?>" class="img-thumbnail mb-2" style="max-width: 200px;">
                    <?php else: ?>
                        <p><i>Súwret Joq</i></p>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label>Jańa súwret(ıqtıyarlı):</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-success">Saqlaw</button>
                <a href="../pages/forum.php" class="btn btn-secondary">Artqa</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
