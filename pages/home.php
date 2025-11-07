<?php
session_start();
require_once(__DIR__ . '/../includes/mysqli_connect.php');

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header('Location: login.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GPSense Quiz</title>
    <link rel="stylesheet" href="/assets/css/home.css">
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
    <div class="question_box">
        <?php if (!empty($question['photo_url'])): ?>
            <img src="<?php echo htmlspecialchars($question['photo_url']); ?>" alt="Question Image"
                class="question_image" />
        <?php endif; ?>

        <h2><?php echo htmlspecialchars($question['question_text']); ?></h2>
        <form action="check_answer.php" method="post">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <?php if (!empty($question["option_$i"])): ?>
                    <label>
                        <input type="radio" name="answer" value="<?php echo $i; ?>" required>
                        <?php echo "$i. " . htmlspecialchars($question["option_$i"]); ?>
                    </label><br>
                <?php endif; ?>
            <?php endfor; ?>
            <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
            <button type="submit">Submit Answer</button>
        </form>
    </div>
</body>

</html>