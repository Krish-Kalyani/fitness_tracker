<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $meal = htmlspecialchars(trim($_POST['meal']));
    $calories = intval($_POST['calories']);
    $protein = intval($_POST['protein']);
    $carbs = intval($_POST['carbs']);
    $fats = intval($_POST['fats']);
    try {
        $stmt = $conn->prepare("INSERT INTO nutrition (user_id, meal, calories, protein, carbs, fats) VALUES (:user_id, :meal, :calories, :protein, :carbs, :fats)");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':meal', $meal, PDO::PARAM_STR);
        $stmt->bindParam(':calories', $calories, PDO::PARAM_INT);
        $stmt->bindParam(':protein', $protein, PDO::PARAM_INT);
        $stmt->bindParam(':carbs', $carbs, PDO::PARAM_INT);
        $stmt->bindParam(':fats', $fats, PDO::PARAM_INT);
        $stmt->execute();
        echo "Meal added successfully.";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Nutrition Tracker</title>
</head>
<body>
    <h1>Nutrition Tracker</h1>
    <form method="POST">
        <label>Meal Description:</label>
        <input type="text" name="meal" required>
        <label>Calories:</label>
        <input type="number" name="calories" required>
        <label>Protein (g):</label>
        <input type="number" name="protein" required>
        <label>Carbs (g):</label>
        <input type="number" name="carbs" required>
        <label>Fats (g):</label>
        <input type="number" name="fats" required>
        <button type="submit">Log Meal</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
