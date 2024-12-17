<?php
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $author_name = $conn->real_escape_string($_POST['author_name']);
    $story_title = $conn->real_escape_string($_POST['story_title']);
    $story_des = $conn->real_escape_string($_POST['story_des']);
    $story_content = $conn->real_escape_string($_POST['story_content']);

    // Insert into database
    $sql = "INSERT INTO author_add (author_name, story_title, story_des, story_content)
            VALUES ('$author_name', '$story_title', '$story_des' , '$story_content')";

    if ($conn->query($sql) === true) {
        echo "<script>alert('Author and Story added successfully!');
              window.location.href = '../admin/author_add.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
