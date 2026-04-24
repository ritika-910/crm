<?php
session_start();
include("../config/dbconnection.php");

if (isset($_POST['submit'])) {
    $name     = mysqli_real_escape_string($con, trim($_POST['name']));
    $email    = mysqli_real_escape_string($con, trim($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $mobile   = mysqli_real_escape_string($con, trim($_POST['phone']));
    $gender   = mysqli_real_escape_string($con, $_POST['gender']);

    $check = mysqli_num_rows(mysqli_query($con, "SELECT id FROM user WHERE email='$email'"));
    if ($check > 0) {
        $error = "This email is already registered.";
    } elseif ($_POST['password'] !== $_POST['cpassword']) {
        $error = "Passwords do not match.";
    } else {
        mysqli_query($con, "INSERT INTO user(name,email,password,mobile,gender,posting_date)
                            VALUES('$name','$email','$password','$mobile','$gender','".date('Y-m-d')."')");
        header("Location: login.php?registered=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | CRM</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link href="../assets/css/crm.css" rel="stylesheet"/>
</head>
<body>
<div class="login-page">
  <div class="login-box" style="max-width:480px;">
    <div class="login-logo">
      <div class="logo-circle"><i class="fa fa-user-plus"></i></div>
      <h2>Create Account</h2>
      <p>Join CRM — it's completely free</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><i class="fa fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="form-grid" style="grid-template-columns:1fr 1fr; gap:12px;">
        <div class="form-group" style="margin-bottom:0;">
          <label>Full Name</label>
          <input type="text" name="name" class="form-control" placeholder="John Doe" required/>
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label>Contact Number</label>
          <input type="text" name="phone" class="form-control" placeholder="10 digits" pattern="[0-9]{10}" required/>
        </div>
      </div>
      <div class="form-group" style="margin-top:12px;">
        <label>Email Address</label>
        <div class="input-with-icon">
          <i class="fa fa-envelope"></i>
          <input type="email" name="email" class="form-control" placeholder="you@example.com" required/>
        </div>
      </div>
      <div class="form-grid" style="grid-template-columns:1fr 1fr; gap:12px;">
        <div class="form-group" style="margin-bottom:0;">
          <label>Password</label>
          <input type="password" name="password" class="form-control" placeholder="Min. 6 chars" required/>
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label>Confirm Password</label>
          <input type="password" name="cpassword" class="form-control" placeholder="Re-enter" required/>
        </div>
      </div>
      <div class="form-group" style="margin-top:12px;">
        <label>Gender</label>
        <div style="display:flex; gap:16px; margin-top:6px;">
          <label style="display:flex; align-items:center; gap:6px; font-weight:400; cursor:pointer;">
            <input type="radio" name="gender" value="m" checked style="accent-color:#4f46e5;"/> Male
          </label>
          <label style="display:flex; align-items:center; gap:6px; font-weight:400; cursor:pointer;">
            <input type="radio" name="gender" value="f" style="accent-color:#4f46e5;"/> Female
          </label>
          <label style="display:flex; align-items:center; gap:6px; font-weight:400; cursor:pointer;">
            <input type="radio" name="gender" value="others" style="accent-color:#4f46e5;"/> Other
          </label>
        </div>
      </div>
      <button type="submit" name="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:11px; margin-top:4px;">
        <i class="fa fa-user-plus"></i> Create Account
      </button>
    </form>

    <div style="text-align:center; margin-top:20px; font-size:13px; color:#64748b;">
      Already have an account? <a href="login.php" style="color:#4f46e5; font-weight:600;">Sign in</a>
    </div>
  </div>
</div>
</body>
</html>
