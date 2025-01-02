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
if (isset($_POST['email'], $_POST['name'], $_POST['password'])) {

    // Sanitize user inputs to prevent XSS and SQL injection
    $email = $conn->real_escape_string($_POST['email']);
    $name = $conn->real_escape_string($_POST['name']);
    $password = $_POST['password'];

    // Validate email format (ensure it's a valid Gmail address)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
        echo "<script type='text/javascript'>alert('Error: Please enter a valid Gmail address.');window.history.back();</script>";
        exit;
    }

    // Validate name (only alphabetic characters and spaces allowed)
    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        echo "<script type='text/javascript'>alert('Error: Name should only contain alphabetic characters and spaces.');window.history.back();</script>";
        exit;
    }

    // Prepare SQL query using prepared statements
    $sql = $conn->prepare("INSERT INTO register (email, name, password) VALUES (?, ?, ?)");
    
    // Bind parameters to prevent SQL injection
    $sql->bind_param("sss", $email, $name, $password);

    // Execute the query and check for success
    if ($sql->execute()) {
        echo "<script type='text/javascript'>alert('$message');window.location.href='../login.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Error: " . $sql->error . "');window.history.back();</script>";
    }

    // Close statement and connection
    $sql->close();
} else {
    echo "<script type='text/javascript'>alert('Error: Missing required fields.');window.history.back();</script>";
}

$conn->close();
?>
