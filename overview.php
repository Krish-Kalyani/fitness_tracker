<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Fetch goals
    $stmtGoals = $conn->prepare("SELECT goal_type, goal_value, progress FROM goals WHERE user_id = :user_id");
    $stmtGoals->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmtGoals->execute();
    $goals = $stmtGoals->fetchAll(PDO::FETCH_ASSOC);

    // Fetch nutrition
    $stmtNutrition = $conn->prepare("SELECT meal, calories, protein, carbs, fats FROM nutrition WHERE user_id = :user_id");
    $stmtNutrition->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmtNutrition->execute();
    $nutrition = $stmtNutrition->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Overview</title>
</head>
<body>
    <h1>Overview</h1>
    
    <!-- Goals Section -->
    <h2>Goals and Achievements</h2>
    <?php if (count($goals) > 0): ?>
    <table border="1">
        <tr>
            <th>Goal Type</th>
            <th>Goal Value (Target, e.g., 10 miles)</th>
            <th>Progress (Completed, e.g., 5 miles)</th>
        </tr>
        <?php foreach ($goals as $goal): ?>
        <tr>
            <td><?php echo htmlspecialchars($goal['goal_type']); ?></td>
            <td><?php echo htmlspecialchars($goal['goal_value']); ?></td>
            <td><?php echo htmlspecialchars($goal['progress']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p>No goals have been added yet. <a href="goals.php">Set your goals now!</a></p>
    <?php endif; ?>

    <!-- Nutrition Section -->
    <h2>Nutrition Tracker</h2>
    <?php if (count($nutrition) > 0): ?>
    <table border="1">
        <tr>
            <th>Meal</th>
            <th>Calories</th>
            <th>Protein (g)</th>
            <th>Carbs (g)</th>
            <th>Fats (g)</th>
        </tr>
        <?php foreach ($nutrition as $meal): ?>
        <tr>
            <td><?php echo htmlspecialchars($meal['meal']); ?></td>
            <td><?php echo htmlspecialchars($meal['calories']); ?></td>
            <td><?php echo htmlspecialchars($meal['protein']); ?></td>
            <td><?php echo htmlspecialchars($meal['carbs']); ?></td>
            <td><?php echo htmlspecialchars($meal['fats']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p>No meals have been logged yet. <a href="nutrition_tracker.php">Log your meals now!</a></p>
    <?php endif; ?>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
