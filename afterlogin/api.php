<?php
session_start();

// API endpoint and key
$apiUrl = "https://api.groq.com/openai/v1/chat/completions";
$apiKey = "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";

// Get user input from AJAX request
$requestBody = file_get_contents('php://input');
$requestData = json_decode($requestBody, true);

// Check if JSON was received correctly
if (!$requestData) {
    echo json_encode(['error' => 'Invalid JSON format in the request body']);
    exit;
}

$prompt = $requestData['prompt'] ?? '';
$model = $requestData['model'] ?? 'llama3-8b-8192';

// Prepare data for API
$data = [
    "messages" => [
        ["role" => "user", "content" => $prompt]
    ],
    "model" => $model
];

// Headers for the API request
$headers = [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
];

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute cURL request and handle response
$response = curl_exec($ch);

if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode(['error' => curl_error($ch)]);
} else {
    // Parse API response
    $responseData = json_decode($response, true);

    // Store result in session and redirect
    $_SESSION['ai_response'] = $responseData;
    echo json_encode($responseData);
}

curl_close($ch);
?>
