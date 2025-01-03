<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT id, workout_type, duration, date FROM workouts WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>View Workouts</title>
</head>
<body>
    <h1>Your Workouts</h1>
    <table border="1">
        <tr>
            <th>Workout Type</th>
            <th>Duration (minutes)</th>
            <th>Date</th>
        </tr>
        <?php foreach ($workouts as $workout): ?>
        <tr>
            <td><?php echo htmlspecialchars($workout['workout_type']); ?></td>
            <td><?php echo htmlspecialchars($workout['duration']); ?></td>
            <td><?php echo htmlspecialchars($workout['date']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
