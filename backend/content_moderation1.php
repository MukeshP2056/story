<?php
// Database configuration
$servername = "localhost"; // Use your server name
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "storydb"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    // Insert data into the table
    $sql = "INSERT INTO content_moderation (email, phone, address) VALUES ('$email', '$phone', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "New content added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
