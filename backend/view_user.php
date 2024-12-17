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
    echo "<table border='1'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["password"] . "</td>
              </tr>";
    }
    echo "</tbody>
        </table>";
} else {
    echo "0 results found";
}

// Close connection
$conn->close();
?>
