<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM stories_add WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Story deleted successfully.'); window.location.href='stories_add.php';</script>";
    } else {
        echo "<script>alert('Error deleting story.');</script>";
    }

    $stmt->close();
}

// Handle edit request
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $edit_sql = "SELECT * FROM stories_add WHERE id = ?";
    $stmt = $conn->prepare($edit_sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $story = $result->fetch_assoc();
}

// Handle form submission (add or edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $story_id = isset($_POST['story_id']) ? intval($_POST['story_id']) : null;
    $genres_name = htmlspecialchars($_POST['genres_name']);
    $Story_Title = htmlspecialchars($_POST['Story_Title']);
    $Author_Name = htmlspecialchars($_POST['Author_Name']);
    $Story_Content = htmlspecialchars($_POST['Story_Content']);

    // Handle file uploads
    $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
    $allowed_video_types = ['video/mp4', 'video/webm'];

    $image_path = '';
    $video_path = '';

    if (!empty($_FILES['image_path']['name'])) {
        if (in_array($_FILES['image_path']['type'], $allowed_image_types)) {
            $image_path = '../uploads/' . basename($_FILES['image_path']['name']);
            move_uploaded_file($_FILES['image_path']['tmp_name'], $image_path);
        } else {
            echo "<script>alert('Invalid image type. Please upload JPG, PNG, or GIF.');</script>";
        }
    }

    if (!empty($_FILES['video_path']['name'])) {
        if (in_array($_FILES['video_path']['type'], $allowed_video_types)) {
            $video_path = '../videos/' . basename($_FILES['video_path']['name']);
            move_uploaded_file($_FILES['video_path']['tmp_name'], $video_path);
        } else {
            echo "<script>alert('Invalid video type. Please upload MP4 or WebM.');</script>";
        }
    }

    if ($story_id) {
        // Edit existing story
        $update_sql = "UPDATE stories_add SET genres_name = ?, Story_Title = ?, Author_Name = ?, Story_Content = ?, image_path = ?, video_path = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssssssi", $genres_name, $Story_Title, $Author_Name, $Story_Content, $image_path, $video_path, $story_id);

        if ($stmt->execute()) {
            echo "<script>alert('Story updated successfully.'); window.location.href='stories_add.php';</script>";
        } else {
            echo "<script>alert('Error updating story.');</script>";
        }
    } else {
        // Add new story
        $insert_sql = "INSERT INTO stories_add (genres_name, Story_Title, Author_Name, Story_Content, image_path, video_path) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssssss", $genres_name, $Story_Title, $Author_Name, $Story_Content, $image_path, $video_path);

        if ($stmt->execute()) {
            echo "<script>alert('Story added successfully.'); window.location.href='stories_add.php';</script>";
        } else {
            echo "<script>alert('Error adding story.');</script>";
        }
    }

    $stmt->close();
}

// Fetch genres for dropdown
$genres_sql = "SELECT DISTINCT genres_name FROM genres";
$genres_result = $conn->query($genres_sql);

// Fetch stories for display
$stories_sql = "SELECT * FROM stories_add";
$stories_result = $conn->query($stories_sql);

// Fetch genres for dropdown
$genres_sql = "SELECT DISTINCT genres_name FROM genres";
$genres_result = $conn->query($genres_sql);

// Fetch stories for display
$stories_sql = "SELECT * FROM stories_add";
$stories_result = $conn->query($stories_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Stories</title>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    /* General Styling */
    body {
      font-family: 'Roboto', sans-serif;
      background: #ffff;
      margin: 0;
      padding: 0;
      color: #333;
      overflow-x: hidden;
    }

    /*.header, .footer {
      background: linear-gradient(to right, #640D5F, #B53471);
      color: #fff;
      padding: 20px;
      text-align: center;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .header h1, .footer p {
      margin: 0;
      font-weight: bold;
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
    }

    .header .back-button:hover {
      background: #ab00ff;
      color: #fff;
    }*/
    
    .container {
      max-width: 1100px;
      margin: 30px auto;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: bold;
      color: #4c2a99;
    }

    /* Form Styling */
    .story-form label {
      font-weight: bold;
      margin-bottom: 8px;
      display: block;
      color: #555;
    }

    .story-form .form-input,
    .story-form .form-select,
    .story-form .form-textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 18px;
      border: 1px solid #ddd;
      border-radius: 10px;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    .story-form .form-input:focus,
    .story-form .form-select:focus,
    .story-form .form-textarea:focus {
      border-color: #4c2a99;
      outline: none;
      box-shadow: 0 0 8px rgba(76, 42, 153, 0.5);
    }

    .story-form .submit-button {
      background: #4c2a99;
      color: #fff;
      border: none;
      padding: 12px 24px;
      font-size: 16px;
      border-radius: 25px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.3s ease;
    }

    .story-form .submit-button:hover {
      background: #361d75;
      transform: translateY(-2px);
    }

    /* Table Styling */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 25px;
    }

    table th, table td {
      padding: 18px;
      text-align: left;
      border-bottom: 1px solid #ddd;
      font-size: 16px;
    }

    table th {
      background: #4c2a99;
      color: #fff;
      border-radius: 8px 8px 0 0;
    }

    table td {
      background: #f9f9f9;
      border-radius: 8px;
    }

    table td img, table td video {
      max-width: 80px;
      height: auto;
      border-radius: 10px;
      display: block;
    }

    /* Style the action buttons container */
table .action-buttons {
  display: flex;
  gap: 12px; /* Space between buttons */
  justify-content: center;
  align-items: center;
}

/* Style for Edit Button */
table .edit-button {
  background: #3498db;
  color: #fff;
  border: none;
  padding: 10px 18px;
  border-radius: 25px;
  font-size: 14px;
  cursor: pointer;
  text-decoration: none;
  transition: background 0.3s ease, transform 0.3s ease;
}

table .edit-button:hover {
  background: #2980b9;
  transform: scale(1.05);
}

/* Style for Delete Button */
table .delete-button {
  background: #e74c3c;
  color: #fff;
  border: none;
  padding: 10px 18px;
  border-radius: 25px;
  font-size: 14px;
  cursor: pointer;
  text-decoration: none;
  transition: background 0.3s ease, transform 0.3s ease;
}

table .delete-button:hover {
  background: #c0392b;
  transform: scale(1.05);
}

  </style>
</head>
<body>

  <!--siderbar section-->
  <?php include('sidebar.php')?>

  <!-- Header Section -->
  <?php include('header.php')?>
  

  <!-- Container -->
  <div class="container">
    <h2><?php echo isset($story) ? 'Edit' : 'Add'; ?> Story</h2>
    <form class="story-form" action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="story_id" value="<?php echo isset($story) ? $story['id'] : ''; ?>">

      <label for="genres_name">Genres:</label>
      <select class="form-select" name="genres_name" required>
        <?php while ($genre = $genres_result->fetch_assoc()) { ?>
          <option value="<?php echo $genre['genres_name']; ?>" <?php echo isset($story) && $story['genres_name'] == $genre['genres_name'] ? 'selected' : ''; ?>>
            <?php echo $genre['genres_name']; ?>
          </option>
        <?php } ?>
      </select>

      <label for="Story_Title">Story Title:</label>
      <input type="text" class="form-input" name="Story_Title" value="<?php echo isset($story) ? $story['Story_Title'] : ''; ?>" required>

      <label for="Author_Name">Author Name:</label>
      <input type="text" class="form-input" name="Author_Name" value="<?php echo isset($story) ? $story['Author_Name'] : ''; ?>" required>

      <label for="Story_Content">Story Content:</label>
      <textarea class="form-textarea" name="Story_Content" rows="6" required><?php echo isset($story) ? $story['Story_Content'] : ''; ?></textarea>

      <label for="image_path">Upload Image:</label>
      <input type="file" class="form-input" name="image_path">

      <label for="video_path">Upload Video:</label>
      <input type="file" class="form-input" name="video_path">

      <button type="submit" class="submit-button"><?php echo isset($story) ? 'Update' : 'Add'; ?> Story</button>
    </form>
  </div>

  <!-- Stories Table -->
  <div class="container">
    <h2>All Stories</h2>
    <table>
      <thead>
        <tr>
          <th>Genres</th>
          <th>Title</th>
          <th>Author</th>
          <th>Content</th>
          <th>Image</th>
          <th>Video</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($story = $stories_result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $story['genres_name']; ?></td>
            <td><?php echo $story['Story_Title']; ?></td>
            <td><?php echo $story['Author_Name']; ?></td>
            <td><?php echo substr($story['Story_Content'], 0, 50) . '...'; ?></td>
            <td><img src="<?php echo $story['image_path']; ?>" alt="Story Image"></td>
            <td><video controls><source src="<?php echo $story['video_path']; ?>" type="video/mp4"></video></td>
            <td>
            <!-- Action Buttons -->
            <div class="action-buttons">
              <a href="stories_add.php?edit_id=<?php echo $story['id']; ?>" class="edit-button">Edit</a>
              <a href="stories_add.php?delete_id=<?php echo $story['id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this story?');">Delete</a>
            </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <!-- Footer Section -->
  <?php include('footer.php')?>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
