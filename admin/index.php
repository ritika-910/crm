<?php
session_start();
error_reporting(0);
include("../config/dbconnection.php");


if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($con, trim($_POST['email']));
    $pass = $_POST['password'];
    $ret  = mysqli_query($con, "SELECT * FROM admin WHERE name='$user'");
    $num  = mysqli_fetch_assoc($ret);
    if ($num && password_verify($pass, $num['password']))  {
        $_SESSION['alogin'] = $user;
        $_SESSION['id']     = $num['id'];
        header("Location: home.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login | CRM</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link href="../assets/css/crm.css" rel="stylesheet"/>
</head>
<body>
<div class="login-page">
  <div class="login-box">
    <div class="login-logo">
      <div class="logo-circle"><i class="fa fa-chart-bar"></i></div>
      <h2>CRM Admin Panel</h2>
      <p>Sign in to manage your CRM system</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><i class="fa fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="form-group">
        <label>Username</label>
        <div class="input-with-icon">
          <i class="fa fa-user"></i>
          <input type="text" name="email" class="form-control" placeholder="Enter username" required autofocus/>
        </div>
      </div>
      <div class="form-group">
        <label>Password</label>
        <div class="input-with-icon">
          <i class="fa fa-lock"></i>
          <input type="password" name="password" class="form-control" placeholder="Enter password" required/>
        </div>
      </div>
      <button type="submit" name="login" class="btn btn-primary" style="width:100%; justify-content:center; padding:11px;">
        <i class="fa fa-right-to-bracket"></i> Sign In
      </button>
    </form>
  </div>
</div>
</body>
</html>
