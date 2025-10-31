<?php
session_start();
require_once('mysqli_connect.php');

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header('Location: login.html');
    exit();
}

$query = "SELECT * FROM questions ORDER BY RAND() LIMIT 1";
$result = $mysqli->query($query);
$question = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>GPSense Home</title>
    <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fff8fd;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .question-box {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 400px;
      text-align: center;
    }

    .question-box h2 {
      color: #676167;
    }

    .question-box form {
      margin-top: 20px;
    }

    .question-box label {
      display: block;
      margin: 10px 0;
      text-align: left;
    }

    .question-box button {
      margin-top: 15px;
      padding: 10px 20px;
      background-color: #ab261d;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    .question-box button:hover {
      background-color: #d0433f;
    }

    </style>
</head>
<body>
    <div class="question_box">
        <h2><?php echo htmlspecialchars($question['question_text']); ?></h2>
        <form action="check_answer.php" method="post">
            <?php foreach (['1', '2', '3', '4'] as $opt): ?>
                <?php if (!empty($question['option_' . strtolower($opt)])): ?>
                    <label>
                        <input type="radio" name="answer" value="<?php echo $opt; ?>" required>
                        <?php echo $opt . '. ' . htmlspecialchars($question['option_' . strtolower($opt)]); ?>
                    </label>
                <?php endif; ?>
            <?php endforeach; ?>
            <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
            <button type="submit">Submit Answer</button>
        </form>
    </div>
</body>
</html>