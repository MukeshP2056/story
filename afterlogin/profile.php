<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Database connection
$host = "localhost"; // Update with your DB host
$username = "root"; // Update with your DB username
$password = ""; // Update with your DB password
$database = "storydb"; // Update with your database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, email,profile_image FROM register WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch user details
    $user = $result->fetch_assoc();
    $username = $user['name'];
    $email = $user['email'];
    $profile_image=$user['profile_image'];
    // $created_at = date("F Y", strtotime($user['created_at']));
    // $favorite_genres = $user['favorite_genres'];
} else {
    // User not found, redirect to login
    header("Location: login.php");
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;600;700&display=swap" rel="stylesheet">

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
            font-family: 'Mulish', Arial, sans-serif;
            margin: 0;
            padding: 0;
            /* background-color: #f4f4f9; */
            background: url('../img/story-bg.jpg');
            background-repeat: no-repeat;
            background-position: cover;
            color: #333;
        }

        .profile-container {
            max-width: 800px;
    margin: 0 auto;
    /* background-color: #fff; */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #007bff;
            margin-bottom: 15px;
        }

        .profile-header h1 {
            margin: 0;
            font-size: 28px;
            color: #007bff;
        }

        .bio {
            font-size: 16px;
            color: #555;
        }

        .profile-details h2 {
            font-size: 22px;
            color: #333;
            border-bottom: 2px solid #007bff;
            display: inline-block;
            margin-bottom: 10px;
        }

        .profile-details p {
            font-size: 16px;
            color: #555;
            margin: 8px 0;
        }

        .profile-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .profile-actions button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .profile-actions button:hover {
            background-color: #0056b3;
        }

        .user-stories {
            margin-top: 20px;
        }

        .user-stories h2 {
            font-size: 22px;
            color: #333;
            border-bottom: 2px solid #007bff;
            display: inline-block;
            margin-bottom: 10px;
        }

        .user-stories ul {
            list-style: none;
            padding: 0;
        }

        .user-stories li {
            margin: 10px 0;
        }

        .user-stories li a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .user-stories li a:hover {
            text-decoration: underline;
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

    <div class="profile-container">
        <div class="profile-header">
            <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Picture" class="profile-pic">
            <h1><?php echo htmlspecialchars($username); ?></h1>
            <p class="bio">Creative writer and adventurer, weaving words to inspire and ignite imagination.</p>
        </div>

        <div class="profile-details">
            <h2>Profile Details</h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <!-- <p><strong>Member Since:</strong> <?php echo htmlspecialchars($created_at); ?></p>
            <p><strong>Favorite Genres:</strong> <?php echo htmlspecialchars($favorite_genres); ?></p> -->
        </div>

        <div class="profile-actions">
            <button onclick="window.location.href='./view_profile.php'">Edit Profile</button>
            <button onclick="window.location.href='change-password.php'">Change Password</button>
            <button onclick="window.location.href='../login.php'">Logout</button>
        </div>

        <?php
// Start session to get the user_id (assuming user is logged in)
// session_start();

// Ensure user is logged in and user_id is available in session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

// Database connection details
$host = 'localhost';
$dbname = 'storydb';
$username = 'root';
$password = '';

// Create a PDO instance for database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Get the current user_id from the session
$user_id = $_SESSION['user_id'];

// Query to fetch stories based on user_id
$query = "SELECT title, created_at FROM story WHERE user_id = :user_id AND status='approved' ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Using bindParam to bind user_id
$stmt->execute();

// Fetch the results
$stories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="user-stories">
    <h2>My Stories</h2>
    <ul>
        <?php if (!empty($stories)): ?>
            <?php foreach ($stories as $story): ?>
                <li><a href="#"><?php echo htmlspecialchars($story['title']); ?></a> - Published on <?php echo date("M d, Y", strtotime($story['created_at'])); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No stories found.</li>
        <?php endif; ?>
    </ul>
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
