<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure the user is logged in
if (!isset($_SESSION["user_id"])) {
    echo "<script>alert('You must log in to access this page.'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION["user_id"]; // Retrieve user ID from session

// Fetch user details (username)
$sql = "SELECT name FROM register WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate new password and confirmation match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('New password and confirmation do not match.'); window.location.href='change-password.php';</script>";
        exit();
    }

    // Check if the current password is correct
    $sql = "SELECT password FROM register WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($stored_password);
    $stmt->fetch();
    $stmt->close();

    if ($stored_password !== $current_password) {
        echo "<script>alert('Invalid current password.'); window.location.href='change-password.php';</script>";
        exit();
    }

    // Update the password
    $sql = "UPDATE register SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_password, $user_id);
    if ($stmt->execute()) {
        echo "<script>alert('Password updated successfully.'); window.location.href='profile.php';</script>";
    } else {
        echo "Error updating password: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../css/plyr.css" type="text/css">
    <link rel="stylesheet" href="../css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../css/style.css" type="text/css">

    <style>
        body {
            font-family: 'Mulish', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .containers {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-groups {
            position: relative;
            margin-bottom: 25px;
        }

        .form-groups label {
            font-size: 1rem;
            color: #555;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .form-groups input {
            width: 100%;
            padding: 12px;
            padding-left: 40px;
            margin-top: 5px;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        .form-groups input:focus {
            border-color: #007bff;
            outline: none;
            background-color: #fff;
        }

        .form-groups i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #007bff;
        }

        .btn {
            background-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 1.2rem;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #007bff;
            font-size: 1rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #0056b3;
        }

        @media (max-width: 576px) {
            .container {
                padding: 30px;
            }
        }
    </style>
</head>
<body>

     <!-- Page Preloder -->
   <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="./index.php">
                            <img src="../img/logo3.jpg" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li class=""><a href="./home.php">Home</a></li>
                                <li><a href="./categories1.php">Stories <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="./categories1.php">Stories</a></li>
                                        <li><a href="./author.php">Authors</a></li>
                                        <li><a href="./videowatching.php">Anime Watching</a></li>
                                        <li><a href="./story_writing.php">story writing</a></li>
                                        <!--<li><a href="./story_creating.php">story creating</a></li>-->
                                        <!--<li><a href="./index.php">Logout</a></li> -->
                                    </ul>
                                </li>
                                
                                <li><a href="./blogs.php">Own Stories</a></li>
                                <li><a href="./aifeatures1.php">AI Features</a></li>
                                <li><a href="./contant1.php">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <!-- <a href="#" class="search-switch"><span class="icon_search"></span></a> -->
                        <a href="./profile.php"><span class="icon_profile">
                            
                            
                        </span>Profile</a>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->

    <div class="containers">
        <h1>Change Password</h1>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
        <form action="change-password.php" method="POST">
            <div class="form-groups">
                <label for="current-password">Current Password</label>
                <i class="fas fa-lock"></i>
                <input type="password" id="current-password" name="password" placeholder="Enter your current password" required>
            </div>
            <div class="form-groups">
                <label for="new-password">New Password</label>
                <i class="fas fa-key"></i>
                <input type="password" id="new-password" name="new_password" placeholder="Enter a new password" required>
            </div>
            <div class="form-groups">
                <label for="confirm-password">Confirm New Password</label>
                <i class="fas fa-key"></i>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm your new password" required>
            </div>
            <button type="submit" class="btn">Update Password</button>
        </form>
        <div class="back-link">
            <a href="profile.php">Back to Profile</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; <script>document.write(new Date().getFullYear());</script> All rights reserved. Made with ❤️ by <a href="https://colorlib.com" target="_blank">Colorlib</a>.</p>
        </div>
    </footer>

    <!-- Js Plugins -->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/player.js"></script>
    <script src="../js/jquery.nice-select.min.js"></script>
    <script src="../js/mixitup.min.js"></script>
    <script src="../js/jquery.slicknav.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/main.js"></script>
</body>
</html>
