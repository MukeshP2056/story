<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Story</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
  <style>
    /* Basic styling */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f8f9fa;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }
    .header, .footer {
      width: 100%;
      background-color: #5e3b83;
      color: white;
      text-align: center;
      padding: 20px;
    }
    .header-title {
      font-size: 24px;
      font-weight: bold;
    }
    .back-link {
      position: absolute;
      top: 20px;
      right: 20px;
      color: #ddd;
      text-decoration: none;
    }
    .container {
      background-image: url('background.jpg');
      background-size: cover;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
      margin-top: 20px;
      position: relative;
      background-color: rgba(255, 255, 255, 0.8);
    }
    .story-form {
      display: flex;
      flex-direction: column;
      z-index: 2;
    }
    .form-label {
      margin-bottom: 8px;
    }
    .form-input, .form-select, .form-textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ced4da;
      border-radius: 4px;
    }
    .submit-button {
      padding: 12px;
      background-color: #5e3b83;
      color: #ffffff;
      font-weight: bold;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .submit-button:hover {
      background-color: #4a2f6c;
    }
  </style>
</head>
<body>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch genres from the database
$sql = "SELECT DISTINCT genres_name FROM genres";
$result = $conn->query($sql);
?>

  <header class="header">
    <h1 class="header-title">Add New Story</h1>
    <a href="admin.php" class="back-link">Back to Admin Page</a>
  </header>
  
  <div class="container">
    <form class="story-form" action="../backend/add_stories.php" method="post" enctype="multipart/form-data">
      <!-- Genre Dropdown -->
      <label for="genre" class="form-label">Genre</label>
      <select name="genres_name" class="form-select" required>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row['genres_name']) . '">' . htmlspecialchars($row['genres_name']) . '</option>';
            }
        } else {
            echo '<option value="">No genres available</option>';
        }
        ?>
      </select>

      <label for="title" class="form-label">Story Title</label>
      <input type="text" name="Story_Title" id="title" placeholder="Enter the title" class="form-input" required>

      <label for="image" class="form-label">Choose Image</label>
      <input type="file" name="image_path" id="image" class="form-input" accept="image/*" required>

      <label for="video" class="form-label">Choose Video</label>
      <input type="file" name="video_path" id="video" class="form-input" accept="video/*" required>

      <label for="author" class="form-label">Author Name</label>
      <input type="text" name="Author_Name" id="author" placeholder="Enter the author's name" class="form-input" required>

      <label for="content" class="form-label">Story Content</label>
      <textarea name="Story_Content" id="content" placeholder="Write your story here..." class="form-textarea" required></textarea>

      <button type="submit" class="submit-button">Add Story</button>
    </form>
  </div>

  <footer class="footer">
    <p>&copy; 2024 Your Company Name. All rights reserved.</p>
  </footer>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>
