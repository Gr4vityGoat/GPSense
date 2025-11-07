<?php
session_start();
include('mysqli_connect.php');

$question_id = $_POST['question_id'];
$selected = $_POST['answer'];

$query = "SELECT * FROM questions WHERE id = $question_id";
$result = mysqli_query($mysqli, $query);
$question = mysqli_fetch_array($result, MYSQLI_ASSOC);

$correct = $question['correct_answer'];
$reason = $question['answer_reason'];
$photo = $question['photo_url'];

$is_correct = ($selected == $correct);

// correct answer number to text
$correct_text = $question['option_' . $correct];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Answer Result</title>
  <link rel="stylesheet" href="quiz.css">
</head>
<body>
  <main class="quiz-result">
    <?php if (!empty($photo)): ?>
      <img src="<?php echo htmlspecialchars($photo); ?>" alt="Question Image" class="question-image">
    <?php endif; ?>

    <h2><?php echo $is_correct ? "✅ Correct!" : "❌ Incorrect."; ?></h2>
    <p><strong>Correct Answer:</strong> <?php echo htmlspecialchars($correct_text); ?></p>
    <p><strong>Explanation:</strong> <?php echo htmlspecialchars($reason); ?></p>
    <a href="home.php">Next Question</a>
  </main>
</body>
</html>
