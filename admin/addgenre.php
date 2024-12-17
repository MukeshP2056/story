<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<script>alert('Connection failed: " . $conn->connect_error . "');</script>");
}

// Handle deletion request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM genres WHERE id = $delete_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Genre deleted successfully.');
        window.location.href = 'addgenre.php'; // Replace with your file name
        </script>";
    } else {
        echo "<script>alert('Error deleting genre: " . $conn->error . "');</script>";
    }
}

// Fetch data from genres table
$sql = "SELECT id, genres_name, image_path FROM genres";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
   /* General Styling */
body {
  font-family: 'Poppins', sans-serif;
  background-color: #f9f9fb;
  color: #333;
  margin: 0;
  padding: 0;
}

header, footer {
  background: linear-gradient(to right, #320A2C, #6A1B47);
  color: #fff;
  padding: 15px;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  position: fixed;
  width: calc(100% - 250px);
  left: 250px;
  z-index: 1000;
}

header {
  top: 0;
}

footer {
  background: linear-gradient(to left, #1A0F18, #3D1E31);
  bottom: 0;
}

header .header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

header h1 {
  font-size: 28px;
  font-weight: 700;
}

.btn-light {
  background: #fff;
  color: #6a11cb;
  border: 1px solid #2575fc;
  font-weight: 600;
  padding: 6px 14px;
  border-radius: 8px;
  transition: all 0.3s;
}

.btn-light:hover {
  background: linear-gradient(to right, #640D5F, #0D0D5F);
  color: #fff;
  border: 1px solid #fff;
}

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

main {
  margin-left: 270px;
  margin-top: 70px; /* Space for fixed header */
  margin-bottom: 70px; /* Space for fixed footer */
  padding: 40px 20px;
  /* overflow-y: auto; */
  height: calc(100vh - 140px);
  box-sizing: border-box;
}

.form-container, .genres-container {
  background: #fff;
  border-radius: 12px;
  padding: 30px;
  margin-bottom: 40px;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.form-container h2, .genres-container h2 {
  font-size: 24px;
  color: #6a11cb;
  margin-bottom: 20px;
  text-align: center;
}

.form-label {
  font-weight: 600;
  color: #555;
}

.btn-primary {
  background: linear-gradient(to right, #320A2C, #6A1B47);
  border: none;
  font-size: 16px;
  font-weight: 600;
  padding: 10px;
  border-radius: 8px;
  transition: all 0.3s;
}

.btn-primary:hover {
  background: linear-gradient(to right, #1A0F18, #3D1E31);
  transform: translateY(-2px);
}

.table {
  border-collapse: separate;
  border-spacing: 0 12px;
  width: 100%;
}

.table th {
  background: linear-gradient(to right, #320A2C, #6A1B47);
  color: #fff;
  border: none;
  text-align: center;
}

.table td {
  background: #fff;
  border: none;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  text-align: center;
  vertical-align: middle;
}

.table tbody tr:hover td {
  background: #f1f4f9;
}

.genre-image {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 8px;
  border: 1px solid #eaeaea;
}

.delete-button {
  background: linear-gradient(to right, #320A2C, #6A1B47);
  border: none;
  color: #fff;
  padding: 8px 14px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
  transition: all 0.3s;
}

.delete-button:hover {
  background: linear-gradient(to right, #1A0F18, #3D1E31);
  transform: translateY(-2px);
}

.add {
  height: auto;
    width: 80%;
    margin-left: 17%;
    /* margin-top: 5%; */
    overflow: hidden;}

.genres-container {
  margin-top: -200px;
    width: 70%;
    margin-left: 22%;}

  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="header-container">
      <h1>Genres</h1>
      <a href="admin.php" class="btn btn-light">Back</a>
    </div>
  </header>
  <div style="display: flex;">
  <?php include('sidebar.php')?>  

<!-- Main Content -->
<main class="container">

  <!-- Add New Genre Form -->
  <div class="form-container add">
    <h2>Add New Genre</h2>
    <form action="../backend/add_genres.php" method="POST" enctype="multipart/form-data">
      
      <div class="mb-3">
        <label for="genre" class="form-label">Genre Name</label>
        <input type="text" name="genres_name" id="genre" class="form-control" placeholder="Enter Genre Name" required>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Choose Image</label>
        <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Add Genre</button>
    </form>
  </div>

  
</main>

  </div>
  <!-- Genre List -->
  <div class="genres-container">
    <h2>Genres List</h2>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Image</th>
          <th>Genre Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td><img src="' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['genres_name']) . '" class="genre-image"></td>';
                echo '<td>' . htmlspecialchars($row['genres_name']) . '</td>';
                echo '<td><a href="?delete_id=' . $row['id'] . '" class="btn delete-button" onclick="return confirm(\'Are you sure you want to delete this genre?\');">Delete</a></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="3">No genres available.</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
  <!-- Footer -->
  <footer>
    <p>&copy; 2024 Story Admin. All rights reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
