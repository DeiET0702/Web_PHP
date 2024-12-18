<?php
require_once 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['loggedin'] = true;
            header("location: index.php");
        } else {
            echo "Wrong password!";
        } 
    } else {
        echo "Invalid username!";
        header('Location: register.php');
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="stylesheet" href="css/style.css">
        <title>My website</title>
    </head>
    <body>
        <?php include "includes/header.php" ?>

        <h2>Login</h2>
        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        
        <?php include "includes/footer.php" ?>
    </body>
</html>