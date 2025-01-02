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
  <title>Kahaani - Endless Tales</title>
  <link rel="icon" type="image/x-icon" href="../img/logo3.jpg">

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

    .contents {
      margin-left: 270px;
      padding: 40px;
    }
  </style>
</head>
<body>

  <!-- Sidebar Section -->
  <?php include('sidebar.php')?>

  <!-- Header Section -->
  <?php include('header.php')?>

  <!-- Status Message -->
  <div class="form-container">
    <?php if (isset($_GET['status'])): ?>
      <script>
        // Display an alert based on the status in URL
        <?php if ($_GET['status'] == 'success'): ?>
          alert('Content added/updated successfully!');
        <?php elseif ($_GET['status'] == 'error'): ?>
          alert('Failed to add/update content. Please try again.');
        <?php elseif ($_GET['status'] == 'deleted'): ?>
          alert('Content deleted successfully!');
        <?php elseif ($_GET['status'] == 'delete_error'): ?>
          alert('Failed to delete content. Please try again.');
        <?php endif; ?>
      </script>
    <?php endif; ?>

    <!-- Form to Add/Edit Content -->
    <form action="content_moderation.php" method="post">
      <input type="hidden" id="id" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" 
             value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" 
             required pattern="[a-zA-Z0-9._%+-]+@gmail\.com$" title="Only Gmail addresses are allowed">

      <label for="phone">Phone Number</label>
      <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" 
             pattern="\d{10}" value="<?php echo isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : ''; ?>" 
             required title="Phone number must be 10 digits">

      <label for="address">Address</label>
      <textarea id="address" name="address" placeholder="Enter your address" rows="4" required>
        <?php echo isset($_GET['address']) ? htmlspecialchars($_GET['address']) : ''; ?>
      </textarea>

      <button type="submit" class="submit-btn">Save Content</button>
    </form>
  </div>

  <!-- Table to Display Content -->
  <div class="contents table-container">
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
  <?php include('footer.php')?>
<script>
   document.querySelector('form').addEventListener('submit', function(event) {
        var email = document.getElementById('email');
        var phone = document.getElementById('phone');
        
        // Email validation check (for Gmail)
        var emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
        if (!emailPattern.test(email.value)) {
            alert('Please enter a valid Gmail address.');
            email.focus();
            event.preventDefault();
        }

        // Phone validation check (10 digits)
        var phonePattern = /^\d{10}$/;
        if (!phonePattern.test(phone.value)) {
            alert('Phone number must be 10 digits.');
            phone.focus();
            event.preventDefault();
        }
    });
</script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
