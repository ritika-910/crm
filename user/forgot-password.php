<?php
session_start();
error_reporting(0);
include("../config/dbconnection.php");

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, trim($_POST['email']));
    $row   = mysqli_fetch_assoc(mysqli_query($con, "SELECT email FROM user WHERE email='$email'"));
    if ($row) {
        $tempPass = bin2hex(random_bytes(5));
        $hashed   = password_hash($tempPass, PASSWORD_DEFAULT);
        mysqli_query($con, "UPDATE user SET password='$hashed' WHERE email='$email'");
        mail($email, "CRM - Your Temporary Password",
             "Your temporary password is: $tempPass\nPlease login and change it.",
             "From: no-reply@crm.com");
        $success = "A temporary password has been sent to your email.";
    } else {
        $error = "No account found with this email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password | CRM</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link href="assets/css/crm.css" rel="stylesheet"/>
</head>
<body>
<div class="login-page">
  <div class="login-box">
    <div class="login-logo">
      <div class="logo-circle"><i class="fa fa-key"></i></div>
      <h2>Forgot Password?</h2>
      <p>Enter your email and we'll send a temporary password</p>
    </div>

    <?php if (!empty($success)): ?>
      <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><i class="fa fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="form-group">
        <label>Registered Email Address</label>
        <div class="input-with-icon">
          <i class="fa fa-envelope"></i>
          <input type="email" name="email" class="form-control" placeholder="you@example.com" required/>
        </div>
      </div>
      <button type="submit" name="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:11px;">
        <i class="fa fa-paper-plane"></i> Send Temporary Password
      </button>
    </form>
    <div style="text-align:center; margin-top:20px; font-size:13px; color:#64748b;">
      <a href="login.php" style="color:#4f46e5; font-weight:600;"><i class="fa fa-arrow-left"></i> Back to Login</a>
    </div>
  </div>
</div>
</body>
</html>
