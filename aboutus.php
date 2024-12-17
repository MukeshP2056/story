<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Kahaani - Endless Tales">
    <meta name="keywords" content="Stories, kids, adventures, fun, Kahaani">
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
        /* General Container */
        .containers {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Global Styles */
        

        h1, h2, h3 {
            color: #4b0082;
        }

        a {
            color: #4b0082;
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
        }

        /* Header Section */
       
        

        /* Intro Section */
        .intro-section {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .intro-image {
            flex: 1;
            height: auto;
            max-width: 30%;
            border-radius: 10px;
        }

        .intro-text {
            flex: 2;
        }

        .intro-text h2 {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .intro-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin: 0;
        }

        /* Features Section */
        .features {
            margin-top: 40px;
        }

        .features h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: #fff;
        }

        .features ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .features li {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 250px;
        }

        .features li:hover {
    transform: scale(1.05); /* Slight zoom-in effect */
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2); /* Increased shadow */
    cursor: pointer;
}
        .features li strong {
            display: block;
            margin-bottom: 10px;
        }

        /* How It Works Section */
        .how-it-works {
            background: #fdfdfd;
            padding: 30px;
            border-radius: 10px;
            margin-top: 40px;
        }

        .how-it-works h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .how-it-works ol {
            margin: 0;
            padding-left: 20px;
        }

        .how-it-works li {
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        /* Call to Action Section */
        .cta {
            text-align: center;
            margin-top: 50px;
            background: #4b0082;
            color: #fff;
            padding: 30px 20px;
            border-radius: 10px;
        }

        .cta h3 {
            margin-bottom: 15px;
            font-size: 1.8rem;
        }

        .cta p {
            margin-bottom: 20px;
            font-size: 1rem;
            color: #fff;
        }

        .cta-button {
            display: inline-block;
            padding: 12px 30px;
            font-size: 1rem;
            background-color: #fff;
            color: #4b0082;
            border-radius: 5px;
            font-weight: bold;
        }

        .cta-button:hover {
            background-color: #8b008b;
            color: #fff;
        }

        /* Footer Section */
        footer {
            margin-top: 50px;
            background: #640D5F;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        footer img {
            width: 100px;
            margin-top: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .intro-section {
                flex-direction: column;
            }

            .features ul {
                flex-direction: column;
                align-items: center;
            }

            .features li {
                width: 100%;
            }

            .intro-text {
                text-align: center;
            }
        }

        p {
            color: #000
        }
        footer p{
            color:#fff;
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
                                
                                <li class="active"><a href="./aboutus.php">About us </a></li>
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

    <!-- Main Content -->
    <div class="container my-5">
        <section class="intro-section">
            <img src="./img/story-image.jpg" alt="Story Illustration" class="intro-image">
            <div class="intro-text">
                <h2>Welcome to KAHAANI – Your Magical World of Stories!</h2>
                <p>
                    Discover endless adventures with Kahaani, the ultimate story web app for kids that brings the joy of storytelling to life!
                    Whether you love fairytales, space adventures, superheroes, or magical creatures, we’ve got a story just for you.
                    Here, your favorite genres come to life with interactive chatbot narrators and immersive video streaming that make every story unforgettable!
                </p>
            </div>
        </section>

        <section class="features">
            <h3>Why Kids Love Kahaani?</h3>
            <ul>
                <li>
                    <strong>✨ Choose Your Favorite Genre:</strong>
                    Pick from exciting genres like fairytales, fantasy, sci-fi, and more!
                </li>
                <li>
                    <strong>🗣️ Interactive Chatbot Narratives:</strong>
                    Enjoy stories told by chatbots that respond to your questions.
                </li>
                <li>
                    <strong>📺 Watch and Listen:</strong>
                    Stunning animated videos bring your books to life.
                </li>
                <li>
                    <strong>🎉 Customizable Experience:</strong>
                    Create playlists, switch modes, and more!
                </li>
            </ul>
        </section>

        <section class="how-it-works">
            <h3>How It Works</h3>
            <ol>
                <li>Pick Your Genre – Dive into a world of wonder!</li>
                <li>Choose Chat or Video – Let the chatbot narrate or watch animations.</li>
                <li>Explore – Discover daily new stories based on your favorites.</li>
            </ol>
        </section>

        <section class="cta">
            <h3>Personal Growth & Safe Content</h3>
            <p>All stories are age-appropriate and engaging. Parents can manage settings for a safe, educational experience.</p>
            <a href="./login.php" class="cta-button">Start Exploring Now!</a>
        </section>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy;  Kahaani. All rights reserved.</p>
        
    </footer>

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
