<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "storydb"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch approved stories
$sql = "SELECT s.*, u.name 
        FROM story s 
        JOIN register u ON s.user_id = u.id 
        WHERE s.status = 'approved' 
        ORDER BY s.created_at DESC";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Collection</title>

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
            padding: 20px;
        }

        .story-item {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            width: 100%;
            height: 100%;
        }

        .story-item h3 {
            font-size: 17px;
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }

        .row{
            row-gap: 13px;
        }

        .story-item p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        .story-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .story-item .btn {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .story-item .btn:hover {
            background-color: #0056b3;
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
                                <li><a href="./home.php">Home</a></li>
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
                                
                                <li class="active"><a href="./blogs.php">Own Stories</a></li>
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
                        <a href="./blogs.php">blog</a> <!-- Updated this link -->
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="containers">
        <h1 class="text-center" style = "color: #fff;font-size: 50px; padding-bottom: 35px;">Story Collection</h1>

        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                // Loop through stories
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4'>";
                    echo "<div class='story-item'>";
                    // Display the story's title
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    // Display category
                    echo "<p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>";

                    echo "<p><strong>Author:</strong> " . htmlspecialchars($row['name']) . "</p>";
                    // Display created date
                    echo "<p><strong>Published on:</strong> " . htmlspecialchars(date("F d, Y", strtotime($row['created_at']))) . "</p>";
                    // Display cover image if exists
                    if (!empty($row['cover_image'])) {
                        echo "<img src='../uploads/" . htmlspecialchars($row['cover_image']) . "' alt='Cover Image'>";
                    }
                    // Read More button
                    echo "<a href='writingreadmore.php?id=" . $row['id'] . "' class='btn mt-3'>Read More</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center'>No stories found.</p>";
            }

            // Close the connection
            $conn->close();
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
                    <a href="./index.php"><img src="../img/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer__nav">
                    <ul>
                        <li class="active"><a href="./home.php">Homepage</a></li>
                        <li><a href="./categories1.php">Categories</a></li>
                        <li><a href="./blogs.php">Own Stories</a></li>
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
