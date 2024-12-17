<?php
// Start the session
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the story ID from the query parameter
$storyId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch story details from the database
$sql = "SELECT id, genres_name, Story_Title, image_path, video_path, Author_Name, Story_Content 
        FROM stories_add 
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $storyId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the story exists
if ($result->num_rows > 0) {
    $story = $result->fetch_assoc();
} else {
    die("Story not found.");
}

// Insert into favorites (if user is logged in and submits)
if (isset($_POST['story_id']) && isset($_SESSION['user_id'])) {
    $story_id = $_POST['story_id'];
    $user_id = $_SESSION['user_id'];

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO favorites (user_id, story_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $story_id);
    
    if ($stmt->execute()) {
        echo "Story added to favorites!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Read the story: <?php echo htmlspecialchars($story['Story_Title']); ?>">
    <meta name="keywords" content="Stories, <?php echo htmlspecialchars($story['genres_name']); ?>, Reading">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo htmlspecialchars($story['Story_Title']); ?> | Story Details</title>
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
        .story-detail {
            max-width: 1160px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .story-detail img {
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .story-detail h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #333;
        }

        .story-detail h4 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #666;
        }

        .story-detail p {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
        }

        .story-detail video {
            width: 100%;
            margin-top: 20px;
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
                                <li class="active"><a href="./categories1.php">Stories <span class="arrow_carrot-down"></span></a>
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

    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./home.php"><i class="fa fa-home"></i> Home</a>
                        <a href="./categories.html">Categories</a>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="story-detail">
        <h1><?php echo htmlspecialchars($story['Story_Title']); ?></h1>
        <h4>By: <?php echo htmlspecialchars($story['Author_Name']); ?> | Genre: <?php echo htmlspecialchars($story['genres_name']); ?></h4>
        <div class="row">
            <div class="col-lg-6">
                <img src="<?php echo htmlspecialchars($story['image_path'] ?: '../img/placeholder.png'); ?>" 
                     alt="<?php echo htmlspecialchars($story['Story_Title']); ?>">
                <?php if (!empty($story['video_path'])): ?>
                    <video controls>
                        <source src="<?php echo htmlspecialchars($story['video_path']); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <p><?php echo nl2br(htmlspecialchars($story['Story_Content'])); ?></p>
                <!-- Add to Favorites Button -->
                <button class="favorite-btn" data-story-id="<?php echo $story['id']; ?>">Add to Favorites</button>
                <button class="take-quiz" data-story-id="<?php echo $story['id']; ?>">Take Quiz</button>

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
                        <a href="./index.html"><img src="../img/logo3.jpg" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li><a href="./home.html">Homepage</a></li>
                            <li class="active"><a href="./categories.html">Categories</a></li>
                            <li><a href="./blog.html">Our Blog</a></li>
                            <li><a href="./contant1.php">Contacts</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p>&copy; <?php echo date("Y"); ?> All rights reserved | Kahhanii Endless tales</p>
                </div>
            </div>
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

    <!-- Add to Favorites using AJAX -->
    <script>
       // When user clicks "Add to Favorites"
$(document).on('click', '.favorite-btn', function() {
    var story_id = $(this).data('story-id');
    
    $.ajax({
        url: '../backend/add_to_favorites.php', // PHP script to add the story to favorites
        type: 'POST',
        data: { story_id: story_id },
        success: function(response) {
            alert(response); // Show success or error message
            location.reload(); // Reload the page to update the button state
        }
    });
});

// When user clicks "Remove from Favorites"
$(document).on('click', '.remove-favorite-btn', function() {
    var story_id = $(this).data('story-id');
    
    $.ajax({
        url: '../backend/remove_from_favorites.php', // PHP script to remove the story from favorites
        type: 'POST',
        data: { story_id: story_id },
        success: function(response) {
            alert(response); // Show success or error message
            location.reload(); // Reload the page to update the button state
        }
    });
});
document.addEventListener("DOMContentLoaded", function() {
    const quizButtons = document.querySelectorAll('.take-quiz');

    quizButtons.forEach(button => {
        button.addEventListener('click', function() {
            const storyId = this.getAttribute('data-story-id');
            const quizUrl = 'story_quiz.php?story_id=' + storyId;  // Replace 'quiz_page.php' with your quiz page URL
            window.location.href = quizUrl;
        });
    });
});


    </script>
</body>
</html>
