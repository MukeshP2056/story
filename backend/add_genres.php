<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<script>alert('Connection failed: " . $conn->connect_error . "');</script>");
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $genre_name = mysqli_real_escape_string($conn, $_POST['genres_name']);

    // Handle the image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Define the target directory for uploads
        $targetDir = "../uploads/";
        // Create the directory if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $imageName = basename($_FILES["image"]["name"]);

      
        $targetFilePath = $targetDir . $imageName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Check if image file is a valid image type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                // Prepare the SQL insert statement
                $sql = "INSERT INTO genres (genres_name, image_path) VALUES ('$genre_name', '$targetFilePath')";

                // Execute the query and check for success
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('New genre added successfully.');
                    window.location.href = '../admin/addgenre.php'; </script>";
                    

                } else {
                    echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        } else {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        }
    } else {
        echo "<script>alert('Please upload an image file.');</script>";
    }
}

// Close the database connection
$conn->close();
?>
