<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate if all required POST parameters are present
    if (!isset($_POST['id'], $_POST['workout_type'], $_POST['duration'], $_POST['date'])) {
        die("Invalid request. Missing parameters.");
    }
    $workout_id = intval($_POST['id']);
    $workout_type = htmlspecialchars(trim($_POST['workout_type']));
    $duration = intval($_POST['duration']);
    $date = htmlspecialchars(trim($_POST['date']));

    try {

        $stmt = $conn->prepare(
            "UPDATE workouts 
            SET workout_type = :workout_type, duration = :duration, date = :date 
            WHERE id = :workout_id AND user_id = :user_id"
        );

        $stmt->bindParam(':workout_type', $workout_type, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':workout_id', $workout_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Workout updated successfully.";
        } else {
            echo "Failed to update workout. Please try again.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    die("Invalid request method.");
}
?>
