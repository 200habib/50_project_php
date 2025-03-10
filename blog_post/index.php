<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

// Handle comment submission
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    if (addComment($_POST['author'], $_POST['comment'])) {
        $message = '<div class="alert alert-success">Comment added successfully!</div>';
    } else {
        $message = '<div class="alert alert-error">Error adding comment. Please try again.</div>';
    }
}

// Get all comments
$comments = getComments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Blog Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <article class="post">
            <h1>Beautiful Sunset at the Beach</h1>
            <div class="post-meta">
                Posted on <?php echo formatDate(date('Y-m-d')); ?>
            </div>
            <div class="post-image">
                <img src="https://picsum.photos/800/400" alt="Beautiful Sunset" class="featured-image">
            </div>
            <div class="post-content">
                <p>
                    Experience the breathtaking view of a sunset at the beach. The golden rays reflecting off the ocean
                    create a magical atmosphere that reminds us of nature's incredible beauty. This photo was taken
                    during our recent trip to the coast, where we spent hours watching the sun slowly dip below the horizon.
                </p>
            </div>
        </article>

        <section class="comments-section">
            <h2>Comments</h2>
            
            <?php if ($message): ?>
                <?php echo $message; ?>
            <?php endif; ?>

            <form class="comment-form" method="POST">
                <div class="form-group">
                    <label for="author">Name:</label>
                    <input type="text" id="author" name="author" required>
                </div>
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea id="comment" name="comment" required></textarea>
                </div>
                <button type="submit">Post Comment</button>
            </form>

            <div class="comments-list">
                <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <div class="comment-author"><?php echo sanitize($comment['author']); ?></div>
                    <div class="comment-date"><?php echo formatDate($comment['created_at']); ?></div>
                    <div class="comment-text"><?php echo sanitize($comment['comment_text']); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>
</html>
