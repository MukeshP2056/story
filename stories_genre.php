<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your DB password
$database = "storydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch genres data
$sql = "SELECT * FROM genres";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Stories App">
    <meta name="keywords" content="Stories, Adventure, Fantasy">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kahaani - Endless Tales</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/plyr.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

    <style>
        .category-section {
            padding: 40px 0;
            background-color: #220020;
        }
        .category-item h2 {
    font-size: 1.5em;
    color: #333;
    margin-bottom: 15px;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
        .category-item {
    display: flex;
    flex-direction: column; /* Stack the content vertically */
    justify-content: space-between; /* Space out the content evenly */
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 20px;
    transition: transform 0.3s ease;
    height: 100%; /* Make sure the card takes up the full height available */
}

.category-item img {
    object-fit: cover; /* Ensure the image covers the area */
    width: 100%;
    height: 200px; /* Set a fixed height for the image */
    margin-bottom: 15px; /* Add some spacing below the image */
}

        .category-item:hover {
            transform: scale(1.05);
        }

        @media (max-width: 992px) {
            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .category-grid {
                grid-template-columns: 1fr;
            }
        }
        li a:hover{
            text-decoration: none;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <!-- Header code here -->
    </header>

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
                            <img src="./img/logo3.jpg" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li><a href="./index.php">Home</a></li>
                                <li class="active"><a href="stories_genre.php">Stories </a>
                                    <!--<ul class="dropdown">
                                        <li><a href="./categories.php">Stories</a></li>
                                        <li><a href="./anime-details.h">Authors</a></li>
                                        <li><a href="./anime-watching.php">Anime Watching</a></li>
                                        <li><a href="./blog-details.php">Blog Details</a></li>
                                        
                                    </ul>-->
                                </li>
                                
                                <li><a href="./aboutus.php">About us </a></li>
                                <li><a href="./aifeatures.php">AI Features</a></li>
                                <li><a href="./contant.php">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <!-- <a href="#" class="search-switch"><span class="icon_search"></span></a> -->
                        <a href="./login.php"><span class="icon_profile">
                            
                        </span>Login</a>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->


    <section class="category-section">
    <div class="container">
        <div class="category-grid">
            <?php
            if ($result->num_rows > 0) {
                // Output each genre
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="category-item">';
                    echo '<a href="login.php?genres_name=' . urlencode($row['genres_name']) . '">';
                    echo '<h2>' . htmlspecialchars($row['genres_name']) . '</h2>';
                    echo '<img src="uploads/' . htmlspecialchars($row['image_path']) . '" alt="Image">';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>No genres found.</p>";
            }
            ?>
        </div>
    </div>
</section>


   <!-- Js Plugins -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/player.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/mixitup.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>


    <!-- Footer Section Begin -->
<footer class="footer">
    <div class="page-up">
        <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer__logo">
                    <a href="./index.html"><img src="img/logo3.jpg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer__nav">
                    <ul>
                        <li class="active"><a href="./index.php">Homepage</a></li>
                        <li><a href="./stories_genre.php">Stories</a></li>
                        <li><a href="./aboutus.php">About Us</a></li>
                        <li><a href="./contant.php">Contacts</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Kahhanii Endless Tales

              </div>
          </div>
      </div>
  </footer>
  <!-- Footer Section End -->
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
