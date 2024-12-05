<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $goal_type = htmlspecialchars(trim($_POST['goal_type']));
    $goal_value = intval($_POST['goal_value']);
    $progress = intval($_POST['progress']);

    try {
        $stmt = $conn->prepare("INSERT INTO goals (user_id, goal_type, goal_value, progress) VALUES (:user_id, :goal_type, :goal_value, :progress)");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':goal_type', $goal_type, PDO::PARAM_STR);
        $stmt->bindParam(':goal_value', $goal_value, PDO::PARAM_INT);
        $stmt->bindParam(':progress', $progress, PDO::PARAM_INT);
        $stmt->execute();
        echo "Goal added successfully.";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Goals and Achievements</title>
</head>
<body>
    <h1>Goals and Achievements</h1>
    <form method="POST">
        <label>Goal Type (e.g., "Run 10 miles"): </label>
        <input type="text" name="goal_type" required>
        <label>Goal Value (Target number, e.g., "10" for 10 miles): </label>
        <input type="number" name="goal_value" required>
        <label>Progress (How much you've completed, e.g., "5" for 5 miles): </label>
        <input type="number" name="progress" required>
        <button type="submit">Add Goal</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
