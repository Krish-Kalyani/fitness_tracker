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
    $stmt = $conn->prepare("DELETE FROM workouts WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $workout_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: manage_workouts.php");
        exit;
    } else {
        echo "Failed to delete workout.";
    }
} catch (PDOException $e) {
    die("Error deleting workout: " . $e->getMessage());
}
?>
