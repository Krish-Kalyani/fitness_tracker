<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); }
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM workouts WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>View Workouts</title>
</head>
<body>
    <h1>Your Workouts</h1>
    <a href="dashboard.php">Back To Dashboard</a>
    <table border="1">
        <tr>
            <th>Workout Type</th>
        <th>Duration</th>
        <th>Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
        <td><?php echo htmlspecialchars($row['workout_type']); ?></td>
            <td><?php echo htmlspecialchars($row['duration']); ?> minutes</td>
            <td><?php echo htmlspecialchars($row['date']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
