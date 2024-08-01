<?php
// Start session
session_start();

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Output buffering
ob_start();

// Debugging: Check for unexpected output
echo ''; // Ensure no output is sent before header
header('Content-Type: application/json');

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
        $title = $_POST['title'];
        $content = $_POST['content'];
        $rating = $_POST['rating'];
        $image_path = '';

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_name = basename($_FILES['image']['name']);
            $image_path = 'uploads/' . $image_name;

            // Ensure the uploads directory exists and is writable
            if (!file_exists('uploads')) {
                mkdir('uploads', 0777, true);
            }

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                $response['success'] = false;
                $response['error'] = 'Failed to move uploaded file';
                echo json_encode($response);
                ob_end_flush();
                exit();
            }
        } else if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $response['success'] = false;
            $response['error'] = 'File upload error: ' . $_FILES['image']['error'];
            echo json_encode($response);
            ob_end_flush();
            exit();
        }

        // Insert post into database
        $stmt = $mysqli->prepare("INSERT INTO posts (user_id, title, content, image_path, rating) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("isssi", $user_id, $title, $content, $image_path, $rating);

            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
                $response['error'] = 'Execute error: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            $response['success'] = false;
            $response['error'] = 'Prepare error: ' . $mysqli->error;
        }
    } else {
        $response['success'] = false;
        $response['error'] = 'User not logged in.';
    }
} else {
    $response['success'] = false;
    $response['error'] = 'Invalid request method.';
}

echo json_encode($response);
ob_end_flush();
?>