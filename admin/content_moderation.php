<?php
// Database configuration
$servername = "localhost"; // Change to your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "storydb"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding/updating content
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update existing record
        $id = (int)$_POST['id'];
        $sql = "UPDATE content_moderation SET email='$email', phone='$phone', address='$address' WHERE id=$id";
    } else {
        // Add new record
        $sql = "INSERT INTO content_moderation (email, phone, address) VALUES ('$email', '$phone', '$address')";
    }

    if ($conn->query($sql) === TRUE) {
        $status = "success";
    } else {
        $status = "error";
    }

    header("Location: content_moderation.php?status=$status");
    exit();
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM content_moderation WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: content_moderation.php?status=deleted");
    } else {
        header("Location: content_moderation.php?status=delete_error");
    }
    exit();
}

// Fetch data from the database
$sql = "SELECT id, email, phone, address FROM content_moderation ORDER BY id DESC";
$result = $conn->query($sql);
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Content Moderation</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }

    .header {
      background: linear-gradient(to right, #640D5F, #B53471);
      color: white;
      padding: 20px 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .header h1 {
      margin: 0;
      font-size: 2rem;
      text-align: center;
      flex-grow: 1;
    }

    .header .back-btn {
      color: white;
      font-size: 1.2rem;
      font-weight: 500;
      text-decoration: none;
      padding: 8px 15px;
      background-color: #5a2e99;
      border-radius: 6px;
      transition: background-color 0.3s ease;
    }

    .header .back-btn:hover {
      background-color: #4a1f73;
    }

    .footer {
      background: linear-gradient(to right, #640D5F, #B53471);
      color: white;
      padding: 20px 0;
      text-align: center;
      font-size: 14px;
    }

    .form-container, .table-container {
      max-width: 900px;
      margin: 30px auto;
      padding: 25px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h4 {
      font-size: 1.5rem;
      margin-bottom: 20px;
    }

    .form-container form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 8px;
      font-weight: bold;
    }

    input, textarea {
      margin-bottom: 20px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    .submit-btn {
      background-color: #6f42c1;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .submit-btn:hover {
      background-color: #5a2e99;
    }

    .alert {
      margin-top: 15px;
    }

    .table th {
      background-color: #6f42c1;
      color: white;
    }

    .table td {
      vertical-align: middle;
    }

    .btn-action {
      padding: 8px 12px;
      border-radius: 6px;
      text-decoration: none;
      color: white;
      font-size: 0.9rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background-color: #0d6efd;
    }

    .btn-danger {
      background-color: #dc3545;
    }

    .btn-action:hover {
      opacity: 0.85;
    }

    .btn-primary:hover {
      background-color: #0a58ca;
    }

    .btn-danger:hover {
      background-color: #c82333;
    }

    .table-container table {
      margin-top: 20px;
    }

    .table-container .table td, .table-container .table th {
      padding: 15px;
      text-align: left;
    }
  </style>
</head>
<body>

  <!--siderbar section-->
  <?php include('sidebar.php')?>

  <!-- Header Section -->
  <?php include('header.php')?>
  

  <!-- Status Message -->
  <div class="form-container">
    <?php if (isset($_GET['status'])): ?>
      <?php if ($_GET['status'] == 'success'): ?>
        <div class="alert alert-success">Content added/updated successfully!</div>
      <?php elseif ($_GET['status'] == 'error'): ?>
        <div class="alert alert-danger">Failed to add/update content. Please try again.</div>
      <?php elseif ($_GET['status'] == 'deleted'): ?>
        <div class="alert alert-success">Content deleted successfully!</div>
      <?php elseif ($_GET['status'] == 'delete_error'): ?>
        <div class="alert alert-danger">Failed to delete content. Please try again.</div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Form to Add/Edit Content -->
    <form action="content_moderation.php" method="post">
      <input type="hidden" id="id" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
      
      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" 
             value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" required>

      <label for="phone">Phone Number</label>
      <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" pattern="[0-9]{10}" 
             value="<?php echo isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : ''; ?>" required>

      <label for="address">Address</label>
      <textarea id="address" name="address" placeholder="Enter your address" rows="4" required><?php 
        echo isset($_GET['address']) ? htmlspecialchars($_GET['address']) : ''; 
      ?></textarea>

      <button type="submit" class="submit-btn">Save Content</button>
    </form>
  </div>

  <!-- Table to Display Content -->
  <div class="table-container">
    <h4>Content from Database</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $row): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['address']); ?></td>
            <td>
              <a href="content_moderation.php?id=<?php echo $row['id']; ?>&email=<?php echo urlencode($row['email']); ?>&phone=<?php echo urlencode($row['phone']); ?>&address=<?php echo urlencode($row['address']); ?>" class="btn btn-primary btn-action">Edit</a>
              <a href="content_moderation.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this content?');">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Footer -->
  <!-- Footer Section -->
  <?php include('footer.php')?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

