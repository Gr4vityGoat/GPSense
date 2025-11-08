<?php
session_start();
require_once(__DIR__ . '/../includes/mysqli_connect.php');

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Get initial random question
$query = "SELECT * FROM questions ORDER BY RAND() LIMIT 1";
$result = $mysqli->query($query);

if (!$result) {
    error_log("Query failed: " . $mysqli->error);
    die("Query failed: " . $mysqli->error);
}

$question = $result->fetch_assoc();

if (!$question) {
    error_log("No questions found in database");
    die("No questions found in database");
}

// Return question data as JSON if it's an AJAX request
if(isset($_GET['action']) && $_GET['action'] === 'get_question') {
    $question['photo_url'] = trim($question['photo_url'] ?? '');
    header('Content-Type: application/json');
    echo json_encode($question);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/assets/css/home.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=agrandir@400,700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPSense Quiz</title>
    <link rel="stylesheet" href="/assets/css/home.css">
    <style>
        /* Only styles needed for interactive elements */
        .option {
            cursor: pointer;
            transition: all 0.3s ease;
            color: #14213d; 
            font-family: 'Poppins', sans-serif;
            width: 50%; 
            margin: 0 auto;
        }

        .option:hover {
            transform: translateY(-2px);
        }

        .option.correct {
            background: #98ce00 !important;
            color: white !important;
            border-color: #c3e75eff !important;
        }

        .option.incorrect {
            background: #b02e0c !important;
            color: white !important;
            border-color: #d0433f !important;
        }

        .feedback {
            display: none;
        }

        .next-button {
            display: none;
        }
    </style>
</head>
<body>
    <div class="navigation_buttons">
        <form action="home.php" method="get" style="display:inline;">
            <button type="submit">Take Quiz</button>
        </form>
        <form action="account.php" method="get" style="display:inline;">
            <button type="submit">My Account</button>
        </form>
    </div>
    <div class="question-box">
        <img id="questionImage" src="" alt="Question Image" class="question-image" style="display: none;">
        <div id="questionText" class="question-text"></div>
        <div id="options" class="options-container"></div>
        <div id="feedback" class="feedback"></div>
        <button id="nextButton" class="next-button">Next Question</button>
    </div>

    <script>
        let currentQuestion = null;
        
        // Function to load a new question
        async function loadQuestion() {
            try {
                const response = await fetch('home.php?action=get_question');
                currentQuestion = await response.json();
                
                // Update the UI with the new question
                document.getElementById('questionText').textContent = currentQuestion.question_text;
                
                // Handle the image
                const imageElement = document.getElementById('questionImage');
                if (currentQuestion.photo_url) {
                imageElement.src = '/' + currentQuestion.photo_url;
                imageElement.style.display = 'block';
    
                // Always enforce consistent sizing
                imageElement.style.maxWidth = '320px';
                imageElement.style.maxHeight = '320px';
                imageElement.style.width = 'auto';
                imageElement.style.height = 'auto';
                imageElement.style.objectFit = 'contain';
                imageElement.style.margin = '0 auto 15px';
                } else {
                imageElement.style.display = 'none';
                }
                
                // Create the options
                const optionsContainer = document.getElementById('options');
                optionsContainer.innerHTML = '';
                
                for (let i = 1; i <= 4; i++) {
                    if (currentQuestion['option_' + i]) {
                        const option = document.createElement('div');
                        option.className = 'option';
                        option.dataset.value = i;
                        option.textContent = currentQuestion['option_' + i];
                        optionsContainer.appendChild(option);
                    }
                }
                
                // Reset the feedback and next button
                document.getElementById('feedback').style.display = 'none';
                document.getElementById('nextButton').style.display = 'none';
                
                // Enable all options
                document.querySelectorAll('.option').forEach(opt => {
                    opt.classList.remove('correct', 'incorrect');
                    opt.style.pointerEvents = 'auto';
                });
            } catch (error) {
                console.error('Error loading question:', error);
            }
        }
        
        // Function to handle answer selection
        function handleAnswer(selectedOption) {
            const options = document.querySelectorAll('.option');
            const feedback = document.getElementById('feedback');
            const nextButton = document.getElementById('nextButton');
            
            // Disable all options after selection
            options.forEach(opt => opt.style.pointerEvents = 'none');
            
            // Check if answer is correct
            const isCorrect = selectedOption.dataset.value === currentQuestion.correct_answer;
            
            // Show correct and incorrect answers
            options.forEach(opt => {
                if (opt.dataset.value === currentQuestion.correct_answer) {
                    opt.classList.add('correct');
                } else if (opt === selectedOption && !isCorrect) {
                    opt.classList.add('incorrect');
                }
            });
            
            // Show feedback
            feedback.textContent = isCorrect ? 
                '✅ Correct!' : 
                `❌ Incorrect. ${currentQuestion.answer_reason}`;
            feedback.className = `feedback ${isCorrect ? 'correct' : 'incorrect'}`;
            feedback.style.display = 'block';
            
            // Show next button regardless of answer correctness
            nextButton.style.display = 'block';
        }
        
        // Event Listeners
        document.addEventListener('DOMContentLoaded', () => {
            // Load initial question
            loadQuestion();
            
            // Handle option clicks
            document.getElementById('options').addEventListener('click', (e) => {
                if (e.target.classList.contains('option')) {
                    handleAnswer(e.target);
                }
            });
            
            // Handle next button clicks
            document.getElementById('nextButton').addEventListener('click', loadQuestion);
        });
    </script>
</body>
</html>