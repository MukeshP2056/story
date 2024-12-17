<?php

// Database connection details
$host = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "storydb";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);
// Assuming you have already created the database connection
// Query to count total genres in the genre table

//addgenre
$sql = "SELECT COUNT(*) AS genres_name FROM genres";
$result = $conn->query($sql);

// Fetch the result
$totalGenres = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalGenres = $row['genres_name'];
}

//stories_add
$sql = "SELECT COUNT(*) AS total_stories FROM stories_add";
$result = $conn->query($sql);

// Fetch the result
$totalStories = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalStories = $row['total_stories'];
}

//author_add
$sql = "SELECT COUNT(*) AS total_authors FROM author_add";
$result = $conn->query($sql);

// Fetch the result
$totalAuthors = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalAuthors = $row['total_authors'];
}

//video_add
$sql = "SELECT COUNT(*) AS total_active_videos FROM video_add";
$result = $conn->query($sql);

// Fetch the result
$totalActiveVideos = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalActiveVideos = $row['total_active_videos'];
}

// Query to count approved stories
$sql_approved_stories = "SELECT COUNT(*) AS totalApproved FROM story WHERE status = 'approved'";
$result_approved_stories = $conn->query($sql_approved_stories);

// Fetch the total count of approved stories
$totalApprovedStories = 0;
if ($result_approved_stories && $result_approved_stories->num_rows > 0) {
    $row = $result_approved_stories->fetch_assoc();
    $totalApprovedStories = $row['totalApproved'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Minne</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Root Variables for Colors */
        :root {
            --primary-color: #1e272e;
            --secondary-color: #27ae60;
            --accent-color: #e84118;
            --gradient-primary: linear-gradient(to right, #640D5F, #B53471);
            --gradient-secondary: linear-gradient(to right, #640D5F, #FF6EC7);
            --background-color: #f1f2f6;
            --card-bg: #ffffff;
            --card-shadow: rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
  width: 250px;
  background: linear-gradient(to right, #1A0F18, #3D1E31);
   color: white;
  height: 100vh;
  padding: 20px;
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
}

.sidebar h2 {
  font-size: 22px;
  margin-bottom: 30px;
  text-align: center;
  font-weight: 700;
}

.sidebar a {
  display: block;
  color: white;
  text-decoration: none;
  padding: 10px 15px;
  margin-bottom: 10px;
  border-radius: 8px;
  transition: background 0.3s;
  font-size: 16px;
}

.sidebar a:hover {
  background: #444;
}

.sidebar a.active {
  background: #333;
  font-weight: 700;
}

        /* Header */
        .header {
            background: linear-gradient(to right, #320A2C, #6A1B47);

            color: white;
            padding: 20px 30px;
            margin-left: 250px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 28px;
        }

        .header button {
            background: var(--gradient-secondary);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .header button:hover {
            background: linear-gradient(to right, #640D5F, #0D0D5F);
            color: #fff;
            border: 1px solid #fff;
        }

        /* Main Content */
        .content {
            margin-left: 270px;
            padding: 40px;
        }

        /* Cards */
        .dashboard-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 15px var(--card-shadow);
            transition: all 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .dashboard-card h3 {
            font-size: 22px;
            color: var(--primary-color);
        }

        .dashboard-card p {
            font-size: 18px;
            color: #7d7d7d;
        }

        /* Section Headers */
        section {
            margin-bottom: 50px;
        }

        section h2 {
            color: var(--primary-color);
            border-left: 5px solid var(--secondary-color);
            padding-left: 10px;
            margin-bottom: 30px;
        }

        /* Footer */
        footer {
            background: linear-gradient(to left, #1A0F18, #3D1E31);

            color: white;
            text-align: center;
            padding: 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 220px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 180px;
            }

            .content {
                margin-left: 190px;
            }

            .header h1 {
                font-size: 22px;
            }

            .dashboard-card h3 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
  <?php include('sidebar.php')?>  

    <!-- Header -->
    <div class="header">
        <h1>Welcome, Admin!</h1>
        <button onclick="window.location.href='../login.php'">
            <i class="fas fa-sign-out-alt"></i> Log Out
        </button>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Dashboard Overview -->
        <section id="overview">
            <h2>Dashboard Overview</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="dashboard-card">
                        <h3><i class="fas fa-book-open"></i> Total Genres</h3>
                        <p><?php echo $totalGenres; ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card">
                        <h3><i class="fas fa-users"></i> Total Stories</h3>
                        <p><?php echo $totalStories; ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card">
                        <h3><i class="fas fa-user"></i> Authors</h3>
                        <p><?php echo $totalAuthors; ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card">
                        <h3><i class="fas fa-video"></i> Active Videos</h3>
                        <p><?php echo $totalActiveVideos; ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card">
                        <h3><i class="fas fa-book"></i> Approved Stories</h3>
                        <p><?php echo $totalApprovedStories; ?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 StoryDB. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
