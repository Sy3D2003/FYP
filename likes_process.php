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

$response = [];

// Start output buffering
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $post_id = $_POST['post_id'];

        // Log received data for debugging
        error_log("Received POST data: user_id = $user_id, post_id = $post_id");

        // Check if the user has already liked the post
        $check_like_query = $mysqli->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
        $check_like_query->bind_param("ii", $user_id, $post_id);
        $check_like_query->execute();
        $result = $check_like_query->get_result();

        if ($result->num_rows > 0) {
            // If already liked, unlike the post
            $delete_like_query = $mysqli->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
            $delete_like_query->bind_param("ii", $user_id, $post_id);
            if ($delete_like_query->execute()) {
                $response['success'] = true;
                $response['action'] = 'unliked';
            } else {
                $response['success'] = false;
                $response['error'] = 'Error unliking post';
            }
            $delete_like_query->close();
        } else {
            // If not liked, like the post
            $insert_like_query = $mysqli->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
            $insert_like_query->bind_param("ii", $user_id, $post_id);
            if ($insert_like_query->execute()) {
                $response['success'] = true;
                $response['action'] = 'liked';
            } else {
                $response['success'] = false;
                $response['error'] = 'Error liking post';
            }
            $insert_like_query->close();
        }
        $check_like_query->close();
    } else {
        $response['success'] = false;
        $response['error'] = 'User not logged in.';
    }
} else {
    $response['success'] = false;
    $response['error'] = 'Invalid request method.';
}

// Clean the output buffer and end buffering
ob_end_clean();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
