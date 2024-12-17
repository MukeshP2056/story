<?php
session_start();
// Database connection details
$host = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "storydb";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if story_id is passed and user is logged in
if (isset($_POST['story_id']) && isset($_SESSION['user_id'])) {
    $story_id = $_POST['story_id'];
    $user_id = $_SESSION['user_id']; // Get logged-in user ID from session

    // Use a prepared statement to insert into favorites table
    $sql = "INSERT INTO favorites (user_id, story_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $story_id); // 'ii' means two integer values

    if ($stmt->execute()) {
        echo "Story added to favorites!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Error: Missing story ID or user not logged in.";
}

// Close the database connection
$conn->close();
?>
