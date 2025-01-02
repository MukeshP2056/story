<?php
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "storydb";
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'] ?? 0; // Assuming user is logged in

// Function to fetch unlocked locations
function fetchUnlockedLocations($conn, $user_id) {
    $sql = "SELECT * FROM map_locations WHERE unlocked = 1 ORDER BY id";
    $result = $conn->query($sql);

    $locations = [];
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
    return $locations;
}

// Function to unlock location based on story completion
function unlockLocation($conn, $user_id, $story_id) {
    $sql = "UPDATE map_locations SET unlocked = 1 WHERE required_story_id = ? AND unlocked = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $story_id);
    $stmt->execute();
    
    // Add to user progress
    $progress_sql = "INSERT INTO user_progress (user_id, location_id, progress_percentage) VALUES (?, ?, 100)";
    $progress_stmt = $conn->prepare($progress_sql);
    $progress_stmt->bind_param("ii", $user_id, $stmt->insert_id);
    $progress_stmt->execute();

    return "Congratulations! You've unlocked a new location!";
}

// Handle location unlock via story completion (simulating)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['story_id'])) {
    $story_id = $_POST['story_id'];
    echo unlockLocation($conn, $user_id, $story_id);
    exit;  // End script after processing
}

// Fetch unlocked locations for the user
$locations = fetchUnlockedLocations($conn, $user_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Story Map</title>
    <link rel="icon" type="image/x-icon" href="../img/logo3.jpg">

    <style>
        .map-location {
            width: 150px;
            height: 150px;
            display: inline-block;
            background-size: cover;
            position: relative;
            cursor: pointer;
            text-align: center;
            color: white;
            font-weight: bold;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .map-location h3 {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: #fff;
        }

        #interactive-map {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
</head>
<body>

<h1>Interactive Story Map</h1>

<!-- Map locations will be displayed here -->
<div id="interactive-map">
    <?php if (count($locations) > 0): ?>
        <?php foreach ($locations as $location): ?>
            <div class="map-location" style="background-image: url(<?php echo $location['image_url']; ?>);" data-id="<?php echo $location['id']; ?>">
                <h3><?php echo htmlspecialchars($location['name']); ?></h3>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No locations unlocked yet. Complete stories to unlock new places!</p>
    <?php endif; ?>
</div>

<!-- Example of story completion form to unlock locations -->
<h2>Complete a Story to Unlock Locations</h2>
<form method="POST" action="">
    <input type="hidden" name="story_id" value="1"> <!-- Simulating a story ID -->
    <button type="submit">Complete Story 1 and Unlock Location</button>
</form>

<script>
    // Redirect to story location page when a location is clicked
    document.querySelectorAll('.map-location').forEach(location => {
        location.addEventListener('click', function() {
            const locationId = this.getAttribute('data-id');
            alert("You clicked on location ID: " + locationId);  // For now, just showing an alert
        });
    });
</script>

</body>
</html>

<?php
$conn->close();
?>
