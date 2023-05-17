<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
</head>
<body>
    <h1>Welcome <?php echo $_SESSION['username']; ?>!</h1>
    <?php if ($_SESSION['role'] == 'admin') { ?>
        <p>You are logged in as an admin.</p>
    <?php } else { ?>
        <p>You are logged in as a user.</p>
    <?php } ?>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
