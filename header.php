<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
        <a class="navbar-brand" href="index.php">
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
                        <a class="dropdown-item" href="emailPhishingChecker.php">Email Phishing Checker</a>
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
                        <a class="nav-link" href="profile.php"><i class="fas fa-user"></i> Welcome, <?php echo $_SESSION['username']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="fas fa-user"></i> Log In</a>
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
</body>
</html>
