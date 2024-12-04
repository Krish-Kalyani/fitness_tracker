<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in."); }
$user_id = $_SESSION['user_id'];
if (!isset($_GET['id'])) {
    die("Invalid request. No workout ID provided."); }
$workout_id = intval($_GET['id']);
try {
    $stmt = $conn->prepare("DELETE FROM workouts WHERE id = :workout_id AND user_id = :user_id");
    $stmt->bindParam(':workout_id', $workout_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "Workout deleted successfully.";
    } else {
        echo "Failed to delete workout. Please try again.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
