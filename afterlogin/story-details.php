<?php
// Start session
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "storydb";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get story ID from URL
$id = $_GET['id'] ?? 0;

// Fetch story details
$sql = "SELECT id, author_name, story_title, story_content FROM author_add WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $story = $result->fetch_assoc();
} else {
    echo "<p>Story not found.</p>";
    exit;
}

// Handle "Add to Favorites" submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_favorites'])) {
    $story_id = (int)$_POST['story_id'];
    $user_id = $_SESSION['user_id'] ?? 0; // Replace with actual user session

    if ($user_id === 0) {
        echo "<script>alert('Please log in to add favorites.');</script>";
    } else {
        // Check if the story is already in favorites
        $check_sql = "SELECT id FROM author_favorites WHERE user_id = ? AND story_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $user_id, $story_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "<script>alert('This story is already in your favorites.');</script>";
        } else {
            // Insert into the author_favorites table
            $added_at = date("Y-m-d H:i:s");
            $insert_sql = "INSERT INTO author_favorites (user_id, story_id, added_at) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("iis", $user_id, $story_id, $added_at);

            if ($insert_stmt->execute()) {
                echo "<script>alert('Story added to favorites successfully.');</script>";
            } else {
                echo "<script>alert('Failed to add story to favorites. Please try again.');</script>";
            }

            $insert_stmt->close();
        }

        $check_stmt->close();
    }
}

// Close the connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($story['story_title']); ?> | Kahaani - Endless Tales</title>
    <link rel="icon" type="image/x-icon" href="../img/logo3.jpg">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
        .story-detailed-container {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            max-width: 1136px;
            margin: 20px auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .story-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            line-height: 1.4;
        }

        .story-content {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 20px;
            text-align: justify;
        }

        .story-detailed-container p:last-child {
            margin-bottom: 0;
        }

        img {
            width: 100%;
        }

        .story-detailed-container img{
            height: auto;
        }
        h1 {
            font-size: 40px;
        }

        .btn-primary {
            padding: 10px 15px;
            border-radius: 5px;
            color: #fff;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header__right a{
            display: flex
;
    align-items: center;
    gap: 10px;
        }
    </style>
</head>

<body>

     <!-- Header Section -->
     <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="./index.php">
                            <img src="../img/logo3.jpg" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <nav class="header__menu">
                        <ul>
                            <li><a href="./home.php">Home</a></li>
                            <li class="active"><a href="./categories1.php">Stories</a></li>
                            <li><a href="./blogs.php">Own Stories</a></li>
                            <li><a href="./aifeatures1.php">AI Features</a></li>
                            <li><a href="./contant1.php">Contacts</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-2">
                    <div class="header__right  d-flex">
                        <a href="./user_favorites.php"><i class="fa fa-heart"></i> Favorites</a>
                        <a href="./profile.php"><i class="fa fa-user"></i> Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Story Detail -->
    <div class="story-detailed-container">
        <div class="row">
            <div class="col-lg-6">
                <h1><?php echo htmlspecialchars($story['story_title']); ?></h1>
                <h3>by <?php echo htmlspecialchars($story['author_name']); ?></h3>
                <p class="story-content">
                    <?php echo nl2br(htmlspecialchars($story['story_content'])); ?>
                </p>
                <div class="d-flex" style="gap: 10px;">
                    <!-- Download as PDF -->
                <form method="POST" action="download_author_pdf.php">
                    <input type="hidden" name="author_id" value="<?php echo $story['id']; ?>">
                    <button type="submit" class="btn btn-primary" style="background-color: #007bff;">Download as PDF</button>
                </form>
                <!-- Add to Favorites -->
                <form method="POST">
                    <input type="hidden" name="story_id" value="<?php echo $story['id']; ?>">
                    <button type="submit" name="add_to_favorites" class="btn btn-primary" style="background-color: #28a745;">Add to Favorites</button>
                </form>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="../img/storybyme.jpg" alt="Story Image">
            </div>
        </div>
    </div>

     <!-- Footer Section Begin -->
<footer class="footer">
    <div class="page-up">
        <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer__logo">
                    <a href="./home.php"><img src="../img/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer__nav">
                    <ul>
                        <li><a href="./home.php">Homepage</a></li>
                        <li class="active"><a href="./categories1.php">Categories</a></li>
                        <li><a href="./blog.php">Own Stories</a></li>
                        <li><a href="./contant1.php">Contacts</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Kahhanii Endless tales
                  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>

              </div>
          </div>
      </div>
  </footer>
  <!-- Footer Section End -->

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
