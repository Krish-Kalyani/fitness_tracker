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
    die("Error fetching workouts: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Workouts</title>
</head>
<body>
    <h1>Manage Your Workouts</h1>
    <table border="1">
        <tr>
            <th>Workout Type</th>
            <th>Duration</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($workouts as $workout): ?>
        <tr>
            <td><?php echo htmlspecialchars($workout['workout_type']); ?></td>
            <td><?php echo htmlspecialchars($workout['duration']); ?> mins</td>
            <td><?php echo htmlspecialchars($workout['date']); ?></td>
            <td>
                <a href="update_workout_form.php?id=<?php echo $workout['id']; ?>">Edit</a> | 
                <a href="delete_workout.php?id=<?php echo $workout['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
