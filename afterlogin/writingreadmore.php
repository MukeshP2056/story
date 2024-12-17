<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "storydb"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the story ID from the URL (use a default value if not provided)
$story_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the story from the database based on the ID
$sql = "SELECT title, content, cover_image, category, created_at FROM story WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $story_id); // Bind the ID parameter
$stmt->execute();
$result = $stmt->get_result();

$story = null;
if ($result->num_rows > 0) {
    // Fetch the story data
    $story = $result->fetch_assoc();
} else {
    echo "No story found for the given ID.";
    exit; // Exit if no story is found
}

// Simulate user ID (replace with actual logged-in user ID in production)
session_start();
$user_id = $_SESSION['user_id']; // Replace this with the actual user ID from your session

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = trim($_POST['comment']); // Get the comment from the form

    if (!empty($comment)) {
        // Insert the comment into the database
        $sql = "INSERT INTO comments (story_id, user_id, comment) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $story_id, $user_id, $comment);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script type='text/javascript'>alert('Comment added successfully'); window.location.href='blogs.php';</script>";
        } else {
            echo "<p>Failed to submit your comment. Please try again.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Please enter a comment before submitting.</p>";
    }
}

// Fetch existing comments for the story
$sql = "SELECT c.comment, c.created_at, u.name FROM comments c
        JOIN register u ON c.user_id = u.id
        WHERE c.story_id = ? ORDER BY c.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $story_id);
$stmt->execute();
$result = $stmt->get_result();
$comments = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($story['title']); ?></title>
    <!-- Google Fonts and CSS Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../css/plyr.css" type="text/css">
    <link rel="stylesheet" href="../css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <style>
        body{
            overflow-x:hidden;
        }
        .story-containers {
            width: 80%;
            max-width: 1150px;
            background-color: #ffffff;
            border: 3px solid #c8d6e5;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin:0 auto;
        }
.anime__details__form{
    padding:0px 20px;
}
        .story-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 20px;
            height:100%;
        }

        .story-title {
            font-family: 'Oswald', sans-serif;
            font-size: 2rem;
            color: #333333;
            margin-bottom: 15px;
        }

        .story-content {
            font-size: 1rem;
            color: #555555;
            line-height: 1.6;
            text-align: justify;
        }

        .story-content p {
            margin-bottom: 15px;
        }

        .highlight {
            font-weight: bold;
            color: #007bff;
        }

        .header__right a {
    color: #fff;
    font-size: 1rem;
    padding: 10px;
    text-decoration: none;
    display: flex;
    gap: 10px;
    align-items: center;    transition: color 0.3s ease;
}

.header__right a:hover {
    color: #007bff;
}

.header__right{
    display:flex;
    padding:9px 0px 15px;
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
                                <li class="active"><a href="./home.php">Home</a></li>
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
                         <!-- Favorite Icon (with link to favorite stories page) -->
                    <a href="./user_favorites.php" class="favorite-icon">
                    <i class="fa fa-heart"></i> Favorites
                    </a>
                        <a href="./profile.php"><i class="fa fa-user"></i> Profile</a>                  
                      </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->


    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./home.php"><i class="fa fa-home"></i> Home</a>
                        <a href="./categories1.php">Categories</a>
                        <span><?php echo htmlspecialchars($story['title']); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="row">
        <div class="col-lg-8">
        <div class="story-containers">
        <?php if (!empty($story['cover_image'])): ?>
                    <img class="story-image" src="../uploads/<?php echo htmlspecialchars($story['cover_image']); ?>" alt="<?php echo htmlspecialchars($story['title']); ?>">
                <?php endif;?>
                <!-- Display the story's title -->
        <h1 class="story-title"><?php echo htmlspecialchars($story['title']); ?></h1>
        <div class="story-content">
        <p style="color: #333; font-size: 16px; line-height: 1.6;"><?php echo nl2br(htmlspecialchars($story['content'])); ?></p>
            <!-- Display the story's content -->

        </div>



    </div>
        </div>
        <div class="col-lg-4">
        <div class="anime__details__form">
        <div class="section-title">
            <h5>Your Comment</h5>
        </div>
        <form action="" method="POST">
            <textarea name="comment" placeholder="Your Comment" style="width: 100%; height: 100px; border-radius: 5px; padding: 10px;"></textarea><br><br>
            <input type="submit" value="Submit Comment" class="btn btn-primary">
        </form>
    </div>

    <!-- Display existing comments -->
    <div class="comments-section">
        <h5>Comments</h5>
        <?php if ($comments): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-item">
                    <p><strong><?php echo htmlspecialchars($comment['name']); ?>:</strong> <?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                    <p><small>Posted on <?php echo htmlspecialchars($comment['created_at']); ?></small></p>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No comments yet.</p>
        <?php endif; ?>
    </div>
        </div>
    </div>

    <br>

    <!-- Footer Section Begin -->
<footer class="footer">
    <div class="page-up">
        <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer__logo">
                    <a href="./index.php"><img src="../img/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer__nav">
                    <ul>
                        <li class="active"><a href="./index.php">Homepage</a></li>
                        <li><a href="./categories1.php">Categories</a></li>
                        <li><a href="./blogs.php">Own Stories</a></li>
                        <li><a href="./content1.php">Contacts</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Kahhanii Endless Tales
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
