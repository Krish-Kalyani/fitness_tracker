<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Fitness Tracker Website</title>
</head>
<body>
    <h1>Thanks For Visiting Fitness Tracker</h1>
    <a href="login.php">Login</a> | <a href="register.php">Register</a>
</body>
</html>
