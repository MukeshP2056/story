<?php
// Database connection
$host = "localhost"; // Replace with your database host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "storydb"; // Replace with your database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all authors for the left-side list
$sql = "SELECT DISTINCT author_name FROM author_add;";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>storiess | App</title>

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

       


/* Container styling */
.containers {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 90%;
  padding: 36px;
  text-align: center;
  overflow: hidden;
  /* align-items:center; */
  margin:0 auto;
}

/* Title styling */
.titles {
  font-size: 20px;
  font-weight: bold;
  color: #5e3b83;
  margin-bottom: 15px;
  border-bottom: 2px solid #ddd;
  padding-bottom: 10px;
}

/* Authors list styling */
.authors-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
  /* max-height: 300px; /* Makes it scrollable */
  /* overflow-y: auto;  */
}

/* Author item styling */
.author-item {
  display: block;
  text-decoration: none;
  font-size: 14px;
  color: #5e3b83;
  background-color: #f1eef5;
  padding: 10px 15px;
  border: 1px solid #d9d7e3;
  border-radius: 5px;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.author-item:hover {
  background-color: #5e3b83;
  color: #fff;
}
img{
    width: 100%;
    height:100%;
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

   <!-- Breadcrumb Begin -->
   <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./home.php"><i class="fa fa-home"></i> Home</a>
                        <a href="./categories1.php">Categories</a> <!-- Updated this link -->
                        <span>authors</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <div class="containers">
    <h2 class="titles">Authors to follow</h2>
    <div class="authors-list">
       <div class="row">
        <div class="col-lg-6" style="overflow:auto">
        <?php
        // Check if there are any authors in the database
        if ($result->num_rows > 0) {
            // Loop through and display each author as a list item
            while ($row = $result->fetch_assoc()) {
                echo '<a href="authors1.php?author=' . urlencode($row['author_name']) . '" class="author-item">' 
                . htmlspecialchars($row['author_name']) . 
                '</a><br>';            }
        } else {
            echo '<p>No authors found.</p>';
        }

        // Close the database connection
        $conn->close();
        ?>
        </div>
        <div class=col-lg-6>
            <img src="../img/authors.avif" alt="">
        </div>
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