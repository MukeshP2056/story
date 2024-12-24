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
$storyId = isset($_POST['story_id']) ? (int)$_POST['story_id'] : 0;

// Fetch story details from the database
$sql = "SELECT Story_Title, Author_Name, genres_name, Story_Content 
        FROM stories_add 
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
    <h1>' . htmlspecialchars($story['Story_Title']) . '</h1>
    <h4>By: ' . htmlspecialchars($story['Author_Name']) . '</h4>
    <h4>Genre: ' . htmlspecialchars($story['genres_name']) . '</h4>
    <p>' . nl2br(htmlspecialchars($story['Story_Content'])) . '</p>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($story['Story_Title'] . ".pdf", ["Attachment" => true]);
?>
