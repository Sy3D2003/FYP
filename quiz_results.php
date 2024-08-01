<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Connect to the database
$mysqli = new mysqli("localhost", "root", "Messi@123", "scamguard");

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
$difficulty = $_GET['difficulty'] ?? 'easy'; // Get the difficulty from the query string or default to 'easy'

// Fetch the star results from the database
$query = "SELECT q.quiz_id, q.difficulty, qr.stars 
          FROM quiz_results qr 
          JOIN quizzes q ON qr.quiz_id = q.quiz_id 
          WHERE qr.user_id = ? AND q.difficulty = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("is", $user_id, $difficulty);
$stmt->execute();
$result = $stmt->get_result();

$star_results = [];
while ($row = $result->fetch_assoc()) {
    $star_results[$row['quiz_id']] = $row['stars'];
}

// Close connection
$mysqli->close();

$stars_earned = array_sum($star_results);
$total_stars_per_quiz = 24; // 3 stars per question for 8 questions

// Calculate overall progress based on the difficulty completed
if ($difficulty == 'hard' && $stars_earned == $total_stars_per_quiz) {
    $overall_progress = 100;
    $progress_message = "Amazing! You have successfully completed all the hard quizzes! You are now well-equipped with comprehensive knowledge about various scams and how to protect yourself.";
} elseif ($difficulty == 'medium' && $stars_earned == $total_stars_per_quiz) {
    $overall_progress = 66.66;
    $progress_message = "Great job! You have successfully completed the medium quiz. Keep going to master your knowledge with the hard quiz.";
} elseif ($difficulty == 'easy' && $stars_earned == $total_stars_per_quiz) {
    $overall_progress = 33.33;
    $progress_message = "Well done! You have successfully completed the easy quiz. Continue to challenge yourself with the medium quiz.";
} else {
    $overall_progress = ($stars_earned / $total_stars_per_quiz) * 100;
    $progress_message = "Keep going! Complete the quizzes to gain full knowledge about various scams.";
}

// Adjust message for partial completion
if ($stars_earned < $total_stars_per_quiz && $stars_earned > 0) {
    $progress_message = "You didn't earn enough stars to complete the {$difficulty} quiz. Better luck next time!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results - ScamGuard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .star-rating {
            color: gold;
        }
        .star-rating .fa-star {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h3>Quiz Results</h3>
        <p>You have earned a total of <?php echo htmlspecialchars($stars_earned); ?> stars in the <?php echo htmlspecialchars($difficulty); ?> quiz!</p>
        <ul>
            <?php foreach ($star_results as $quiz_id => $stars): ?>
                <li>Question ID <?php echo htmlspecialchars($quiz_id); ?>:
                    <span class="star-rating">
                        <?php for ($i = 0; $i < $stars; $i++): ?>
                            <i class="fas fa-star"></i>
                        <?php endfor; ?>
                        <?php for ($i = $stars; $i < 3; $i++): ?>
                            <i class="far fa-star"></i>
                        <?php endfor; ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="quizzes.php" class="btn btn-primary">Take Another Quiz</a>

        <div class="progress mt-4">
            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $overall_progress; ?>%;" aria-valuenow="<?php echo $overall_progress; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo round($overall_progress, 2); ?>%</div>
        </div>
        <p class="mt-2 alert alert-success"><?php echo $progress_message; ?></p>
        
        <section class="mt-4">
            <h3>Check Out More of Our Content Below</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Latest News</h5>
                            <p class="card-text">Stay updated with the latest news and updates on scam activities and prevention tips.</p>
                            <a href="news.php" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Community Stories</h5>
                            <p class="card-text">Read real-life stories shared by our community members about their experiences with scams.</p>
                            <a href="forum.php" class="btn btn-primary">Read Stories</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Tools</h5>
                            <div class="mb-4">
                                <h6>Scam Call Analyzer</h6>
                                <p>Analyze and report scam calls efficiently.</p>
                                <a href="scamCallAnalyzer.php" class="btn btn-primary">Analyze Call</a>
                            </div>
                            <div>
                                <h6>Email Phisher Checker</h6>
                                <p>Check emails for phishing attempts.</p>
                                <a href="emailPhishingChecker.php" class="btn btn-primary">Check Email</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
