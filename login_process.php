<?php
// Start session
session_start();

// Connect to the database
$mysqli = new mysqli("localhost", "root", "Messi@123", "scamguard");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the form data
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and bind
$stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['success'] = "Login successful!";
        header("Location: index.php");
    } else {
        $_SESSION['error'] = "Invalid password.";
        header("Location: login.php");
    }
} else {
    $_SESSION['error'] = "No user found with that email address.";
    header("Location: login.php");
}

// Close the statement and connection
$stmt->close();
$mysqli->close();
?>
