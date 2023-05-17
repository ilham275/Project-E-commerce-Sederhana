<?php
session_start();

if (isset($_POST['submit'])) {
    require_once 'config.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    $errors = [];
    if (empty($username)) {
        $errors[] = "Username is required!";
    }
    if (empty($password)) {
        $errors[] = "Password is required!";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

    // Cek apakah username sudah digunakan
    $query = "SELECT COUNT(*) AS count FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['username' => $username]);
    $row = $stmt->fetch();
    if ($row['count'] > 0) {
        $errors[] = "Username already exists!";
    }

    // Jika tidak ada error, simpan data pengguna ke database
    if (empty($errors)) {
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $_SESSION['success_msg'] = "Registration successful! Please login.";
        header('Location: login.php');
        exit;
    }
}

?>
<!-- 
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required><br><br>
        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="template/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="template/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="template/index2.html" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <!-- <input type="text" class="form-control" placeholder="Full name"> -->
        <input type="text" class="form-control" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" placeholder="Username" required>

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="confirm_password" placeholder="Retype password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
         <a href="login.php"  class="text-center">I already have a membership</a>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="submit" value="Register">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="template/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="template/dist/js/adminlte.min.js"></script>
</body>
</html>
