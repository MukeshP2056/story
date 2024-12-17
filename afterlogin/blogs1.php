<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Age Groups</title>

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
    

    .age-container {
      display: flex;
      gap: 40px; /* Space between icons */
      align-items: center;
    }

    .age-card {
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      background-color: #e6d8ff; /* Light purple */
      border-radius: 50%;
      width: 120px;
      height: 120px;
      justify-content: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      cursor: pointer;
      text-decoration: none;
      transition: transform 0.2s ease;
    }

    .age-card:hover {
      transform: scale(1.1); /* Slight zoom effect */
    }

    .age-card .icon {
      font-size: 50px;
      color: #6a1b9a; /* Purple */
    }

    .age-card span {
      margin-top: 10px;
      background-color: #6a1b9a;
      color: #fff;
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 500;
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
                        <a href="./home.php">
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
                                        <li><a href="./anime-watching.php">Anime Watching</a></li>
                                        <li><a href="./blog-details.php">Blog Details</a></li>
                                        <li><a href="../index.php">Logout</a></li> 
                                    </ul>
                                </li>
                                
                                <li><a href="./blog.php">blog</a></li>
                                <li><a href="./aifeatures1.php">AI Features</a></li>
                                <li><a href="./contant1.php">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <a href="#"><span class="icon_profile"></span>Profile</a>
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


  <div class="age-container">
    <!-- Age group 7–13 -->
    <a href="blogs.php" class="age-card">
      <div class="icon">👤</div>
      <span>Age 7–13</span>
    </a>

    <!-- Age group 14–17 -->
    <a href="page14to17.html" class="age-card">
      <div class="icon">👤</div>
      <span>Age 14–17</span>
    </a>
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
                        <a href="./index.html"><img src="../img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li class="active"><a href="./home.php">Homepage</a></li>
                            <li><a href="./categories1.php">Categories</a></li> <!-- Updated link -->
                            <li><a href="./blog.php">Our Blog</a></li>
                            <li><a href="./contant1.php">Contacts</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
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
