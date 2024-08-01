<?php
session_start();
$mysqli = new mysqli("localhost", "root", "Messi@123", "scamguard");

if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

$query = "SELECT SUM(stars) as total_stars FROM quiz_results WHERE user_id = ?";
$stmt = $mysqli->prepare($query);

if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Query preparation failed']);
    exit();
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $data = $result->fetch_assoc();
    $total_stars = $data['total_stars'] ?? 0; // Default to 0 if no stars found
    echo json_encode(['total_stars' => $total_stars]);
} else {
    echo json_encode(['total_stars' => 0]); // Default response if query fails
}

$stmt->close();
$mysqli->close();
?>
