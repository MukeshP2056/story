<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch genres from the database
$sql = "SELECT DISTINCT genres_name FROM genres"; // Adjust 'genres_name' and 'genres' based on actual column/table names
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data for each genre
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['genres_name']) . '">' . htmlspecialchars($row['genres_name']) . '</option>';
    }
} else {
    echo '<option value="">No genres available</option>';
}

// Close the database connection
$conn->close();
?>
