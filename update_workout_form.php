<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

if (!isset($_GET['id'])) {
    die("Workout ID is missing.");
}

$workout_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT workout_type, duration, date FROM workouts WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $workout_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $workout = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$workout) {
        die("Workout not found.");
    }
} catch (PDOException $e) {
    die("Error fetching workout: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Workout</title>
</head>
<body>
    <h1>Update Workout</h1>
    <form action="update_workout.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($workout_id); ?>">
        <label for="workout_type">Workout Type:</label>
        <input type="text" id="workout_type" name="workout_type" value="<?php echo htmlspecialchars($workout['workout_type']); ?>" required><br>
        <label for="duration">Duration (minutes):</label>
        <input type="number" id="duration" name="duration" value="<?php echo htmlspecialchars($workout['duration']); ?>" required><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($workout['date']); ?>" required><br>
        <button type="submit">Update Workout</button>
    </form>
    <a href="manage_workouts.php">Back to Manage Workouts</a>
</body>
</html>
