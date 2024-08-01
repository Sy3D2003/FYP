<?php
session_start();

// Connect to the database
$mysqli = new mysqli("localhost", "root", "Messi@123", "scamguard");

if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
$answers = $_POST['answer'] ?? [];
$difficulty = $_POST['difficulty'] ?? 'easy'; // Get the difficulty from the POST data
$total_stars = 0;
$star_results = [];

// Debugging code to log errors
function log_error($message) {
    error_log($message, 3, 'error_log.txt');
}

foreach ($answers as $index => $user_answer) {
    // Fetch the correct answer, number of attempts, and difficulty from the database
    $query = "SELECT quiz_id, correct_option, difficulty FROM quizzes WHERE quiz_id = ?";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        log_error("Prepare failed: " . $mysqli->error);
        echo json_encode(['success' => false, 'error' => 'Query preparation failed']);
        exit();
    }
    $stmt->bind_param("i", $index);
    $stmt->execute();
    $result = $stmt->get_result();
    $quiz_data = $result->fetch_assoc();

    if ($quiz_data && $quiz_data['difficulty'] === $difficulty) {
        $quiz_id = $quiz_data['quiz_id'];
        $correct_option = $quiz_data['correct_option'];

        // Check if the user has already attempted this question
        $query = "SELECT attempts FROM quiz_results WHERE user_id = ? AND quiz_id = ?";
        $stmt = $mysqli->prepare($query);
        if (!$stmt) {
            log_error("Prepare failed: " . $mysqli->error);
            echo json_encode(['success' => false, 'error' => 'Query preparation failed']);
            exit();
        }
        $stmt->bind_param("ii", $user_id, $quiz_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $result_data = $result->fetch_assoc();

        $attempts = $result_data['attempts'] ?? 0; // Default to 0 if no attempts found

        if ($user_answer == $correct_option) {
            // Calculate stars based on attempts
            $stars = max(0, 3 - $attempts); // 3 stars if first attempt, 2 if second, 1 if third
            $total_stars += $stars;
            $star_results[$quiz_id] = $stars;

            // Insert/update the quiz results
            if ($result_data) {
                $query = "UPDATE quiz_results SET attempts = attempts + 1, stars = ? WHERE user_id = ? AND quiz_id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("iii", $stars, $user_id, $quiz_id);
            } else {
                $query = "INSERT INTO quiz_results (user_id, quiz_id, attempts, stars) VALUES (?, ?, 1, ?)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("iii", $user_id, $quiz_id, $stars);
            }
        } else {
            // Update the attempts if the answer was incorrect
            if ($result_data) {
                $query = "UPDATE quiz_results SET attempts = attempts + 1 WHERE user_id = ? AND quiz_id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ii", $user_id, $quiz_id);
            } else {
                $query = "INSERT INTO quiz_results (user_id, quiz_id, attempts) VALUES (?, ?, 1)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ii", $user_id, $quiz_id);
            }
        }

        if (!$stmt->execute()) {
            log_error("Execute failed: " . $stmt->error);
            echo json_encode(['success' => false, 'error' => 'Query execution failed']);
            exit();
        }
    } else {
        log_error("Quiz ID $index does not exist in quizzes table or does not match the difficulty.");
        echo json_encode(['success' => false, 'error' => 'Invalid quiz ID or difficulty']);
        exit();
    }
}

// Store total stars in session to display on the results page
$_SESSION['total_stars'] = $total_stars;
$_SESSION['star_results'] = $star_results;
$_SESSION['difficulty'] = $difficulty; // Store the difficulty in session

// Close connection
$mysqli->close();

echo json_encode(['success' => true]);
?>
