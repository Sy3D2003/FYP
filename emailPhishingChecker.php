<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Phishing Checker - ScamGuard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .container-fluid {
            display: flex;
            height: 100vh;
        }
        .instructions {
            width: 40%;
            padding: 20px;
            border-right: 2px solid #ccc;
            overflow-y: auto;
        }
        .form-section {
            width: 60%;
            padding: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-check-inline {
            margin-right: 10px;
        }
        .instructions img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .popup-window {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            z-index: 1000;
            width: 300px;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .popup-message {
            display: flex;
            align-items: center;
        }
        .popup-message img {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container-fluid">
        <div class="instructions">
            <h3>How to Use Email Phishing Checker</h3>
            <p>The Email Phishing Checker helps you determine whether an email you received might be a phishing attempt. Follow these steps:</p>
            <ul>
                <li>Copy the text of the email you find suspicious.</li>
                <li>Paste the copied text into the input field on the right.</li>
                <li>Click on "Check Email" to analyze the email.</li>
                <li>Wait for the result to see if the email is likely a phishing attempt.</li>
            </ul>
            <h4>Example of Phishing Email</h4>
            <img src="img/email.jpg" alt="Example of a scam email">
        </div>
        <div class="form-section">
            <h3>Email Phishing Checker</h3>
            <form id="phishingForm">
                <div class="form-group">
                    <label for="emailText">Enter Email Text</label>
                    <textarea class="form-control" id="emailText" name="emailText" rows="10" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Check Email</button>
            </form>

            <div id="phishingResult" class="mt-4" style="display:none;">
                <h3>Analysis Result</h3>
                <p id="phishingResultText"></p>
            </div>
        </div>
    </div>
    <div class="overlay" id="overlay"></div>
    <div class="popup-window" id="popup">
        <div class="popup-message">
            <img id="popupImage" src="img/danger.jpg" alt="Danger Sign" width="30">
            <p id="popupMessage" style="color:black;"></p>
        </div>
        <button class="btn btn-secondary" onclick="closePopup()">Close</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="main.js"></script>
</body>
</html>
