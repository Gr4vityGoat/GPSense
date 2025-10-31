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