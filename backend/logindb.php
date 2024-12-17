<?php
session_start();
$user['id']=$_SESSION['user_id'] ; // After verifying user credentials during login

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $servername = "localhost";
    $db_username = "root"; // Corrected variable name to db_username for consistency
    $db_password = "";
    $dbname = "storydb"; // Change DB name accordingly

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize inputs to prevent SQL injection
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Fetch user information from the database
    $sql = "SELECT * FROM register WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    // Check if a user with the given credentials exists
    if ($result->num_rows == 1) {
        // User is authenticated
        $userInfo = $result->fetch_assoc();
        $_SESSION["logged_in"] = true;
        $_SESSION["user_id"] = $userInfo['id'];
        $_SESSION["usertype"] = $userInfo['usertype'];

        // Redirect based on usertype
        if ($userInfo['usertype'] === 'user') {
            header("Location: ../afterlogin/home.php");
        } elseif ($userInfo['usertype'] === 'admin') {
            header("Location: ../admin/admin.php");
        }
        exit();
    } else {
        // Invalid credentials
        echo "<script>alert('Invalid username or password.');window.location.href='../login.php'</script>";
    }

    // Close the database connection
    $conn->close();
}
?>
