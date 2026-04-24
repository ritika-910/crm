<?php
session_start();
error_reporting(0);
include("../config/dbconnection.php");

session_start();
include 'dbconnection.php';

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: user/dashboard.php");
    }

} else {
    echo "Invalid login";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | CRM</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link href="../assets/css/crm.css" rel="stylesheet"/>
</head>
<body>
<div class="login-page">
  <div class="login-box">
    <div class="login-logo">
      <div class="logo-circle"><i class="fa fa-chart-pie"></i></div>
      <h2>Welcome Back</h2>
      <p>Sign in to your CRM account</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><i class="fa fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['action1'])): ?>
      <div class="alert alert-danger"><i class="fa fa-circle-exclamation"></i> <?= htmlspecialchars($_SESSION['action1']) ?></div>
      <?php $_SESSION['action1'] = ''; ?>
    <?php endif; ?>

    <form method="post" action="">
      <div class="form-group">
        <label>Email Address</label>
        <div class="input-with-icon">
          <i class="fa fa-envelope"></i>
          <input type="email" name="email" class="form-control" placeholder="you@example.com" required autofocus/>
        </div>
      </div>
      <div class="form-group">
        <label>
          Password
          <a href="../auth/forgot-password.php" style="float:right; font-size:12px; color:#4f46e5; font-weight:400;">Forgot password?</a>
        </label>
        <div class="input-with-icon">
          <i class="fa fa-lock"></i>
          <input type="password" name="password" class="form-control" placeholder="Enter your password" required/>
        </div>
      </div>
      <button type="submit" name="login" class="btn btn-primary" style="width:100%; justify-content:center; padding:11px;">
        <i class="fa fa-right-to-bracket"></i> Sign In
      </button>
    </form>

    <div style="text-align:center; margin-top:20px; font-size:13px; color:#64748b;">
      Don't have an account? <a href="registration.php" style="color:#4f46e5; font-weight:600;">Create one free</a>
    </div>
  </div>
</div>
</body>
</html>
