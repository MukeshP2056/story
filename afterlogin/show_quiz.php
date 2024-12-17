<?php
// Database connection
try {
    $dsn = "mysql:host=localhost;dbname=storydb;charset=utf8mb4";
    $user = "root";
    $password = "";
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    die(json_encode(["error" => "Database connection failed: " . $e->getMessage()]));
}

// Fetch stories
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT id, Story_title FROM stories_add");
        $stories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($stories);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error fetching stories: " . $e->getMessage()]);
    }
    exit;
}

// Handle quiz creation or fetching
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'create') {
        // Save quizzes
        try {
            $storyId = $_POST['story_id'];
            $questions = $_POST['question'];
            $answers = $_POST['correct_answer'];
            $options = $_POST['options'];

            // Begin transaction
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO story_quizzes (story_id, question, correct_answer, options) 
                                   VALUES (:story_id, :question, :correct_answer, :options)");

            foreach ($questions as $i => $question) {
                $stmt->execute([
                    ':story_id' => $storyId,
                    ':question' => $question,
                    ':correct_answer' => $answers[$i],
                    ':options' => json_encode($options[$i])
                ]);
            }

            // Commit transaction
            $pdo->commit();
            echo json_encode(["message" => "Quizzes saved successfully!"]);
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo json_encode(["error" => "Error saving quizzes: " . $e->getMessage()]);
        }
    } elseif ($action === 'fetch') {
        // Fetch quizzes for a story
        try {
            $storyId = $_POST['story_id'];
            $stmt = $pdo->prepare("SELECT question, correct_answer, options FROM story_quizzes WHERE story_id = :story_id");
            $stmt->execute([':story_id' => $storyId]);
            $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($quizzes);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error fetching quizzes: " . $e->getMessage()]);
        }
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Management System</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
            margin: 0;
            padding: 0;
            color: #333;
        }

        header, footer {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        form, #quizzes {
            max-width: 600px;
            background: white;
            margin: 20px auto;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label, select, textarea, input, button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        button {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
        }

        .quiz {
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Quiz Management System</h1>
    </header>

    <main>
        <!-- Quiz Creation Form -->
        <form id="quizForm">
            <h2>Create a Quiz</h2>
            <label for="story_id">Select Story:</label>
            <select id="story_id" name="story_id" required>
                <option value="">-- Select a Story --</option>
            </select>

            <div id="questions"></div>
            <button type="button" id="addQuestion">Add Another Question</button>
            <button type="submit">Save All Quizzes</button>
        </form>

        <!-- Quiz Fetch Form -->
        <form id="fetchForm">
            <h2>View Quizzes</h2>
            <label for="fetch_story_id">Select Story:</label>
            <select id="fetch_story_id" name="story_id" required>
                <option value="">-- Select a Story --</option>
            </select>
            <button type="submit">Fetch Quizzes</button>
        </form>

        <div id="quizzes">
            <h2>Quizzes</h2>
            <div id="quizList"></div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Quiz Management | Designed with ❤️</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Fetch stories for dropdowns
            fetch('index.php')
                .then(response => response.json())
                .then(stories => {
                    const storySelect = document.getElementById('story_id');
                    const fetchStorySelect = document.getElementById('fetch_story_id');

                    stories.forEach(story => {
                        const option = document.createElement('option');
                        option.value = story.id;
                        option.textContent = story.Story_title;  // Handle special characters automatically

                        storySelect.appendChild(option.cloneNode(true));
                        fetchStorySelect.appendChild(option);
                    });
                });

            // Add initial question
            addQuestion();

            // Add question dynamically
            document.getElementById('addQuestion').addEventListener('click', addQuestion);

            // Handle quiz creation
            document.getElementById('quizForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                formData.append('action', 'create');

                fetch('index.php', { method: 'POST', body: formData })
                    .then(response => response.json())
                    .then(data => alert(data.message || data.error));
            });

            // Fetch quizzes for a story
            document.getElementById('fetchForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                formData.append('action', 'fetch');

                fetch('index.php', { method: 'POST', body: formData })
                    .then(response => response.json())
                    .then(displayQuizzes);
            });
        });

        // Add question fields
        function addQuestion() {
            const questionsDiv = document.getElementById('questions');
            const fieldset = document.createElement('fieldset');
            fieldset.innerHTML = `
                <legend>New Question</legend>
                <textarea name="question[]" placeholder="Enter the question" required></textarea>
                <input type="text" name="correct_answer[]" placeholder="Correct answer" required>
                <input type="text" name="options[][0]" placeholder="Option 1" required>
                <input type="text" name="options[][1]" placeholder="Option 2" required>
                <input type="text" name="options[][2]" placeholder="Option 3">
                <input type="text" name="options[][3]" placeholder="Option 4">
            `;
            questionsDiv.appendChild(fieldset);
        }

        // Display fetched quizzes
        function displayQuizzes(quizzes) {
            const quizList = document.getElementById('quizList');
            quizList.innerHTML = '';
            quizzes.forEach(quiz => {
                const div = document.createElement('div');
                div.className = 'quiz';
                div.innerHTML = `
                    <p><strong>Question:</strong> ${quiz.question}</p>
                    <p><strong>Correct Answer:</strong> ${quiz.correct_answer}</p>
                    <p><strong>Options:</strong> ${JSON.parse(quiz.options).join(', ')}</p>
                `;
                quizList.appendChild(div);
            });
        }
    </script>
</body>
</html>
