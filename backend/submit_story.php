<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit;
    }

    // Retrieve the user_id from the session
    $user_id = $_SESSION['user_id'];

    // Get form inputs
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $category = $conn->real_escape_string($_POST['category']);

    // Handle the file upload for the cover image
    $cover_image = null;
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = "../uploads/";
        $cover_image = $upload_dir . basename($_FILES['cover_image']['name']);

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['cover_image']['type'], $allowed_types)) {
            echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
            exit;
        }

        if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $cover_image)) {
            echo "Failed to upload image.";
            exit;
        }
    }

    // Insert the story into the database with default status as 'pending'
    $sql = "INSERT INTO story (user_id, title, content, cover_image, category) 
            VALUES ('$user_id', '$title', '$content', '$cover_image', '$category')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Story submitted successfully! Awaiting admin approval');window.location.href='../afterlogin/story_writing.php'</script>";
        
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
