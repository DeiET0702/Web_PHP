<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id='$post_id' AND user_id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Update post successful!";
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
}

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id='$post_id' AND user_id='{$_SESSION['user_id']}'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo "Post not found!";
        exit;
    }
} else {
    echo "Invalid post ID!";
    exit;
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

        <h2>Update post</h2>
        <form method="post" action="updatepost.php">
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $post['title']; ?>" required>
            <label for="content">Content:</label>
            <textarea id="content" name="content" value="<?php echo $post['content']; ?>" required></textarea>
            <button type="submit">Update post</button>
        </form>
        
        <?php include "includes/footer.php" ?>
    </body>
</html>