<?php
require __DIR__ . '../../vendor/autoload.php'; // Correct path to autoload.php
use Dompdf\Dompdf;

// Start the session
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the story ID from the POST request
$storyId = isset($_POST['author_id']) ? (int)$_POST['author_id'] : 0;

// Fetch story details from the database
$sql = "SELECT author_name, story_title, story_des, story_content 
        FROM author_add 
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $storyId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the story exists
if ($result->num_rows > 0) {
    $story = $result->fetch_assoc();
} else {
    die("Story not found.");
}

// Close the database connection
$stmt->close();
$conn->close();

// Generate PDF
$dompdf = new Dompdf();
$html = '
    <h1>' . htmlspecialchars($story['author_name']) . '</h1>
    <h4>Story Title: ' . htmlspecialchars($story['story_title']) . '</h4>
    <p><strong>Description:</strong> ' . nl2br(htmlspecialchars($story['story_des'])) . '</p>
    <p><strong>Story Content:</strong><br>' . nl2br(htmlspecialchars($story['story_content'])) . '</p>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($story['author_name'] . ".pdf", ["Attachment" => true]);
?> 
