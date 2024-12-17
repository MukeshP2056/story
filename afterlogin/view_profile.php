<?php
    // Start the session and check if the user is logged in
    session_start();

    // Include the database connection
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

    // Check if the user is logged in by checking session variables
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION["user_id"];

        // Query to fetch user details from the database
        $sql = "SELECT * FROM register WHERE id = '$user_id'";
        $result = $conn->query($sql);

        // Check if the query returns a result
        if ($result->num_rows > 0) {
            // Fetch user data
            $user_data = $result->fetch_assoc();
        } else {
            // If no user found, handle accordingly
            echo "No user data found.";
        }
    } else {
        // If user is not logged in, redirect to login page
        header("Location: ../login.php");
        exit();
    }

    // Close the database connection
    $conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;600;700&display=swap" rel="stylesheet">

    
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


    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f7f7f7;
        }

        .profile-section {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-header img {
            max-width: 180px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .table th {
            width: 150px;
            font-weight: bold;
        }

        .table td {
            font-weight: 400;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .modal-content {
            border-radius: 8px;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-body input {
            margin-bottom: 10px;
        }

        .modal-body label {
            font-weight: 600;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }

        .modal-footer .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .modal-footer .btn-primary:hover {
            background-color: #218838;
            border-color: #218838;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
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

    <div class="container my-5">
        <h2 class="text-center mb-4">View Profile</h2>

        <!-- Profile Section -->
        <div class="profile-section">
            <div class="profile-header">
                <img src="<?php echo isset($user_data['profile_image']) ? htmlspecialchars($user_data['profile_image']) : 'img/default-profile.png'; ?>" alt="Profile Picture" class="img-fluid rounded-circle">
                <h4><?php echo isset($user_data['name']) ? htmlspecialchars($user_data['name']) : 'N/A'; ?></h4>
                <p class="text-muted"><?php echo isset($user_data['email']) ? htmlspecialchars($user_data['email']) : 'N/A'; ?></p>
            </div>

            <table class="table mt-4">
                <tr>
                    <th>Email:</th>
                    <td><?php echo isset($user_data['email']) ? htmlspecialchars($user_data['email']) : 'N/A'; ?></td>
                </tr>
                <tr>
                    <th>Name:</th>
                    <td><?php echo isset($user_data['name']) ? htmlspecialchars($user_data['name']) : 'N/A'; ?></td>
                </tr>
                <tr>
                    <th>Password:</th>
                    <td><?php echo isset($user_data['password']) ? '********' : 'N/A'; ?></td>
                </tr>
                <tr>
                    <th>User Type:</th>
                    <td><?php echo isset($user_data['usertype']) ? htmlspecialchars($user_data['usertype']) : 'N/A'; ?></td>
                </tr>
            </table>

            <button class="btn btn-primary" data-toggle="modal" data-target="#edit-profile">Edit Profile</button>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="edit-profile" tabindex="-1" role="dialog" aria-labelledby="editProfileLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileLabel" style = "color:#f7f7f7">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="../backend/vprofile.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Full Name:</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email_id">Email:</label>
                            <input type="email" class="form-control" name="email_id" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password" value="<?php echo htmlspecialchars($user_data['password']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="usertype">User Type:</label>
                            <input type="text" class="form-control" name="usertype" value="<?php echo htmlspecialchars($user_data['usertype']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="profile_picture">Profile Picture:</label>
                            <input type="file" class="form-control" name="profile_picture">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="save_changes" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>

</html>
