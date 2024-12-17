<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "storydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch genre details based on genres_name
if (isset($_GET['genres_name'])) {
    $genres_name = $conn->real_escape_string($_GET['genres_name']);
    $sql = "SELECT * FROM video_add WHERE genres_name = '$genres_name'";
    $result = $conn->query($sql);
} else {
    die("Genre not specified.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre Details</title>
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
       .containers {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 15px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.containers:hover {
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
}

.card {
    border: none;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.card-body {
    padding: 20px;
    background-color: #fff;
}

.card h2 {
    color: #4a4a4a;
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.card p {
    color: #6c757d;
    font-size: 1rem;
    line-height: 1.6;
}

.video-link a {
    color: #007bff;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.3s ease;
}

.video-link a:hover {
    color: #0056b3;
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

    <!-- Breadcrumb Begin -->
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
    <!-- Breadcrumb End -->

    <div class="containers">
        <div class="details-section">
        <?php
if ($result && $result->num_rows > 0) {
    echo "<h1>Stories in " . htmlspecialchars($genres_name) . "</h1>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card my-3'>";
        echo "<div class='card-body'>";
        echo "<h2>" . htmlspecialchars($row['story_title']) . "</h2>";
        echo "<p>" . htmlspecialchars($row['story_des']) . "</p>";

        // Get the video link
        $videoLink = htmlspecialchars($row['video_link']);

        // Check if the video link is a YouTube URL
        if (strpos($videoLink, 'youtube.com') !== false || strpos($videoLink, 'youtu.be') !== false) {
            // Extract the video ID from the YouTube URL
            preg_match('/(?:https?:\/\/(?:www\.)?youtube\.com\/(?:v\/|e(?:mbed)?)\/|youtu\.be\/)([A-Za-z0-9_-]{11})/', $videoLink, $matches);
            $youtubeVideoId = isset($matches[1]) ? $matches[1] : '';

            if ($youtubeVideoId) {
                // Embed the YouTube video using iframe
                echo "<iframe width='100%' height='315' src='https://www.youtube.com/embed/$youtubeVideoId' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
            } else {
                echo "<p>Invalid YouTube video link.</p>";
            }
        } else {
            // If not a YouTube video, display it as a regular video (MP4, WebM, etc.)
            $fileExtension = pathinfo($videoLink, PATHINFO_EXTENSION);

            if (in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg'])) {
                echo "<video controls width='100%'>
                        <source src='$videoLink' type='video/$fileExtension'>
                        Your browser does not support the video tag.
                      </video>";
            } else {
                echo "<p class='video-link'><a href='$videoLink' target='_blank'>Watch Video</a></p>";
            }
        }

        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No stories found for this genre.</p>";
}
?>

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
                        <li class="active"><a href="./home.html">Homepage</a></li>
                        <li><a href="./categories.html">Categories</a></li>
                        <li><a href="./blog.html">Our Blog</a></li>
                        <li><a href="./contant1.php">Contacts</a></li>
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

<?php
$conn->close();
?>
