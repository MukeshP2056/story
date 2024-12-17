<?php
// Database connection setup
$servername = "localhost"; // Your database server (localhost if running locally)
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "storydb"; // The database name

// Create connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Fetch data from the contact_page table
$sql = "SELECT * FROM contact_page";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Check if any records are found
if ($stmt->rowCount() > 0) {
    // Fetch all rows as an associative array
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $contacts = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages</title>
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        header {
            background: linear-gradient(to right, #640D5F, #B53471); /* Gradient from purple to blue */
            color: white;
            padding: 30px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            font-size: 2.5rem;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Subtle text shadow for emphasis */
        }

        .back-link {
            background-color: #FF5722;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #E64A19;
        }

        .message-container {
            max-width: 1200px;
            margin: 30px auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .message-card {
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #ddd;
        }

        .message-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .message-card h4 {
            font-size: 1.3rem;
            color: #8e2de2; /* Purple color */
            margin-bottom: 15px;
        }

        .message-card p {
            font-size: 1rem;
            color: #555;
            margin: 5px 0;
        }

        .message-card .message-content {
            color: #333;
            font-size: 0.95rem;
            line-height: 1.5;
            border-top: 1px solid #eee;
            padding-top: 10px;
            margin-top: 10px;
        }

        footer {
            background: linear-gradient(to right, #640D5F, #B53471);
             /*background: linear-gradient(135deg, #1f4037, #99f2c8); /* Gradient from teal to light green */
            color: white;
            padding: 30px 0;
            text-align: center;
        }

        footer .social-links {
            margin-top: 20px;
        }

        footer .social-links a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }

        footer .social-links a:hover {
            color: #FF5722; /* Match hover color with back-link */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .message-container {
                grid-template-columns: 1fr;
                padding: 0 20px;
            }

            .message-card h4 {
                font-size: 1.2rem;
            }

            .message-card p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<!-- Header Section -->
<header>
    <div class="container">
        <div class="logo">
            <h1>Contact Review Page</h1>
        </div>
        <a href="admin.php" class="back-link">Back to Admin Page</a>
    </div>
</header>

<!-- Contact Messages Section -->
<div class="container">
    <h2>Contact Messages</h2>

    <div class="message-container">
        <?php if (!empty($contacts)): ?>
            <?php foreach ($contacts as $contact): ?>
                <div class="message-card">
                    <h4><?php echo htmlspecialchars($contact['name']); ?></h4>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
                    <p><strong>Subject:</strong> <?php echo htmlspecialchars($contact['subject']); ?></p>
                    <div class="message-content">
                        <strong>Message:</strong>
                        <p><?php echo nl2br(htmlspecialchars($contact['content'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No contact messages found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Footer Section -->
<footer>
    <div class="container">
        <p>&copy; 2024 My Website. All Rights Reserved.</p>
        
    </div>
</footer>

<!-- Bootstrap JS, Popper.js, jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

</body>
</html>
