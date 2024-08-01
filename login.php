<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ScamGuard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Login</h3>
                        <div class="or-separator">
                            <span class="or-text">Login with your details</span>
                        </div>
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
                        <form action="login_process.php" method="post">
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email or Username</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                <a href="forgot_password.php" class="float-right">Forgot password?</a>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
                        </form>
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
</body>
</html>
