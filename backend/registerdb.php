<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb"; 

$message = "Register successful";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if POST request has all required fields
if (isset($_POST['email'], $_POST['name'],  $_POST['password'])) {

    // Sanitize user inputs to prevent XSS and SQL injection
    $email = $conn->real_escape_string($_POST['email']);
    $name = $conn->real_escape_string($_POST['name']);
    $password = $_POST['password'];

    

    // Prepare SQL query using prepared statements
    $sql = $conn->prepare("INSERT INTO register (email, name, password) VALUES (?, ?, ?)");
    
    // Corrected bind_param to use "sss" (all strings)
    $sql->bind_param("sss", $email, $name, $password);

    // Execute the query and check for success
    if ($sql->execute()) {
        echo "<script type='text/javascript'>alert('$message');window.location.href='../login.php';</script>";
    } else {
        echo "Error: " . $sql->error;
    }

    // Close statement and connection
    $sql->close();
} else {
    echo "Error: Missing required fields.";
}

$conn->close();
?>
