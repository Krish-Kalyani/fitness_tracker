<?php
session_start();
if (!isset($_SESSION['username'])) {
header("Location: login.php");
exit(); }
?>
<!DOCTYPE html>
<html>
<head>
     <link rel="stylesheet" href="css/style.css">
     <title>Dashboard</title>
    </head>
    <body>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
         <a href="add_workout.php">Add Workout</a> | 
         <a href="view_workouts.php">View Workouts</a> | 
         <a href="logout.php">Logout</a>
</body>
</html>
