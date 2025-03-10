<?php
require_once 'config.php';

// Get all comments for a post
function getComments() {
    $conn = getDBConnection();
    $comments = [];
    $result = mysqli_query($conn, "SELECT * FROM comments ORDER BY created_at DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }
    mysqli_close($conn);
    return $comments;
}

// Add new comment
function addComment($author, $comment) {
    $conn = getDBConnection();
    $author = mysqli_real_escape_string($conn, $author);
    $comment = mysqli_real_escape_string($conn, $comment);
    
    $sql = "INSERT INTO comments (author, comment_text, created_at) VALUES ('$author', '$comment', NOW())";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

// Format date
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

// Sanitize output
function sanitize($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>
