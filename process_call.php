<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);

    $expectedParams = ['callDuration', 'commonWords', 'callType', 'personalInfoRequest', 'emotionTactics'];
    $missingParams = [];

    foreach ($expectedParams as $param) {
        if (!isset($data[$param])) {
            $missingParams[] = $param;
        }
    }

    if (!empty($missingParams)) {
        echo json_encode(['result' => 'Missing parameters: ' . implode(', ', $missingParams)]);
        exit;
    }

    // Sanitize input
    $callDuration = escapeshellarg($data['callDuration']);
    $commonWords = escapeshellarg($data['commonWords']);
    $callType = escapeshellarg($data['callType']);
    $personalInfoRequest = escapeshellarg($data['personalInfoRequest']);
    $emotionTactics = escapeshellarg($data['emotionTactics']);

    // Construct the command using the correct Python path
    $pythonPath = 'C:\Users\brouf\AppData\Local\Programs\Python\Python312\python.exe';
    $command = "\"$pythonPath\" predict_model.py $callDuration $commonWords $callType $personalInfoRequest $emotionTactics 2>&1";

    // Log the command and parameters
    file_put_contents('debug.log', "Command: $command\n", FILE_APPEND);
    file_put_contents('debug.log', "Parameters: " . json_encode($data) . "\n", FILE_APPEND);

    // Execute the command
    $output = shell_exec($command);

    // Log the output
    file_put_contents('debug.log', "Output: $output\n", FILE_APPEND);

    // Check for execution errors
    if ($output === null) {
        echo json_encode(['result' => 'Error executing the Python script.']);
    } else {
        echo json_encode(['result' => trim($output)]);
    }
} else {
    echo json_encode(['result' => 'Invalid request method']);
}
?>
