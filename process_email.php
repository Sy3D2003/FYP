<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');

    try {
        // Get the raw POST data
        $postData = file_get_contents("php://input");
        file_put_contents('debug.log', "Raw POST data: $postData\n", FILE_APPEND);
        $data = json_decode($postData, true);

        if (!isset($data['emailText']) || empty($data['emailText'])) {
            throw new Exception('Email text not provided.');
        }

        // Get the email text from the POST request and encode it
        $emailText = escapeshellarg(base64_encode($data['emailText']));

        // Specify the path to the Python executable
        $pythonPath = 'C:\\Users\\brouf\\AppData\\Local\\Programs\\Python\\Python312\\python.exe';

        // Path to the predict.py script
        $scriptPath = 'D:\\xamp\\htdocs\\Final Year Project\\predict.py';

        // Ensure the script path is properly escaped
        $scriptPath = escapeshellarg($scriptPath);

        // Execute the Python script with the encoded email text as an argument
        $command = "$pythonPath $scriptPath $emailText 2>&1";
        $output = shell_exec($command);

        // Logging for debugging
        file_put_contents('debug.log', "Command: $command\nOutput: $output\n", FILE_APPEND);

        // Check if output is empty
        if ($output === null || trim($output) === '') {
            throw new Exception('No output from the Python script.');
        } else {
            // Decode the output
            $decodedOutput = base64_decode($output);
            if ($decodedOutput === false) {
                throw new Exception('Failed to decode the output.');
            } else {
                // Ensure the decoded output is UTF-8 encoded
                $decodedOutput = mb_convert_encoding($decodedOutput, 'UTF-8', 'UTF-8');
                $response = ['result' => trim($decodedOutput)];
            }
        }
    } catch (Exception $e) {
        $response = ['error' => $e->getMessage()];
    }

    // Return the result as JSON
    $jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $jsonResponse = json_encode(['error' => 'JSON encoding error: ' . json_last_error_msg()]);
    }
    file_put_contents('debug.log', "JSON Response: $jsonResponse\n", FILE_APPEND);
    echo $jsonResponse;

    // Ensure no further output
    exit;
}
?>
