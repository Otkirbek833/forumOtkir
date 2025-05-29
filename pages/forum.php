<?php  
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>Forum</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial;
            background: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .post-image {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
            display: block;
            margin: 10px 0;
        }

        .comment {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
        }

        .overlay {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="overlay">
        <h2 class="text-center mb-4">FORUM PLATFORMASI</h2>

        <!-- Post Jiberiw -->
        <form action="../actions/post_message.php" method="POST" enctype="multipart/form-data">
            <label for="content" class="form-label">Xabar</label>
            <textarea name="content" id="content" class="form-control" rows="3" required></textarea>

            <label for="image" class="form-label mt-2">Súwret (ıqtıyarlı)</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">

            <button type="submit" class="btn btn-primary mt-3">Jiberiw</button>
        </form>

        <!-- Postlar -->
        <?php
        $posts = $conn->query("SELECT p.id, p.content, p.created_at, p.user_id, u.username 
                               FROM posts p 
                               JOIN users u ON p.user_id = u.id 
                               ORDER BY p.created_at DESC");

        while ($row = $posts->fetch_assoc()):
            $post_id = $row['id'];
        ?>
        <div class="card my-4">
            <div class="card-body">
                <h5><?= htmlspecialchars($row['username']) ?></h5>
                <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                <small class="text-muted"><?= $row['created_at'] ?></small>

                <!-- Súwret -->
                <?php
                $images = $conn->query("SELECT image_path FROM post_images WHERE post_id = $post_id");
                while ($img = $images->fetch_assoc()):
                ?>
                    <img src="../<?= htmlspecialchars($img['image_path']) ?>" class="post-image" alt="Post rasmi">
                <?php endwhile; ?>

                <!-- ózgertiw ham óshiriw -->
                <?php if ($row['user_id'] == $user_id): ?>
                    <div class="mt-3">
                        <a href="../actions/edit_post.php?id=<?= $post_id ?>" class="btn btn-warning btn-sm">Ózgertiw</a>
                        <a href="../actions/delete_post.php?id=<?= $post_id ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Usı posttı óshiresizbe ?')">Óshiriw</a>
                    </div>
                <?php endif; ?>

                <!-- Kommentariyalar -->
                <div class="comments mt-4">
                    <h6>Komentariyalar:</h6>
                    <?php
                    $comments = $conn->query("SELECT c.content, c.created_at, u.username 
                                              FROM comments c 
                                              JOIN users u ON c.user_id = u.id 
                                              WHERE c.post_id = $post_id 
                                              ORDER BY c.created_at ASC");
                    while ($comment = $comments->fetch_assoc()):
                    ?>
                        <div class="comment mb-2">
                            <strong><?= htmlspecialchars($comment['username']) ?></strong>
                            <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                            <small class="text-muted"><?= $comment['created_at'] ?></small>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Komment jazıw -->
                <form action="../actions/post_comment.php" method="POST" class="mt-2">
                    <input type="hidden" name="post_id" value="<?= $post_id ?>">
                    <textarea name="content" class="form-control" rows="2" placeholder="Komment jazıń..." required></textarea>
                    <button type="submit" class="btn btn-secondary btn-sm mt-2">Jiberiw</button>
                </form>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
