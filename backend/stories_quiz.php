<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $story_id = $_POST['story_id'];
    $question = $_POST['question'];
    $correct_answer = $_POST['correct_answer'];
    $options = json_encode($_POST['options']); // Store options as a JSON array

    $sql = "INSERT INTO story_quizzes (story_id, question, correct_answer, options) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $story_id, $question, $correct_answer, $options);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Quiz added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add quiz"]);
    }

    $stmt->close();
}

$conn->close();
?>
