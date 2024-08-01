<?php
// Start session
session_start();

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to the database
$mysqli = new mysqli("localhost", "root", "Messi@123", "scamguard");

if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

$query = "
    SELECT p.post_id, p.user_id, p.title, p.content, p.image_path, p.rating, p.created_at, u.username,
           (SELECT COUNT(*) FROM likes WHERE likes.post_id = p.post_id) AS likes_count
    FROM posts p
    JOIN users u ON p.user_id = u.user_id
    ORDER BY p.created_at DESC
";

$result = $mysqli->query($query);

if ($result) {
    $posts = [];

    while ($row = $result->fetch_assoc()) {
        // Fetch comments for each post
        $comments_query = "SELECT c.comment_id, c.user_id, c.comment_text, c.created_at, u.username
                           FROM comments c
                           JOIN users u ON c.user_id = u.user_id
                           WHERE c.post_id = " . $row['post_id'] . "
                           ORDER BY c.created_at ASC";
        $comments_result = $mysqli->query($comments_query);

        $comments = [];
        while ($comment = $comments_result->fetch_assoc()) {
            $comments[] = [
                'comment_id' => $comment['comment_id'],
                'user_id' => $comment['user_id'],
                'username' => $comment['username'],
                'content' => $comment['comment_text'],
                'date' => $comment['created_at']
            ];
        }

        $posts[] = [
            'id' => $row['post_id'],
            'user_id' => $row['user_id'],
            'username' => $row['username'],
            'title' => $row['title'],
            'content' => $row['content'],
            'image' => $row['image_path'],
            'rating' => $row['rating'],
            'date' => $row['created_at'],
            'comments' => $comments,
            'likes' => $row['likes_count']
        ];
    }

    echo json_encode($posts);
} else {
    echo json_encode(['success' => false, 'error' => 'Query error: ' . $mysqli->error]);
}

$mysqli->close();
?>
