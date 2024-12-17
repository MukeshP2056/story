<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storydb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$story_id = $_GET['story_id']; // Get story ID from the query string
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM story_quizzes WHERE story_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $story_id);
$stmt->execute();
$result = $stmt->get_result();

$quizzes = [];
while ($row = $result->fetch_assoc()) {
    $quizzes[] = $row;
}

$stmt->close();

// Handle score saving via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = $_POST['score'];
    $total_questions = $_POST['total_questions'];

    $save_score_sql = "INSERT INTO scores (user_id, story_id, score, total_questions) VALUES (?, ?, ?, ?)";
    $save_stmt = $conn->prepare($save_score_sql);
    $save_stmt->bind_param("iiii", $user_id, $story_id, $score, $total_questions);

    if ($save_stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $save_stmt->error]);
    }
    $save_stmt->close();
    $conn->close();
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Quiz</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../css/plyr.css" type="text/css">
    <link rel="stylesheet" href="../css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRFO3M+6s5y6rcfLPhrhR7H7H17yAKxVEJv0C9g8Z" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Arial', sans-serif;
    /* background-color: #f4f4f9; */
    /* color: #333; */
    /* margin: 0; */
    /* padding: 0; */
    justify-content: center;
    align-items: center;
    /* min-height: 100vh; */
    background-image: url(../img/quizbg.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    /* width: 100%; */
    backdrop-filter: blur(1px);
        }
        .header__right a {
    color: #fff;
    font-size: 1rem;
    padding: 10px;
    text-decoration: none;
    display: flex
;
    gap: 10px;
    align-items: center;    transition: color 0.3s ease;
}

.header__right a:hover {
    color: #007bff;
}

.header__right{
    display:flex;
    padding:9px 0px 15px;
}
        .container {
            /* max-width: 800px; */
            width: 100%;
            /* padding: 20px; */
            /* background-color: white; */
            border-radius: 8px;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
            margin: 0 auto;
            /* background: rgba(255, 255, 255, 0.2); Semi-transparent white background */

        }

        h2 {
            text-align: center;
            color: #fff;
            font-size: 2rem;
            margin-bottom: 20px;
            text-transform:uppercase;
        }

        .quiz-container {
            display: none;
            /* background-color: #fff; */
            /* border: 1px solid #ddd; */
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
        }

        .quiz-container.active {
            display: block;
        }

        .question {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #fff;
        }
.options{
    width: 100%;
    display: flex
;
    flex-direction: column;
}
        .options button {
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-bottom: 10px;
        }

        .options button:hover {
            background-color: #45a049;
        }

        .options button:active {
            background-color: #388e3c;
        }

        .score {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 20px;
            color: #4CAF50;
        }
        .question-section{
            width: 50%;
            margin:0 auto;
        }
        body {
    font-family: 'Arial', sans-serif;
    background-image: url(../img/quizbg.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    /* display: flex; */
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

.question-section {
    width: 90%; /* Default width for all devices */
    max-width: 600px; /* Limit width for larger screens */
    margin: 20px auto;
    padding: 20px;
    background: rgba(255, 255, 255, 0.2); /* Semi-transparent for glass effect */
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

h2 {
    text-align: center;
    color: #fff;
    font-size: 2rem;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.quiz-container {
    display: none;
    padding: 15px;
}

.quiz-container.active {
    display: block;
}

.question {
    font-size: 1.4rem;
    font-weight: bold;
    margin-bottom: 15px;
    color: #fff;
    text-align: center;
}

.options button {
    padding: 12px 20px;
    background-color: #0d6efd;
    color: white;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
    margin-bottom: 10px;
    text-align: center;
    width: 100%;
}

.options button:hover {
    background-color: #0056b3;
}

.options button:active {
    background-color: #004080;
}

.score {
    text-align: center;
    font-size: 1.5rem;
    font-weight: bold;
    margin-top: 20px;
    color: #4CAF50;
}

#next-btn {
    display: none;
    margin-top: 20px;
    background: #0d6efd;
    color: #fff;
    padding: 10px 20px;
    border-radius: 10px;
    border: 1px solid transparent;
    margin-left: auto;
    margin-right: auto;
    white-space: nowrap;
    width: 100%;
    max-width: 300px;
    font-size: 1rem;
}

@media (max-width: 768px) {
    h2 {
        font-size: 1.8rem;
    }

    .question {
        font-size: 1.2rem;
    }

    .options button {
        font-size: 0.9rem;
        padding: 10px;
    }

    #next-btn {
        font-size: 0.9rem;
        padding: 10px 15px;
    }
}

@media (max-width: 480px) {
    h2 {
        font-size: 1.6rem;
    }

    .question {
        font-size: 1rem;
    }

    .options button {
        font-size: 0.8rem;
        padding: 8px;
    }

    #next-btn {
        font-size: 0.8rem;
        padding: 8px 12px;
    }
}

    </style>
</head>
<body>
    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="./index.php">
                            <img src="../img/logo3.jpg" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li><a href="./home.php">Home</a></li>
                                <li class="active"><a href="./categories1.php">Stories <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="./categories1.php">Stories</a></li>
                                        <li><a href="./author.php">Authors</a></li>
                                        <li><a href="./videowatching.php">Anime Watching</a></li>
                                        <li><a href="./story_writing.php">story writing</a></li>
                                        <!--<li><a href="./story_creating.php">story creating</a></li>-->
                                        <!--<li><a href="./index.php">Logout</a></li> -->
                                    </ul>
                                </li>
                                
                                <li><a href="./blogs.php">Own Stories</a></li>
                                <li><a href="./aifeatures1.php">AI Features</a></li>
                                <li><a href="./contant1.php">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <!-- <a href="#" class="search-switch"><span class="icon_search"></span></a> -->
                         <!-- Favorite Icon (with link to favorite stories page) -->
                    <a href="./user_favorites.php" class="favorite-icon">
                    <i class="fa fa-heart"></i> Favorites
                    </a>
                        <a href="./profile.php">                        <i class="fa fa-user"></i> Profile
                        </a>                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- header end -->
    <!-- question sart -->
<section class="question-section">
    <div class="container py-5">
    <h2>Story Quiz</h2>
    <?php foreach ($quizzes as $index => $quiz): ?>
            <div class="quiz-container" data-index="<?=$index;?>">
                <div class="question">
                    <?=($index + 1) . ". " . htmlspecialchars($quiz['question']);?>
                </div>
                <div class="options">
                    <?php
$options = json_decode($quiz['options']); // Decode JSON options from database
foreach ($options as $option): ?>
                        <button onclick="validateAnswer(this, '<?=htmlspecialchars($quiz['correct_answer']);?>', <?=$index;?>)">
                            <?=htmlspecialchars($option);?>
                        </button>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endforeach;?>
        <div class="score" id="score"></div>
        <button id="next-btn" style="display: none; margin-top: 20px;background: #0d6efd;
    color: #fff;
    width: 20%;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid transparent;
    margin-left: auto;
    white-space: nowrap;" >Next>>>></button>

    </div>
</section>
    <script>
        const totalQuestions = <?=count($quizzes);?>;
        let score = 0;
        let currentQuestionIndex = 0;
        const quizContainers = document.querySelectorAll('.quiz-container');
        const nextBtn = document.getElementById('next-btn');

        // Show the first question
        quizContainers[currentQuestionIndex].classList.add('active');

        function validateAnswer(button, correctAnswer, questionIndex) {
            const selected = button.textContent.trim();
            const correct = correctAnswer.trim();
            const options = button.parentNode.children;

            for (let i = 0; i < options.length; i++) {
                options[i].disabled = true;
                options[i].style.backgroundColor =
                    options[i].textContent.trim() === correct ? '#4CAF50' : '#f44336';
            }

            if (selected === correct) {
                score++;
            }

            nextBtn.style.display = 'block';
        }

        nextBtn.addEventListener('click', () => {
            quizContainers[currentQuestionIndex].classList.remove('active');
            currentQuestionIndex++;

            if (currentQuestionIndex < totalQuestions) {
                quizContainers[currentQuestionIndex].classList.add('active');
                nextBtn.style.display = 'none';
            } else {
                document.getElementById('score').textContent = `Your Score: ${score} / ${totalQuestions}`;
                saveScore(score, totalQuestions);
                nextBtn.style.display = 'none';
            }
        });

        function saveScore(score, totalQuestions) {
            const formData = new FormData();
            formData.append('score', score);
            formData.append('total_questions', totalQuestions);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Score saved successfully!');
                } else {
                    alert('Failed to save score.');
                    console.error(data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>

<!-- Bootstrap JS (with Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76A4L0x8k2WggkegSQe6YD5D+TfW9e/7Lgk4DmR9QQIkUA8cnCswi0a2XnpOpb4" crossorigin="anonymous"></script>

    <!-- Js Plugins -->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/player.js"></script>
    <script src="../js/jquery.nice-select.min.js"></script>
    <script src="../js/mixitup.min.js"></script>
    <script src="../js/jquery.slicknav.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/main.js"></script>

</body>
</html>
