<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header('Location: login.php');
    exit();
}

// Get the user ID from the session
$id = $_SESSION["user_id"];

// Fetch user details from the database
$sql = "SELECT * FROM register WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // Use prepared statement
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists in the database
if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    echo "<script>alert('User not found. Please log in again.'); window.location.href='login.php';</script>";
    exit();
}

// Update user profile if the form is submitted
if (isset($_POST['save_changes'])) {
    // Get form data
    $email = $_POST['email_id'];
    $name = $_POST['name'];
    $password = $_POST['password']; // Assuming password change is allowed
    $usertype=$_POST['usertype'];

    // Handle file upload for profile picture
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "../uploads/"; // Ensure this directory exists and is writable
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        
        // Check if the file is a valid image (optional step)
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture = $target_file;
            } else {
                echo "<script>alert('Error uploading file.');</script>";
                $profile_picture = $user_data['profile_image']; // Fallback to old picture
            }
        } else {
            echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            $profile_picture = $user_data['profile_image']; // Fallback to old picture
        }
    } else {
        $profile_picture = $user_data['profile_image']; // Use old profile picture if none uploaded
    }

    // Update user data in the database
    $update_sql = "UPDATE register SET 
                    email = ?, 
                    name = ?, 
                    password = ?, 
                    usertype = ?, 
                    profile_image = ? 
                    WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param(
        "sssssi", // Correct data types for the parameters
        $email,
        $name,
        $password,
        $usertype,
        $profile_picture,
        $id
    );

    if ($update_stmt->execute()) {
        echo "<script>alert('Profile updated successfully'); window.location.href='../afterlogin/profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile: " . $conn->error . "');</script>";
    }
}

// Close the database connection
$conn->close();
?>
