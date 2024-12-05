<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $workout_type = htmlspecialchars(trim($_POST['workout_type']));
    $duration = intval($_POST['duration']);
    $date = htmlspecialchars(trim($_POST['date']));

    try {
        $stmt = $conn->prepare("INSERT INTO workouts (user_id, workout_type, duration, date) VALUES (:user_id, :workout_type, :duration, :date)");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':workout_type', $workout_type, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Add A Workout</title>
</head>
<body>
    <h1>Add Workout</h1>
    <form method="POST">
        <label>Workout Type:</label>
        <input type="text" name="workout_type" required>
        <label>Duration (minutes):</label>
        <input type="number" name="duration" required>
        <label>Date:</label>
        <input type="date" name="date" required>
        <button type="submit">Add</button>
    </form>
</body>
</html>
