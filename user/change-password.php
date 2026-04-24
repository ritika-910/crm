<?php
session_start();
error_reporting(0);
include("../includes/checklogin.php");
check_login();
include("../config/dbconnection.php");

$msg = ''; $msgType = '';
if (isset($_POST['change'])) {
    $email    = $_SESSION['login'];
    $newPass  = $_POST['newpass'];
    $confPass = $_POST['confirmpassword'];

    $res = mysqli_fetch_assoc(mysqli_query($con, "SELECT password FROM user WHERE email='$email'"));

    if (!$res || !password_verify($_POST['oldpass'], $res['password'])) {
        $msg = 'Current password is incorrect.'; $msgType = 'danger';
    } elseif ($newPass !== $confPass) {
        $msg = 'New passwords do not match.'; $msgType = 'danger';
    } elseif (strlen($newPass) < 6) {
        $msg = 'Password must be at least 6 characters.'; $msgType = 'danger';
    } else {
        $hashed = password_hash($newPass, PASSWORD_DEFAULT);
        $h = mysqli_real_escape_string($con, $hashed);
        mysqli_query($con, "UPDATE user SET password='$h' WHERE email='$email'");
        $msg = 'Password changed successfully!'; $msgType = 'success';
    }
}

$pageTitle  = "Change Password";
$activeMenu = "password";
include("../includes/header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar"><a href="dashboard.php">Dashboard</a><span>/</span><span>Change Password</span></div>
  <h2>Change Password</h2>
  <p>Keep your account secure by using a strong password</p>
</div>

<?php if ($msg): ?>
  <div class="alert alert-<?= $msgType ?>">
    <i class="fa fa-<?= $msgType==='success'?'check-circle':'circle-exclamation' ?>"></i> <?= $msg ?>
  </div>
<?php endif; ?>

<div class="card" style="max-width:480px;">
  <div class="card-header">
    <h3><i class="fa fa-lock" style="color:var(--primary); margin-right:8px;"></i>Update Password</h3>
  </div>
  <div class="card-body">
    <form method="post" action="">
      <div class="form-group">
        <label>Current Password</label>
        <div class="input-with-icon">
          <i class="fa fa-lock"></i>
          <input type="password" name="oldpass" class="form-control" placeholder="Enter current password" required/>
        </div>
      </div>
      <div class="form-group">
        <label>New Password</label>
        <div class="input-with-icon">
          <i class="fa fa-key"></i>
          <input type="password" name="newpass" class="form-control" placeholder="Min. 6 characters" required/>
        </div>
      </div>
      <div class="form-group">
        <label>Confirm New Password</label>
        <div class="input-with-icon">
          <i class="fa fa-key"></i>
          <input type="password" name="confirmpassword" class="form-control" placeholder="Re-enter new password" required/>
        </div>
      </div>
      <div style="display:flex; gap:10px;">
        <button type="submit" name="change" class="btn btn-primary"><i class="fa fa-save"></i> Update Password</button>
        <button type="reset" class="btn btn-secondary"><i class="fa fa-rotate-left"></i> Clear</button>
      </div>
    </form>
  </div>
</div>

<?php include("../includes/footer.php"); ?>
