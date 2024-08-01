<?php
// Start session
session_start();

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Output buffering
ob_start();

// Connect to the database
$mysqli = new mysqli("localhost", "root", "Messi@123", "scamguard");

if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    ob_end_flush();
    exit();
}

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $post_id = $_POST['post_id'];
        $comment_text = $_POST['content'];

        // Insert comment into database
        $stmt = $mysqli->prepare("INSERT INTO comments (post_id, user_id, comment_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $post_id, $user_id, $comment_text);

        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = $stmt->error;
        }

        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = 'User not logged in.';
    }
} else {
    $response['success'] = false;
    $response['error'] = 'Invalid request method.';
}

header('Content-Type: application/json');
echo json_encode($response);
ob_end_flush();
?>
