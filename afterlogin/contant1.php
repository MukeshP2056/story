<?php
// Database configuration
$servername = "localhost"; // Use your server's name
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "storydb"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from the content_moderation table
$sql = "SELECT email, phone, address FROM content_moderation ORDER BY id DESC LIMIT 1"; // Fetch the most recent entry
$result = $conn->query($sql);

// Initialize variables to hold the fetched data
$email = $phone = $address = "";

// Check if a result was returned
if ($result->num_rows > 0) {
    // Fetch the row as an associative array
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $phone = $row['phone'];
    $address = $row['address'];
} else {
    // If no results, use default values or display a placeholder
    $email = "contact@yourwebsite.com";
    $phone = "+123 456 7890";
    $address = "123 Main St, Suite 101, Your City, Country";
}

// Close the database connection
$conn->close();
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
                                
                                <li><a href="./blogs.php">Own Stories</a></li>
                                <li><a href="./aifeatures1.php">AI Features</a></li>
                                <li class="active"><a href="./contant1.php">Contacts</a></li>
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
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <a href="./contant.php">contant page</a>
                        
                        <span>Contant us</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

      <!-- Contact Us Section -->
      <section class="contact-us-section py-5" style="background-color: #f0f2f5;">
        <div class="container">
            <h2 class="text-center">Contact Us</h2>
            <p class="text-center" style="color: #000;">We’d love to hear from you! Send us a message</p>
            
            <div class="row mt-4">
                <!-- Contact Form -->
                <div class="col-md-6">
                <form action="../backend/contants_page.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                  </div>
                  <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="5" placeholder="Write your message here" required></textarea>
                </div>
    
                <button type="submit" class="btn btn-primary w-100">Send Message</button>
                </form>

                </div>
                
                <!-- Contact Details -->
                <div class="col-md-6">
        <div class="contact-info">
          <h4>Contact Information</h4>
          <p style="color: #000;">If you have any questions, feel free to reach out to us at:</p>
          <ul class="list-unstyled">
            <!-- PHP to dynamically display data -->
            
            <li><strong>Address:</strong> <?php echo $address; ?></li>
            <li><strong>Phone:</strong> <?php echo $phone; ?></li>
            <li><strong>Email:</strong> <?php echo $email; ?></li>
          </ul>
          <h4>Follow Us</h4>
          <ul class="list-inline">
            <li class="list-inline-item"><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
            <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
            <li class="list-inline-item"><a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
          </ul>
        </div>
      </div>
            </div>
        </div>
    </section>
    
   

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