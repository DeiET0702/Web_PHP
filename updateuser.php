<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET username='$username', email='$email' WHERE id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['username'] = $username;
        echo "Update user successful!";
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found!";
        exit;
    }
} else {
    echo "Invalid user ID!";
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

        <h2>Update user</h2>
        <form method="post" action="updateuser.php">
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required></>
            <button type="submit">Update user</button>
        </form>
        
        <?php include "includes/footer.php" ?>
    </body>
</html>