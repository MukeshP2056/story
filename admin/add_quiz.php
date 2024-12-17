<?php
// Database connection
try {
    $dsn = "mysql:host=localhost;dbname=storydb;charset=utf8mb4";
    $user = "root";
    $password = "";
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch stories for dropdown
function getStories() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT id, Story_title FROM stories_add");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching stories: " . $e->getMessage());
    }
}

// Save multiple quizzes to the database
function saveMultipleQuizzes($quizzes, $storyId, $userId) {
    global $pdo;
    try {
        $pdo->beginTransaction(); // Start a transaction
        $stmt = $pdo->prepare("INSERT INTO story_quizzes (story_id, user_id, question, correct_answer, options) 
                               VALUES (:story_id, :user_id, :question, :correct_answer, :options)");
        foreach ($quizzes as $quiz) {
            $stmt->execute([
                ':story_id' => $storyId,
                ':user_id' => $userId,
                ':question' => $quiz['question'],
                ':correct_answer' => $quiz['correct_answer'],
                ':options' => json_encode($quiz['options']) // Encode options to JSON
            ]);
        }
        $pdo->commit(); // Commit the transaction
        return "All quizzes added successfully!";
    } catch (PDOException $e) {
        $pdo->rollBack(); // Rollback on failure
        return "Error adding quizzes: " . $e->getMessage();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $storyId = $_POST['story_id'];
    $userId = $_POST['user_id'];
    $quizzes = [];

    for ($i = 0; $i < 10; $i++) {
        if (!empty($_POST['question'][$i]) && !empty($_POST['correct_answer'][$i])) {
            $quizzes[] = [
                'question' => $_POST['question'][$i],
                'correct_answer' => $_POST['correct_answer'][$i],
                'options' => array_filter($_POST['options'][$i]) // Filter empty options
            ];
        }
    }

    // Save the quizzes and display the result
    $result = saveMultipleQuizzes($quizzes, $storyId, $userId);
    echo $result;
    exit;
}

// Fetch stories for form rendering
$stories = getStories();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <style>
        /* General styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
            color: #333;
        }

        /* Header styling 
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(to right, #640D5F, #B53471);
            color: white;
            padding: 30px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
            letter-spacing: 1px;
            flex: 1;
            text-align: center;
        }

        header .back-btn {
            text-decoration: none;
            color: white;
            font-size: 1.2rem;
            background-color: #4CAF50;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        header .back-btn:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }*/

        /* Footer styling 
        footer {
            background: linear-gradient(to right, #640D5F, #B53471);
            color: white;
            text-align: center;
            padding: 15px;
            position: relative;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.1);
        }

        footer p {
            margin: 0;
            font-size: 1rem;
        }

        footer a {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }*/

        /* Main content styling */
        h1 {
            text-align: center;
            margin-top: 20px;
            color: #fff;
        }

        form {
            max-width: 600px;
            background: white;
            margin: 20px auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        textarea, select, input {
            width: calc(100% - 20px);
            margin: 10px 0 20px 0;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        textarea:focus, select:focus, input:focus {
            border-color: #6a11cb;
            outline: none;
            box-shadow: 0 0 8px rgba(106, 17, 203, 0.5);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        button {
            width: 100%;
            padding: 14px;
            font-size: 1.1rem;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        button:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            form {
                width: 90%;
                padding: 20px;
            }

            header h1 {
                font-size: 1.8rem;
            }

            header .back-btn {
                font-size: 1rem;
            }

            footer p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    
    <!--siderbar section-->
    <?php include('sidebar.php')?>

    <!-- Header Section -->
    <?php include('header.php')?>    

    <main>
        <h1 style=" color: #6a11cb;">Create a Quiz</h1>
        <form method="POST">
    <label for="story_id">Select Story:</label>
    <select id="story_id" name="story_id" required>
        <option value="">-- Select a Story --</option>
        <?php foreach ($stories as $story): ?>
            <option value="<?= htmlspecialchars($story['id']) ?>"><?= htmlspecialchars($story['Story_title']) ?></option>
        <?php endforeach; ?>
    </select>

    <!-- Repeat this section for 10 questions -->
    <?php for ($i = 0; $i < 10; $i++): ?>
        <fieldset style="margin-bottom: 20px; border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
            <legend>Question <?= $i + 1 ?></legend>
            <label for="question_<?= $i ?>">Quiz Question:</label>
            <textarea id="question_<?= $i ?>" name="question[<?= $i ?>]" rows="3"></textarea>

            <label for="correct_answer_<?= $i ?>">Correct Answer:</label>
            <input type="text" id="correct_answer_<?= $i ?>" name="correct_answer[<?= $i ?>]">

            <label>Options:</label>
            <input type="text" name="options[<?= $i ?>][]" placeholder="Option 1">
            <input type="text" name="options[<?= $i ?>][]" placeholder="Option 2">
            <input type="text" name="options[<?= $i ?>][]" placeholder="Option 3">
            <input type="text" name="options[<?= $i ?>][]" placeholder="Option 4">
        </fieldset>
    <?php endfor; ?>

    <!-- Hidden field for user ID -->
    <input type="hidden" name="user_id" value="1">

    <button type="submit">Save All Quizzes</button>
</form>

    </main>
   <!-- Footer Section -->
   <?php include('footer.php')?>
    
</body>
</html>