<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
require_once 'config.php';

$sql = "SELECT * FROM posts WHERE user_id='{$_SESSION['user_id']}' ORDER BY created_at DESC";
$result = $conn->query($sql);

$username = $_SESSION['username'];
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
        
        <?php include "includes/header.php" ?>

        <div class="username-display">
            <p><?php echo htmlspecialchars($username); ?></p>
        </div>


        <div class="user-actions" style="margin: 20px 0; text-align: center;">
            <a href="addpost.php" class="btn">Add Post</a>
            <a href="adduser.php" class="btn">Add User</a>
            <a href="updateuser.php?id=<?php echo $_SESSION['user_id']; ?>" class="btn">Update User</a>
            <a href="deleteuser.php?id=<?php echo $_SESSION['user_id']; ?>" class="btn">Delete User</a>
            <a href="logout.php" class="btn logout">Logout</a>
        </div>
        
        <main>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
                echo "<small>Created at: " . $row['created_at'] . "</small>";
                echo "<div class='action-buttons'>";
                echo "<a href='updatepost.php?id=" . $row['id'] . "'>Update</a> |";
                echo "<a href='deletepost.php?id=" . $row['id'] . "'>Delete</a> |";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No posts found.";
        }
        ?>
        </main>

        <?php include "includes/footer.php" ?>
    </body>
</html>