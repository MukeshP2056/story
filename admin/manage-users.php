<?php
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

// Prepare SQL query to fetch all records from the 'register' table
$sql = "SELECT id, email, name, password FROM register";

// Execute the query
$result = $conn->query($sql);

// Check if records were found
if ($result->num_rows > 0) {
    // Output data of each row
    $contacts = [];
    while($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }
} else {
    $contacts = [];
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Data</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Global reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and General Styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            line-height: 1.6;
        }

        /* Container and Layout */
        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
            padding-left: 200px;
        }

        /* Header Styles */
        header {
            background: linear-gradient(to right, #640D5F, #B53471);
            color: white;
            padding: 15px 0;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo h1 {
            font-size: 2rem;
            font-weight: 500;
        }

        .back-link {
            background-color: #28a745;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #218838;
        }

        /* Table Styling */
        .message-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .message-table th,
        .message-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .message-table th {
            background-color: #007BFF;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
        }

        .message-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .message-table tr:hover {
            background-color: #e2e2e2;
        }

        .message-table td {
            word-wrap: break-word;
        }

        .message-table .edit-btn,
        .message-table .delete-btn {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .message-table .edit-btn {
            background-color: #FFC107;
        }

        .message-table .edit-btn:hover {
            background-color: #e0a800;
        }

        .message-table .delete-btn {
            background-color: #DC3545;
        }

        .message-table .delete-btn:hover {
            background-color: #c82333;
        }

        /* Footer Styles */
        footer {
            background: linear-gradient(to right, #640D5F, #B53471);
            color: #fff;
            padding: 15px 0;
            text-align: center;
            border-radius: 8px;
            margin-top: 40px;
        }

        footer .social-links a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        footer .social-links a:hover {
            color: #007BFF;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header .container {
                flex-direction: column;
                align-items: flex-start;
            }

            header .logo h1 {
                font-size: 1.5rem;
            }

            .message-table {
                font-size: 0.9rem;
            }

            footer {
                font-size: 0.9rem;
            }
        }
        .reg_container {
            scroll-behavior: auto ;
        }
        
    </style>
</head>
<body>

<!--sidebar section-->
<?php include('sidebar.php')?>
<!-- Header Section -->
<?php include('header.php')?>

<div class="container">

    <div class="reg_container">
    <h2>Registered Users</h2>

    <?php if (!empty($contacts)): ?>
        <table class="message-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($contact['id']); ?></td>
                        <td><?php echo htmlspecialchars($contact['email']); ?></td>
                        <td><?php echo htmlspecialchars($contact['name']); ?></td>
                        <td><?php echo htmlspecialchars($contact['password']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $contact['id']; ?>" class="edit-btn">Edit</a>
                            <a href="delete.php?id=<?php echo $contact['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No registered users found.</p>
    <?php endif; ?>
    </div>
</div>

<!-- Footer Section -->
<?php include('footer.php')?>

</body>
</html>
