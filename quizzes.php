<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScamGuard - Quizzes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .content-container {
            flex: 1 0 auto;
        }
        .footer {
            flex-shrink: 0;
        }
        .main-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .quiz-container {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .quiz-hidden {
            transform: translateX(-100%);
        }
        #quiz-section {
            display: none;
        }
        .tabs {
            display: none;
            flex-direction: column;
            width: 200px;
        }
        .tab-link {
            background-color: #444;
            color: #fff;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }
        .tab-link:hover {
            background-color: #666;
        }
        .tab-link.active {
            background-color: #007bff;
            color: white;
        }
        .quiz-content {
            flex-grow: 1;
        }
        .quiz-area {
            display: flex;
        }
        .quiz-page {
            display: none;
        }
        .timer {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        button {
            margin: 10px;
        }
        .locked {
            position: relative;
        }
        .locked::after {
            content: "\f023"; /* FontAwesome lock icon */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: red;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <?php include('header.php'); ?>
        <?php
        // Start session and fetch user progress
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $mysqli = new mysqli("localhost", "root", "Messi@123", "scamguard");
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $user_id = $_SESSION['user_id'] ?? null;
        $easy_completed = $medium_completed = false;
        $star_results = [
            'easy' => 0,
            'medium' => 0,
            'hard' => 0,
        ];

        if ($user_id) {
            $result = $mysqli->query("SELECT quiz_id, stars FROM quiz_results WHERE user_id = $user_id");
            while ($row = $result->fetch_assoc()) {
                if ($row['quiz_id'] >= 1 && $row['quiz_id'] <= 8) {
                    $star_results['easy'] += $row['stars'];
                    if ($star_results['easy'] >= 24) {
                        $easy_completed = true;
                    }
                } elseif ($row['quiz_id'] >= 9 && $row['quiz_id'] <= 16) {
                    $star_results['medium'] += $row['stars'];
                    if ($star_results['medium'] >= 24) {
                        $medium_completed = true;
                    }
                } elseif ($row['quiz_id'] >= 17 && $row['quiz_id'] <= 24) {
                    $star_results['hard'] += $row['stars'];
                }
            }
        }
        ?>

        <main class="container mt-5 content-container">
            <section class="content-container">
                <h1>Scam Awareness Quizzes</h1>
                <p>Welcome to the ScamGuard Quizzes section! Here, you can test your knowledge and awareness about various types of scams. Our quizzes are designed to help you recognize and avoid potential scams. Select the difficulty level below to get started!</p>
                <div class="row quiz-container">
                    <div class="col-md-4">
                        <div class="card quiz-button" data-difficulty="easy" id="easy-quiz-button">
                            <div class="card-body">
                                <h5 class="card-title">Quiz 1: Easy</h5>
                                <p class="card-text">Test your knowledge with this easy quiz.</p>
                                <p>Stars earned: <?php echo $star_results['easy']; ?>/24</p>
                                <button class="btn btn-primary">Start Quiz</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card quiz-button <?= !$easy_completed ? 'locked' : '' ?>" data-difficulty="medium" id="medium-quiz-button">
                            <div class="card-body">
                                <h5 class="card-title">Quiz 2: Medium</h5>
                                <p class="card-text">See how well you can identify scams with this medium quiz.</p>
                                <p>Stars earned: <?php echo $star_results['medium']; ?>/24</p>
                                <button class="btn btn-primary" <?= !$easy_completed ? 'disabled' : '' ?>>Start Quiz</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card quiz-button <?= !$medium_completed ? 'locked' : '' ?>" data-difficulty="hard" id="hard-quiz-button">
                            <div class="card-body">
                                <h5 class="card-title">Quiz 3: Hard</h5>
                                <p class="card-text">Challenge your awareness with this hard quiz.</p>
                                <p>Stars earned: <?php echo $star_results['hard']; ?>/24</p>
                                <button class="btn btn-primary" <?= !$medium_completed ? 'disabled' : '' ?>>Start Quiz</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="quiz-section">
                    <div class="quiz-area">
                        <div class="tabs">
                            <button class="tab-link" data-difficulty="easy">Quiz 1: Easy</button>
                            <button class="tab-link <?= !$easy_completed ? 'locked' : '' ?>" data-difficulty="medium" <?= !$easy_completed ? 'disabled' : '' ?>>Quiz 2: Medium</button>
                            <button class="tab-link <?= !$medium_completed ? 'locked' : '' ?>" data-difficulty="hard" <?= !$medium_completed ? 'disabled' : '' ?>>Quiz 3: Hard</button>
                        </div>
                        <div class="quiz-content">
                            <form id="quizForm">
                                <div id="page-1" class="quiz-page">
                                    <div class="timer" id="timer">00:00</div>
                                    <div id="quizQuestions1"></div>
                                    <button type="button" id="next-1" class="btn btn-primary">Next</button>
                                </div>
                                <div id="page-2" class="quiz-page">
                                    <div class="timer" id="timer">00:00</div>
                                    <div id="quizQuestions2"></div>
                                    <button type="button" id="prev-2" class="btn btn-secondary">Previous</button>
                                    <button type="button" id="next-2" class="btn btn-primary">Next</button>
                                </div>
                                <div id="page-3" class="quiz-page">
                                    <div class="timer" id="timer">00:00</div>
                                    <div id="quizQuestions3"></div>
                                    <button type="button" id="prev-3" class="btn btn-secondary">Previous</button>
                                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="correctAnswersSection" style="display: none;">
                    <h3>Correct Answers</h3>
                    <div id="correctAnswers"></div>
                </div>
            </section>
        </main>

        <footer class="footer mt-auto">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-column">
                        <h4>SCAMGUARD</h4>
                        <p>
                            <i class="fas fa-map-marker-alt"></i> Nilai, Malaysia<br>
                            <i class="fas fa-envelope"></i> scamguard2323@example.com
                        </p>
                        <p>Follow our social media</p>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                    <div class="footer-column quick-links">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="register.php">Register</a></li>
                            <li><a href="contact.php">Contact Us</a></li>
                            <li><a href="scamCallAnalyzer.php">Scam Call Analyzer</a></li>
                            <li><a href="emailPhishingChecker.php">Email Phishing Checker</a></li>
                        </ul>
                    </div>
                </div>
                <p class="text-center mt-4">© 2022 Inti International University - All Rights Reserved</p>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="main.js"></script>
</body>

</html>
