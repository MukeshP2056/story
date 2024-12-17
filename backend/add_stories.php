<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$genre = $_POST['genres_name'];
$title = $_POST['Story_Title'];
$author = $_POST['Author_Name'];
$content = $_POST['Story_Content'];

// File upload paths
$image_target_dir = "../uploads/";
$video_target_dir = "../videos/";
$image_target_file = $image_target_dir . basename($_FILES["image_path"]["name"]);
$video_target_file = $video_target_dir . basename($_FILES["video_path"]["name"]);
$image_file_type = strtolower(pathinfo($image_target_file, PATHINFO_EXTENSION));
$video_file_type = strtolower(pathinfo($video_target_file, PATHINFO_EXTENSION));

// Image and video upload validation (optional)
$image_check = getimagesize($_FILES["image_path"]["tmp_name"]);
if ($image_check === false) {
    die("File is not an image.");
}

$video_check = mime_content_type($_FILES["video_path"]["tmp_name"]);
if (strpos($video_check, 'video') === false) {
    die("File is not a valid video.");
}

// Move uploaded files to appropriate directories
if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $image_target_file) &&
    move_uploaded_file($_FILES["video_path"]["tmp_name"], $video_target_file)) {
    
    // Prepare SQL to insert data into the database
    $sql = "INSERT INTO stories_add (genres_name, story_title, image_path, video_path, author_name, story_content) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $genre, $title, $image_target_file, $video_target_file, $author, $content);
    
    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('story added successfully.');window.location.href='../admin/stories_add.php';
</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
} else {
    echo "Sorry, there was an error uploading your files.";
}

// Close the database connection
$conn->close();
?>
