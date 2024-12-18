<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts (user_id, title, content) VALUES ('$user_id', '$title', '$content')";

    if ($conn->query($sql) === TRUE) {
        echo "Add post successful!";
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewpoint" content="width=device-width, intial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="stylesheet" href="css/style.css">
        <title>My website</title>
    </head>
    <body>

        <h2>Add post</h2>
        <form method="post" action="addpost.php">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
            <button type="submit">Add post</button>
        </form>
        
        <?php include "includes/footer.php" ?>
    </body>
</html>