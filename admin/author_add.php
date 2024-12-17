<?php
// Database connection details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for the form
$edit_mode = false;
$author_name = $story_title = $story_des = $story_content = "";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete record from the database
    $sql = "DELETE FROM author_add WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully!'); window.location.href = 'author_add.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle edit request
if (isset($_GET['edit_id'])) {
    $edit_mode = true;
    $edit_id = $_GET['edit_id'];

    // Fetch the data for the record to edit
    $sql = "SELECT * FROM author_add WHERE id = $edit_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $author_name = $row['author_name'];
        $story_title = $row['story_title'];
        $story_des = $row['story_des'];
        $story_content = $row['story_content'];
    } else {
        echo "<script>alert('Record not found!'); window.location.href = 'author_add.php';</script>";
    }
}

// Handle form submission for both add and update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author_name = $_POST['author_name'];
    $story_title = $_POST['story_title'];
    $story_des = $conn->real_escape_string($_POST['story_des']);
    $story_content =$conn->real_escape_string( $_POST['story_content']); 

    if (isset($_POST['edit_id'])) {
        // Update existing record
        $edit_id = $_POST['edit_id'];
        $sql = "UPDATE author_add SET 
                    author_name = '$author_name', 
                    story_title = '$story_title', 
                    story_des = '$story_des', 
                    story_content = '$story_content' 
                WHERE id = $edit_id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record updated successfully!'); window.location.href = 'author_add.php';</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Add a new record
        $sql = "INSERT INTO author_add (author_name, story_title, story_des, story_content) 
                VALUES ('$author_name', '$story_title', '$story_des', '$story_content')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record added successfully!'); window.location.href = 'author_add.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch data from the database
$sql = "SELECT * FROM author_add";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        /*header {
            background: linear-gradient(to right, #640D5F, #B53471);
            color: white;
            padding: 20px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        header h1 {
            margin: 0;
        }
        header .back-button {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            color: #4c2a99;
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
        }*/
        .container {
            max-width: 1170px;
            margin: 40px auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #4c2a99;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            background: #4c2a99;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #361d75;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #4c2a99;
            color: white;
        }
        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .edit-button, .delete-button {
            padding: 8px 12px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }
        .edit-button {
            background: #3498db;
        }
        .edit-button:hover {
            background: #217dbb;
        }
        .delete-button {
            background: #e74c3c;
        }
        .delete-button:hover {
            background: #c0392b;
        }
        /*footer {
            text-align: center;
            padding: 20px;
            background: linear-gradient(to right, #640D5F, #B53471);
            color: white;
            margin-top: 30px;
        }*/
        
    </style>
</head>
<body>

<!--siderbar section-->
<?php include('sidebar.php')?>

<!-- Header Section -->
<?php include('header.php')?>

<div class="container">
<div class="form-container add">
    <h2><?php echo $edit_mode ? "Edit Author Story" : "Add New Author"; ?></h2>
    <form action="author_add.php" method="POST">
        <input type="hidden" name="edit_id" value="<?php echo $edit_mode ? $edit_id : ''; ?>">
        
        <label for="author_name">Author's Name</label>
        <input type="text" id="author_name" name="author_name" value="<?php echo htmlspecialchars($author_name); ?>" required>
        
        <label for="story_title">Story Title</label>
        <input type="text" id="story_title" name="story_title" value="<?php echo htmlspecialchars($story_title); ?>" required>
        
        <label for="story_des">Story Description</label>
        <input type="text" id="story_des" name="story_des" value="<?php echo htmlspecialchars($story_des); ?>" required>
        
        <label for="story_content">Story Content</label>
        <textarea id="story_content" name="story_content" rows="6" required><?php echo htmlspecialchars($story_content); ?></textarea>
        
        <button type="submit"><?php echo $edit_mode ? "Update Story" : "Add Story"; ?></button>
    </form>
</div>

<div class="container">
    <h2>Author Stories</h2>
    <table>
        <thead>
            <tr>
                <th>Author Name</th>
                <th>Story Title</th>
                <th>Story Description</th>
                <th>Story Content</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['author_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['story_title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['story_des']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['story_content']) . "</td>";
                    echo "<td class='actions'>
                            <a href='author_add.php?edit_id=" . $row['id'] . "' class='edit-button'>
                                <i class='fas fa-edit'></i> Edit
                            </a>
                            <a href='author_add.php?delete_id=" . $row['id'] . "' class='delete-button' onclick='return confirm(\"Are you sure?\")'>
                                <i class='fas fa-trash-alt'></i> Delete
                            </a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No stories found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Footer Section -->
<?php include('footer.php')?>

</body>
</html>

