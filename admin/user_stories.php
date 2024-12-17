<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "storydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Message to display in popup

// Handle approve/reject actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['story_id']) && isset($_POST['action'])) {
        $story_id = intval($_POST['story_id']);
        $action = $_POST['action'] === 'approve' ? 'approved' : 'rejected';

        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare("UPDATE story SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $action, $story_id);

        if ($stmt->execute()) {
            $message = ucfirst($action) . " successfully.";
        } else {
            $message = "Error updating status: " . $conn->error;
        }

        $stmt->close();
    }
}

// Fetch pending stories
$sql_pending = "SELECT s.*, u.name  
                FROM story s 
                JOIN register u ON s.user_id = u.id 
                WHERE s.status = 'pending'";
$result_pending = $conn->query($sql_pending);

// Fetch all stories
$sql_all = "SELECT * FROM story";
$result_all = $conn->query($sql_all);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stories</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #89f7fe, #66a6ff);
            color: #333;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(to right, #640D5F, #B53471);
            color: white;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        header h1 {
            margin: 0;
            font-size: 1.8rem;
            text-align: center;
            flex: 1;
        }
        header .back-btn {
            text-decoration: none;
            color: white;
            font-size: 1rem;
            background-color: #28a745;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s;
        }
        header .back-btn:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }
        .card {
            border-radius: 10px;
            overflow: hidden;
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            padding: 15px;
            background: #fff;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0 0 10px;
        }
        .card-text {
            font-size: 0.95rem;
            margin: 0 0 10px;
        }
    </style>
    <script>
        // Function to show alert message if a message is set
        function showPopup(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body onload="showPopup('<?= htmlspecialchars($message); ?>')">
    <header>
        <a href="admin.php" class="back-btn">← Back</a>
        <h1>Creative Writing Challenge</h1>
    </header>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Pending Stories</h2>
        <div class="row">
            <?php if ($result_pending && $result_pending->num_rows > 0): ?>
                <?php while ($row = $result_pending->fetch_assoc()): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <?php if ($row['cover_image']): ?>
                                <img src="<?= htmlspecialchars($row['cover_image']); ?>" class="card-img-top" alt="Cover Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text"><strong>Author:</strong> <?= htmlspecialchars($row['name']); ?></p>
                                <p class="card-text"><strong>Category:</strong> <?= htmlspecialchars($row['category']); ?></p>
                                <p class="card-text"><?= nl2br(htmlspecialchars(substr($row['content'], 0, 200))); ?>...</p>
                                <form method="POST" class="d-flex">
                                    <input type="hidden" name="story_id" value="<?= $row['id']; ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-success mr-2">Approve</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center w-100">No pending stories found.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">All Stories</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Cover Image</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_all && $result_all->num_rows > 0): ?>
                        <?php while ($row = $result_all->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']); ?></td>
                                <td><?= htmlspecialchars($row['user_id']); ?></td>
                                <td><?= htmlspecialchars($row['title']); ?></td>
                                <td><?= htmlspecialchars(substr($row['content'], 0, 100)); ?>...</td>
                                <td>
                                    <?php if (!empty($row['cover_image'])): ?>
                                        <img src="<?= htmlspecialchars($row['cover_image']); ?>" alt="Cover" class="img-thumbnail" style="max-width: 100px;">
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['category']); ?></td>
                                <td><?= htmlspecialchars($row['created_at']); ?></td>
                                <td><?= htmlspecialchars($row['status']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center">No stories found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Creative Writing Challenge</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>
