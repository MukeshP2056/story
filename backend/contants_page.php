<?php
// Database connection setup
$servername = "localhost"; // Your database server (localhost if running locally)
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "storydb"; // The database name

// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Prepare the SQL query to insert form data into the database
    $sql = "INSERT INTO contact_page (name, email, subject, content) VALUES (:name, :email, :subject, :message)";
    $stmt = $conn->prepare($sql);

    // Bind the form data to the query
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':message', $message);

    // Execute the query
    if ($stmt->execute()) {
        // Successful insertion
        echo "<script>alert('request added successfully.');
                    window.location.href = '../afterlogin/contant1.php'; </script>";
    } else {
        // Error during insertion
        echo "Error: Could not send message.";
    }
}
?>
