<?php
session_start();

// Database connection details
$host = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "storydb";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your favorite stories.";
    exit;
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID from session

// Fetch the favorite stories
$sql = "SELECT stories_add.id, stories_add.story_title, stories_add.story_content,stories_add.image_path
        FROM stories_add
        JOIN favorites ON stories_add.id = favorites.story_id
        WHERE favorites.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorite Stories</title>
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
        /* Reset some default styles */
        

        /* Container for the page */
        .containers {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        

        /* Main content styles */
        main {
            margin-top: 40px;
        }

        /* Reset some default styles */
        /* Container for the page */
        .containers {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Main content styles */
        main {
            margin-top: 40px;
        }

        /* Favorites list styles */
        .favorites-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        /* Individual story styles */
        .favorite-story {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column; /* Ensure the content is stacked vertically */
            justify-content: space-between; /* Make sure there is space between content */
            height: 400px; /* Set a fixed height for the card */
        }

        .favorite-story:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .favorite-story h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #007bff;
            text-align: center;
            text-transform: capitalize;
        }

        .favorite-story p {
            color: #555;
            font-size: 1rem;
            line-height: 1.5;
            flex-grow: 1; /* Allow text to take up available space */
        }

        .favorites-list img {
            width: 100%;
            height: 200px; /* Set a fixed height for the images */
            object-fit: cover; /* Ensure the image covers the area without stretching */
            border-radius: 8px; /* Optional: Make the image corners rounded */
        }

        /* Make sure the button stays at the bottom of the card */
        .favorite-story .btn {
    /* margin-top: auto; */
    width: 50%;
    text-align: center;
}

        /* Responsive design: Adjust the layout on smaller screens */
        @media (max-width: 768px) {
            .favorites-list {
                grid-template-columns: 1fr; /* Stack cards in one column on smaller screens */
            }
        }

        .header__right a {
    color: #fff;
    font-size: 1rem;
    padding: 10px;
    text-decoration: none;
    display: flex
;
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
.footer {
    position: fixed;
    width: 100%;
    bottom: 0;
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
                                <li><a href="./home.php">Home</a></li>
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
                         <!-- Favorite Icon (with link to favorite stories page) -->
                    <a href="./user_favorites.php" class="favorite-icon">
                    <i class="fa fa-heart"></i> Favorites
                    </a>
                        <a href="./profile.php">                        <i class="fa fa-user"></i> Profile
                        </a>                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Main Content -->
    <main>
        <div class="containers">
            <?php
            if ($result->num_rows > 0) {
                echo "<div class='favorites-list'>";
                while ($row = $result->fetch_assoc()) {
                    $story_title = htmlspecialchars($row['story_title']);
                    $story_description = htmlspecialchars($row['story_content']);
                    $image=htmlspecialchars($row['image_path']);
                    echo "<div class='favorite-story'>";
                    echo "<img src='$image'>";
                    echo "<h2>$story_title</h2>";
                    echo"<button class='btn btn-primary' style='    position: relative;
                    left: 20%;'>READ MORE</button>";
                    // echo "<p>$story_description</p>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>You don't have any favorite stories yet.</p>";
            }
            ?>
        </div>
    </main>
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

  <!-- Search model Begin -->
  <div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch"><i class="icon_close"></i></div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search model end -->

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
// Close the connection
$conn->close();
?>
