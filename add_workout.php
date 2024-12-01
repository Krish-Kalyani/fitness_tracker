<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $workout_type = $_POST['workout_type'];
    $duration = $_POST['duration'];
    $date = $_POST['date'];
    $stmt = $conn->prepare("INSERT INTO workouts (user_id, workout_type, duration, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $user_id, $workout_type, $duration, $date);
    $stmt->execute();
    header("Location: dashboard.php");
    exit(); }
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
