<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kahaani - Endless Tales</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
        .signup {
            background: url("img/normal-breadcrumb.jpg") no-repeat  center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 20px;
            min-height: 100vh;
        }
        .signup__form {
            background: rgba(0, 0, 0, 0.6);
            padding: 40px;
            border-radius: 8px;
            color: white;
            width: 100%;
            max-width: 500px;
        }
        .login {
            background: url(img/story-login.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            height: 80%;
        }
        .login-container{
            background: rgba(255, 255, 255, 0.1);   
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */

                     padding: 20px;
        }

        /* Footer Section */
        footer {
            /* margin-top: 50px; */
            background: #640D5F;
            color: #fff;
            padding: 20px 0;
            text-align: center;
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
                        <a href="./index1.php">
                            <img src="./img/logo3.jpg" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li ><a href="./index.php">Home</a></li>
                                <li><a href="./stories_genre.php">Stories</a>
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

    <!-- Login Section Begin -->
    <section class="login spad">
        <div class="container login-container">
            <div class="row">
                <!-- Login Form -->
                <div class="col-lg-6 col-md-12">
                    <div class="login__form">
                        <h3>Login</h3>
                        <form action="backend/logindb.php" method="post">
                            <div class="input__item">
                                <input type="email" name="email" placeholder="Email address" required>
                                <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input type="password" name="password" placeholder="Password" required>
                                <span class="icon_lock"></span>
                            </div>
                            <button type="submit" class="site-btn">Login Now</button>
                        </form>
                        <!-- <a href="#" class="forget_pass">Forgot Your Password?</a> -->
                    </div>
                </div>
    
                <!-- Registration Prompt -->
                <div class="col-lg-6 col-md-12">
                    <div class="login__register">
                        <h3>Don't Have An Account?</h3>
                        <p>Join us now and start exploring amazing content!</p>
                        <a href="signup.php" class="primary-btn">Register Now</a>
                    </div>
                </div>
            </div>
    
            <!-- Social Login Options -->
            <!-- <div class="login__social mt-4">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="login__social__links">
                            <span>or sign in with</span>
                            <ul class="social-buttons">
                                <li><a href="#" class="facebook"><i class="fa fa-facebook"></i> Facebook</a></li>
                                <li><a href="#" class="google"><i class="fa fa-google"></i> Google</a></li>
                                <li><a href="#" class="twitter"><i class="fa fa-twitter"></i> Twitter</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </section>
    <!-- Login Section End -->

    <!-- Footer Section Begin -->
    <!--<footer class="footer">
        <div class="page-up">
            <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer__logo">
                        <a href="./index.html"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li class="active"><a href="./index.html">Homepage</a></li>
                            <li><a href="./categories.html">Categories</a></li>
                            <li><a href="./blog.html">Our Blog</a></li>
                            <li><a href="#">Contacts</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p>
                      Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved |
                      This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Footer Section -->
    <footer>
        <p>&copy; Kahaani. All rights reserved.</p>
        
    </footer>

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
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/player.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
