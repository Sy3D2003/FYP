<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScamGuard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">
            <img src="img/logo.png" alt="ScamGuard Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="scamsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Scams
                    </a>
                    <div class="dropdown-menu" aria-labelledby="scamsDropdown">
                        <a class="dropdown-item" href="scamCallAnalyzer.php">Scam Call Analyzer</a>
                        <a class="dropdown-item" href="emailPhishingChecker.php">Email Phisher Checker</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="resourcesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Educational Resources
                    </a>
                    <div class="dropdown-menu" aria-labelledby="resourcesDropdown">
                        <a class="dropdown-item" href="scamTypes.php">Scam Types</a>
                        <a class="dropdown-item" href="quizzes.php">Quizzes</a>
                    </div>
                </li>
                <?php if(isset($_SESSION['username'])): ?>
                <li class="nav-item">
                    <span class="nav-link">Welcome, <?php echo $_SESSION['username']; ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">
                        <i class="fas fa-user"></i> Log In
                    </a>
                </li>
                <li class="nav-item">
                    <span class="nav-link separator">|</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>

<main class="container mt-5">
    <section class="text-center animate__animated animate__fadeInUp">
        <h1>Welcome to ScamGuard</h1>
        <p>Your trusted partner in detecting and avoiding scams.</p>
    </section>
    <section class="mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-center mb-4 ray-background">
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
            <div class="col-md-3">
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Educational Resources</h5>
                        <p class="card-text">Access resources to educate yourself on different types of scams and prevention techniques.</p>
                        <a href="scamTypes.php" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Quizzes</h5>
                        <p class="card-text">Test your knowledge with our engaging quizzes on scam awareness and prevention.</p>
                        <a href="quizzes.php" class="btn btn-primary">Take a Quiz</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Latest News</h5>
                        <p class="card-text">Stay updated with the latest news and updates on scam activities and prevention tips.</p>
                        <a href="news.php" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Community Stories</h5>
                        <p class="card-text">Read real-life stories shared by our community members about their experiences with scams.</p>
                        <a href="forum.php" class="btn btn-primary">Read Stories</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="footer mt-5">
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h4>About Us</h4>
                <p>Learn more about our mission and the team behind ScamGuard.</p>
            </div>
            <div class="footer-column">
                <h4>Contact Us</h4>
                <p>Get in touch with us for any queries or support.</p>
            </div>
            <div class="footer-column">
                <h4>Follow Us</h4>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

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
