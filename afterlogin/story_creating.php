<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creative Writing Challenge</title>

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

    <!-- Custom Styles -->
    <style>
        .containers {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        /* Writing Tool Section */
        .writing-tool {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .writing-tool h2 {
            font-size: 2rem;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Form Input Fields */
        .writing-tool input[type="text"],
        .writing-tool textarea,
        .writing-tool select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            color: #333;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        .writing-tool input[type="text"]:focus,
        .writing-tool textarea:focus,
        .writing-tool select:focus {
            border-color: #007bff;
            background-color: #fff;
            outline: none;
        }

        /* Textarea specific styles */
        .writing-tool textarea {
            resize: vertical;
            min-height: 150px;
        }

        /* Submit Button */
        .writing-tool button {
            background-color: #007bff;
            color: #fff;
            padding: 12px 30px;
            font-size: 1.2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .writing-tool button:hover {
            background-color: #0056b3;
        }

        .story-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fff;
            border-radius: 8px;
            
            margin: 10px;
        }

        .story-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            padding: 10px
        }

        .story-item h3 {
            font-size: 1.2rem;
            margin-top: 10px;
            color: #333;
        }

        .story-item p {
            font-size: 1rem;
            color: #555;
        }

        .breadcrumb__links a {
            color: #007bff;
            text-decoration: none;
        }

        .breadcrumb__links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header__content d-flex justify-content-between align-items-center">
                <a href="./home.php" class="header__logo">
                    <img src="../img/logo.png" alt="Site Logo">
                </a>
                <nav class="header__menu">
                    <ul class="d-flex list-unstyled">
                        <li class="active"><a href="./home.php">Home</a></li>
                        <li><a href="./categories1.php">Stories</a></li>
                        <li><a href="./blog.php">Blog</a></li>
                        <li><a href="./aifeatures1.php">AI Features</a></li>
                        <li><a href="./contact1.php">Contact</a></li>
                    </ul>
                </nav>
                <a href="profile.php" class="profile-link"><span class="icon_profile"></span> Profile</a>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="breadcrumb-option">
        <div class="container">
            <nav class="breadcrumb__links">
                <a href="./home.php"><i class="fa fa-home"></i> Home</a>
                <span>Creative Challenge</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="containers">
        <h1>Creative Challenge</h1>

        <!-- Writing Tool -->
        <section class="writing-tool">
  <h2>Create Your Story</h2>
  <form action="../backend/story_creating1.php" method="POST" enctype="multipart/form-data">
    <!-- Story Title -->
    <input type="text" name="title" placeholder="Story Title" required>
    
    <!-- Story Content -->
    <textarea name="content" placeholder="Start writing your story..." rows="6" required></textarea>
    
    <!-- Video File Upload -->
    <label for="story_video">Upload Video (Optional):</label>
    <input type="file" id="story_video" name="story_video" accept="video/*">

    <input type="text" name="category" placeholder="Story Title" required>
    
    <!-- Story Category -->
    <!--<select name="category" required>
      <option value="Adventure">Adventure</option>
      <option value="Fantasy">Fantasy</option>
      <option value="Mystery">Mystery</option>
    </select>-->
    
    <!-- Submit Button -->
    <button type="submit">Submit Story</button>
  </form>
</section>

        </main>

         <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; <script>document.write(new Date().getFullYear());</script> All rights reserved. Made with ❤️ by <a href="https://colorlib.com" target="_blank">Colorlib</a>.</p>
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
    </body>
</html>
