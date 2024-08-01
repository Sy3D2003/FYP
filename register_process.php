<?php
// Start session
session_start();

// Connect to the database
$mysqli = new mysqli("localhost", "root", "Messi@123", "scamguard");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Check if passwords match
if ($password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: register.php");
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email format.";
    header("Location: register.php");
    exit();
}

// Validate password strength
$password_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
if (!preg_match($password_regex, $password)) {
    $_SESSION['error'] = "Password must be at least 8 characters long, contain uppercase and lowercase letters, a number, and a special character.";
    header("Location: register.php");
    exit();
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Prepare and bind
$stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
if ($stmt === false) {
    $_SESSION['error'] = "Error preparing statement: " . $mysqli->error;
    header("Location: register.php");
    exit();
}

$stmt->bind_param("sss", $username, $email, $hashed_password);

// Execute the statement
if ($stmt->execute()) {
    $_SESSION['success'] = "Registration successful!";
    header("Location: login.php");
} else {
    $_SESSION['error'] = "Error executing statement: " . $stmt->error;
    header("Location: register.php");
}

// Close the statement and connection
$stmt->close();
$mysqli->close();
?>
