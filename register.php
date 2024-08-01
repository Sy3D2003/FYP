<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ScamGuard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
<?php include('header.php'); ?>
    <header>
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="ScamGuard Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
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
                </ul>
            </div>
        </nav>
    </header>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Register</h3>
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                            unset($_SESSION['success']);
                        }
                        ?>
                        <form id="registerForm" action="register_process.php" method="post" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="username"><i class="fas fa-user"></i> Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div id="passwordFeedback" class="invalid-feedback">
                                    Password must be at least 8 characters long, contain uppercase and lowercase letters, a number, and a special character.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password"><i class="fas fa-lock"></i> Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <div id="confirmPasswordFeedback" class="invalid-feedback">
                                    Passwords do not match.
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">Register</button>
                        </form>
                        <p class="text-center mt-3">Already have an account? <a href="login.php">Click here to log in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                
                        <li><a href="scamCallAnalyzer.php">Scam Call Analyzer</a></li>
                        <li><a href="emailPhishingChecker.php">Email Phishing Checker</a></li>
                    </ul>
                </div>
            </div>
            <p class="text-center mt-4">© 2022 Inti International University - All Rights Reserved</p>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

            if (!passwordRegex.test(password)) {
                document.getElementById('password').classList.add('is-invalid');
                return false;
            } else {
                document.getElementById('password').classList.remove('is-invalid');
            }

            if (password !== confirmPassword) {
                document.getElementById('confirm_password').classList.add('is-invalid');
                return false;
            } else {
                document.getElementById('confirm_password').classList.remove('is-invalid');
            }

            return true;
        }
    </script>
</body>
</html>
