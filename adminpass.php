<?php
session_start();
include 'headeradmin.php';

require_once 'config.php';

$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$query->execute([$id]);
$data = $query->fetch();
if (isset($_POST['submit'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    $errors = [];
    if (empty($new_password)) {
        $errors[] = "New password is required!";
    }
    if ($new_password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

 
    // Jika tidak ada error, update password pengguna di database
    if (empty($errors)) {
        $query = "UPDATE users SET password = :password WHERE id = '$id'";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'password' => password_hash($new_password, PASSWORD_DEFAULT),
        ]);

        $_SESSION['success_msg'] = "Password updated successfully!";
        header('Location: admin.php');
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
        <!-- <label>New Password:</label>
        <input type="password" name="new_password" required><br><br>
        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required><br><br>
        <input type="submit" name="submit" value="Update Password"> -->
        <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="mb-4">Lengkapi Data Profile</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="new_password" class="form-label">Username</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" <?php if($data){echo'value='.'"'.$data['username'].'"';}?>disabled>

                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>
              
                <div class="mb-3">
                    <?php
                        echo'<button type="submit" name="submit" class="btn btn-primary">Update Password</button>';
                    ?>
                </div>
            </form>
        </div>
    </div>
    </form>
</body>
</html>




