<?php
// Connect to the database
$mysqli = new mysqli("localhost", "root", "Messi@123", "scamguard");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$difficulty = $_GET['difficulty'] ?? '';

// Validate the difficulty parameter
if (!in_array($difficulty, ['easy', 'medium', 'hard'])) {
    echo json_encode([]);
    exit();
}

// Fetch questions based on difficulty
$query = "SELECT quiz_id, question, option_a, option_b, option_c, option_d FROM quizzes WHERE difficulty = ?";
$stmt = $mysqli->prepare($query);
if (!$stmt) {
    echo json_encode([]);
    exit();
}
$stmt->bind_param("s", $difficulty);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

$stmt->close();
$mysqli->close();

echo json_encode($questions);
?>
