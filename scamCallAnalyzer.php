<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scam Call Analyzer - ScamGuard</title>
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
            background-color: #333; /* Background color to match the theme */
            color: #fff;
        }
        .form-section {
            width: 60%;
            padding: 20px;
            background-color: #333; /* Background color to match the theme */
            color: #fff;
        }
        .form-control {
            background-color: #444;
            border-color: #444;
            color: #fff;
        }
        .form-control:focus {
            background-color: #555;
            color: #fff;
        }
        .btn-primary {
            background-color: #008080;
            border-color: #008080;
        }
        .btn-primary:hover {
            background-color: #006666;
            border-color: #006666;
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
        .instructions img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border: 2px solid #00b3b3; /* Teal border for images */
        }

        /* Teal Color Scheme Enhancements */
        .instructions h3, .instructions h4, .form-section h3 {
            color: #00b3b3; /* Teal color for headings */
        }

        .instructions ul li {
            color: #d4d4d4; /* Slightly lighter color for list items */
        }

        .form-group label {
            color: #00b3b3; /* Teal color for form labels */
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container-fluid">
        <div class="instructions">
            <h3>Steps to Use Scam Call Analyzer</h3>
            <ul>
                <li>Enter the call duration in minutes.</li>
                <li>Enter any common words or phrases used during the call.</li>
                <li>If available, enter the caller ID.</li>
                <li>Select the type of call.</li>
                <li>Answer whether the caller asked for personal information.</li>
                <li>Answer whether the caller used emotional pressure or threats.</li>
                <li>Click on the analyze button and wait for the popup window to see the result.</li>
            </ul>
            <h4>Example of Input Fields</h4>
            <img src="img/tutorial.jpg" alt="Example of input fields">
        </div>
        <div class="form-section">
            <h3>Scam Call Analyzer</h3>
            <form id="scamCallForm">
                <div class="form-group">
                    <label for="callDuration">Call Duration (in minutes)</label>
                    <input type="number" class="form-control" id="callDuration" name="callDuration" required>
                </div>
                <div class="form-group">
                    <label for="commonWords">Conversational Content (Common Words/Phrases Used)</label>
                    <input type="text" class="form-control" id="commonWords" name="commonWords" required>
                </div>
                <div class="form-group">
                    <label for="callerID">Caller ID (if available)</label>
                    <input type="text" class="form-control" id="callerID" name="callerID">
                </div>
                <div class="form-group">
                    <label for="callType">Type of Call</label>
                    <select class="form-control" id="callType" name="callType">
                        <option value="live">Live</option>
                        <option value="automated">Automated</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="personalInfoRequest">Did the caller ask for personal information?</label>
                    <select class="form-control" id="personalInfoRequest" name="personalInfoRequest">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="emotionTactics">Did the caller use emotional pressure or threats?</label>
                    <select class="form-control" id="emotionTactics" name="emotionTactics">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Analyze Call</button>
            </form>

            <div id="analysisResult" class="mt-4" style="display:none;">
                <h3>Analysis Result</h3>
                <p id="resultText"></p>
            </div>
        </div>
    </div>
    <div class="overlay" id="overlay"></div>
    <div class="popup-window" id="popup">
        <div class="popup-message">
            <img id="popupImage" src="" alt="Sign" width="30">
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
