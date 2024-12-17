<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";  // Database name is storydb

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$genre = $title = $story_des = $video_url = "";

// Handle form submission for adding new story
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_story'])) {
    // Sanitize and retrieve form data
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $story_des = mysqli_real_escape_string($conn, $_POST['story_des']);
    $video_url = mysqli_real_escape_string($conn, $_POST['video']);

    // Insert data into the video_add table
    $sql = "INSERT INTO video_add (genres_name, story_title, story_des, video_link) 
            VALUES ('$genre', '$title', '$story_des', '$video_url')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Story added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Handle story deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM video_add WHERE id = $delete_id";
    
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Story deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Handle story editing
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_sql = "SELECT * FROM video_add WHERE id = $edit_id";
    $edit_result = $conn->query($edit_sql);
    $story_data = $edit_result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_story'])) {
        $genre = mysqli_real_escape_string($conn, $_POST['genre']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $story_des = mysqli_real_escape_string($conn, $_POST['story_des']);
        $video_url = mysqli_real_escape_string($conn, $_POST['video']);

        // Update story in the database
        $update_sql = "UPDATE video_add SET genres_name = '$genre', story_title = '$title', 
                       story_des = '$story_des', video_link = '$video_url' WHERE id = $edit_id";
        
        if ($conn->query($update_sql) === TRUE) {
            echo "<script>alert('Story updated successfully!');</script>";
            header("Location: video_add.php");  // Redirect back to avoid resubmitting the form
            exit();
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

// Fetch genres from the genres table
$genres_sql = "SELECT DISTINCT genres_name FROM genres"; // DISTINCT to get unique genres
$genres_result = $conn->query($genres_sql);

// Fetch stories from video_add table
$stories_sql = "SELECT * FROM video_add";
$stories_result = $conn->query($stories_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Stories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Nunito', sans-serif;
      background-color: #f9f9fc;
      color: #333;
      margin: 0;
      padding: 0;
    }

    /*.site-header {
      background: linear-gradient(to right, #640D5F, #B53471);
      color: white;
      padding: 20px 0;
      text-align: center;
    }

    .site-header h1 {
      font-size: 36px;
      margin: 0;
      text-transform: uppercase;
      font-weight: 700;
    }

    .header .back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #fff;
    color: #ab00ff;
    border: none;
    padding: 10px 20px;
    font-size: 14px;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 1000; /* Ensures it appears on top of other elements */
    }

    /*.header .back-button:hover {
      background: #ab00ff;
      color: #fff;
    }*/


    .form-container {
      max-width: 800px;
      margin: 40px auto;
      padding: 30px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .form-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .form-container h2 {
      text-align: center;
      font-size: 28px;
      margin-bottom: 20px;
      font-weight: 700;
      color: #6f42c1;
    }

    .form-label {
      font-weight: 600;
    }

    .form-control, .form-select {
      border-radius: 10px;
      margin-bottom: 15px;
      padding: 10px 15px;
      border: 2px solid #e0e0e0;
    }

    .form-control:focus, .form-select:focus {
      border-color: #6f42c1;
      box-shadow: 0 0 8px rgba(111, 66, 193, 0.3);
    }

    .btn-primary {
      background-color: #6f42c1;
      border: none;
      border-radius: 10px;
      padding: 12px 25px;
      font-size: 16px;
      font-weight: 600;
      transition: background 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #5b32a6;
    }

    /*.site-footer {
      background: linear-gradient(to right, #640D5F, #B53471);
      color: white;
      text-align: center;
      padding: 20px 0;
      margin-top: 50px;
    }

    .site-footer a {
      color: #ff7eb3;
      text-decoration: none;
    }

    .site-footer a:hover {
      text-decoration: underline;
    }*/

    .table-container {
      margin: 40px auto;
      padding: 20px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    table {
      width: 100%;
      margin: 20px 0;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px 15px;
      text-align: center;
    }

    th {
      background: #6f42c1;
      color: white;
      font-weight: 700;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    td a {
      color: #6f42c1;
      text-decoration: none;
    }

    td a:hover {
      text-decoration: underline;
    }

    .btn-sm {
      padding: 8px 15px;
      border-radius: 10px;
      font-size: 14px;
    }

    .btn-warning {
      background-color: #ffa726;
      border: none;
    }

    .btn-warning:hover {
      background-color: #fb8c00;
    }

    .btn-danger {
      background-color: #e53935;
      border: none;
    }

    .btn-danger:hover {
      background-color: #d32f2f;
    }

    .back-button {
      position: absolute;
      top: 10px;
      left: 10px;
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    .back-button i {
      margin-right: 5px;
    }

    /* Action Buttons Style */
    .btn-action {
      background-color: #28a745;  /* Green */
      color: white;
      font-size: 16px;
      padding: 10px 20px;
      border-radius: 5px;
      border: none;
      width: 100%;
    }

    .btn-action:hover {
      background-color: #218838;  /* Darker green on hover */
      color: white;
    }

    .btn-warning, .btn-danger {
      font-size: 14px;
      padding: 5px 10px;
      border-radius: 5px;
      width: 100%;
    }
  </style>
</head>
<body>

  <!-- Header -->
  
    <!--siderbar section-->
    <?php include('sidebar.php')?>

    <!-- Header Section -->
    <?php include('header.php')?>
    

  <!-- Main Content -->
  <main>
    <div class="form-container">
      <?php if (isset($_GET['edit_id'])): ?>
        <form action="" method="post">
          <h2>Edit Story</h2>
          <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <select id="genre" name="genre" class="form-select" required>
              <?php
              if ($genres_result->num_rows > 0) {
                  while ($row = $genres_result->fetch_assoc()) {
                      $selected = ($row['genres_name'] == $story_data['genres_name']) ? 'selected' : '';
                      echo "<option value='" . $row['genres_name'] . "' $selected>" . $row['genres_name'] . "</option>";
                  }
              } else {
                  echo "<option>No genres available</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="title" class="form-label">Story Title</label>
            <input type="text" id="title" name="title" class="form-control" value="<?php echo $story_data['story_title']; ?>" required>
          </div>
          <div class="mb-3">
            <label for="story_des" class="form-label">Story Description</label>
            <input type="text" id="story_des" name="story_des" class="form-control" value="<?php echo $story_data['story_des']; ?>" required>
          </div>
          <div class="mb-3">
            <label for="video" class="form-label">Video URL</label>
            <input type="url" id="video" name="video" class="form-control" value="<?php echo $story_data['video_link']; ?>" required>
          </div>
          <button type="submit" name="edit_story" class="btn btn-primary">Update Story</button>
        </form>
      <?php else: ?>
        <form action="" method="post">
          <h2>Add Your Story</h2>
          <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <select id="genre" name="genre" class="form-select" required>
              <?php
              if ($genres_result->num_rows > 0) {
                  while ($row = $genres_result->fetch_assoc()) {
                      echo "<option value='" . $row['genres_name'] . "'>" . $row['genres_name'] . "</option>";
                  }
              } else {
                  echo "<option>No genres available</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="title" class="form-label">Story Title</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Enter the title" required>
          </div>
          <div class="mb-3">
            <label for="story_des" class="form-label">Story Description</label>
            <input type="text" id="story_des" name="story_des" class="form-control" placeholder="Enter story description" required>
          </div>
          <div class="mb-3">
            <label for="video" class="form-label">Video URL</label>
            <input type="url" id="video" name="video" class="form-control" placeholder="Enter video URL (e.g., YouTube, Vimeo)" required>
          </div>
          <button type="submit" name="add_story" class="btn btn-primary">Add Story</button>
        </form>
      <?php endif; ?>
    </div>

    <!-- Display Stories -->
    <div class="table-container">
      <h2>Story List</h2>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Genre</th>
            <th>Title</th>
            <th>Description</th>
            <th>Video Link</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($stories_result->num_rows > 0) {
              while ($row = $stories_result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row['id'] . "</td>";
                  echo "<td>" . $row['genres_name'] . "</td>";
                  echo "<td>" . $row['story_title'] . "</td>";
                  echo "<td>" . $row['story_des'] . "</td>";
                  echo "<td><a href='" . $row['video_link'] . "' target='_blank'>Watch Video</a></td>";
                  echo "<td>
                        <a href='?edit_id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a> 
                        <a href='?delete_id=" . $row['id'] . "' class='btn btn-danger btn-sm' 
                           onclick='return confirm(\"Are you sure you want to delete?\")'>Delete</a>
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='6'>No stories available</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Footer -->
  <!-- Footer Section -->
  <?php include('footer.php')?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


<?php
// Close the database connection
$conn->close();
?>
