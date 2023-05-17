<?php
session_start();
require_once 'config.php';

if (isset($_POST['submit'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    $errors = [];
    if (empty($current_password)) {
        $errors[] = "Current password is required!";
    }
    if (empty($new_password)) {
        $errors[] = "New password is required!";
    }
    if ($new_password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

    // Cek apakah password saat ini benar
    $user_id = $_SESSION['user_id'];
    $query = "SELECT password FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $user_id]);
    $row = $stmt->fetch();
    if (!password_verify($current_password, $row['password'])) {
        $errors[] = "Current password is incorrect!";
    }

    // Jika tidak ada error, update password pengguna di database
    if (empty($errors)) {
        $query = "UPDATE users SET password = :password WHERE id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'password' => password_hash($new_password, PASSWORD_DEFAULT),
            'user_id' => $user_id,
        ]);

        $_SESSION['success_msg'] = "Password updated successfully!";
        header('Location: dashboard.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>
    <?php if (isset($errors)) { ?>
        <ul>
            <?php foreach ($errors as $error) { ?>
                <li><?php echo $error; ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
    <form method="POST" action="">
        <label>Current Password:</label>
        <input type="password" name="current_password" required><br><br>
        <label>New Password:</label>
        <input type="password" name="new_password" required><br><br>
        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required><br><br>
        <input type="submit" name="submit" value="Update Password">
    </form>
</body>
</html>
