<?php
session_start();
require 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "<p>Username already exists</p>"; } 
 }
    ?>
    <!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="POST" onsubmit="return validateForm();">
        <label>Username:</label>
        <input type="text" name="username" id="username" required>
        <label>Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Register</button>
</form>
 <script src="js/validation.js"></script>
</body>
</html>
