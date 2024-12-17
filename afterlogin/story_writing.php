<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "storydb"; 

// Start the session to access the logged-in user ID
session_start();
$user_id = $_SESSION['user_id']; // Assume the user ID is stored in the session after login

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch approved stories for the logged-in user
$sql = "SELECT s.*, u.name 
        FROM story s 
        JOIN register u ON s.user_id = u.id 
        WHERE s.status = 'approved' AND s.user_id = ? 
        ORDER BY s.created_at DESC";

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Bind the user ID as an integer
$stmt->execute();
$result = $stmt->get_result();
?>

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
            color: #fff;
            font-size: 45px;
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
    <!-- Breadcrumb -->
    <div class="breadcrumb-option">
        <div class="container">
            <nav class="breadcrumb__links">
                <a href="./home.php"><i class="fa fa-home"></i> Home</a>
                <span>Creative Writing Challenge</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="containers">
        <h1>Creative Writing Challenge</h1>

        <!-- Writing Tool -->
        <!-- Writing Tool -->
<section class="writing-tool p-4 my-5 bg-light rounded">
    <h2 class="mb-4 text-center text-primary">Create Your Story</h2>
    <form action="../backend/submit_story.php" method="POST" enctype="multipart/form-data" class="needs-validation">
        <!-- Title Input -->
        <div class="mb-3">
            <label for="title" class="form-label">Story Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter your story title" required>
        </div>

        <!-- Content Textarea -->
        <div class="mb-3">
            <label for="content" class="form-label">Story Content</label>
            <textarea class="form-control" id="content" name="content" placeholder="Start writing your story..." rows="6" required></textarea>
        </div>

        <!-- Cover Image Upload -->
        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Image (Optional)</label>
            <input class="form-control" type="file" id="cover_image" name="cover_image" accept="image/*">
        </div>

        <!-- Category Text Input -->
        <div class="mb-4">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control" id="category" name="category" placeholder="Enter the category (e.g., Adventure, Fantasy)" required>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Submit Story</button>
        </div>
    </form>
</section>


        <h2>Approved Stories</h2>
        
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4 story-item'>";
                    if ($row['cover_image']) {
                        echo "<img src='../uploads/" . htmlspecialchars($row['cover_image']) . "' alt='Cover Image'>";
                    }
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    echo "<p><strong>Author:</strong> " . htmlspecialchars($row['name']) . "</p>";
                    echo "<p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>";
                    echo "<button class='btn btn-primary'>Read More</button>";
                    echo "</div>";
                }
            } else {
                echo "<p>No approved stories found for your account.</p>";
            }

            // Close connection
            $stmt->close();
            $conn->close();
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
