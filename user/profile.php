<?php
session_start();
include("../config/dbconnection.php");
include("../includes/checklogin.php");
check_login();

$success = '';
if (isset($_POST['update'])) {
    $name    = mysqli_real_escape_string($con, trim($_POST['name']));
    $alt     = mysqli_real_escape_string($con, trim($_POST['alt_email']));
    $mobile  = mysqli_real_escape_string($con, trim($_POST['phone']));
    $gender  = mysqli_real_escape_string($con, $_POST['gender']);
    $address = mysqli_real_escape_string($con, trim($_POST['address']));
    $email   = $_SESSION['login'];

    mysqli_query($con, "UPDATE user SET name='$name', mobile='$mobile', gender='$gender',
                        alt_email='$alt', address='$address' WHERE email='$email'");
    $_SESSION['name'] = $name;
    $success = "Profile updated successfully!";
}

$email = $_SESSION['login'];
$row   = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM user WHERE email='$email'"));

$pageTitle  = "My Profile";
$activeMenu = "profile";
include("../includes/header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar"><a href="dashboard.php">Dashboard</a><span>/</span><span>My Profile</span></div>
  <h2>My Profile</h2>
  <p>Update your personal information</p>
</div>

<?php if ($success): ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?= $success ?></div>
<?php endif; ?>

<div style="display:grid; grid-template-columns:260px 1fr; gap:20px; align-items:start;">

  <!-- Profile card -->
  <div class="card" style="text-align:center;">
    <div class="card-body">
      <div style="width:80px; height:80px; border-radius:50%; background:#4f46e5; display:flex; align-items:center; justify-content:center; font-size:32px; color:#fff; margin:0 auto 16px; font-weight:700;">
        <?= strtoupper(substr($row['name'], 0, 1)) ?>
      </div>
      <div style="font-size:16px; font-weight:700; color:var(--text-main);"><?= htmlspecialchars($row['name']) ?></div>
      <div style="font-size:13px; color:var(--text-muted); margin-top:4px;"><?= htmlspecialchars($row['email']) ?></div>
      <div style="margin-top:12px;">
        <span class="badge badge-success"><i class="fa fa-circle"></i> Active</span>
      </div>
      <div style="margin-top:16px; font-size:12px; color:var(--text-muted); border-top:1px solid var(--border); padding-top:14px;">
        Member since<br/><strong><?= $row['posting_date'] ?></strong>
      </div>
    </div>
  </div>

  <!-- Edit form -->
  <div class="card">
    <div class="card-header">
      <h3><i class="fa fa-user-pen" style="color:var(--primary); margin-right:8px;"></i>Edit Information</h3>
    </div>
    <div class="card-body">
      <form method="post" action="">
        <div class="form-grid">
          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required/>
          </div>
          <div class="form-group">
            <label>Primary Email <small style="color:var(--text-muted);">(cannot change)</small></label>
            <input type="email" class="form-control" value="<?= htmlspecialchars($row['email']) ?>" readonly/>
          </div>
          <div class="form-group">
            <label>Alternate Email</label>
            <input type="email" name="alt_email" class="form-control" value="<?= htmlspecialchars($row['alt_email']) ?>" placeholder="Optional"/>
          </div>
          <div class="form-group">
            <label>Contact Number</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($row['mobile']) ?>" placeholder="10 digit number"/>
          </div>
          <div class="form-group">
            <label>Gender</label>
            <select name="gender" class="form-control">
              <option value="m"      <?= $row['gender']==='m'      ? 'selected':'' ?>>Male</option>
              <option value="f"      <?= $row['gender']==='f'      ? 'selected':'' ?>>Female</option>
              <option value="others" <?= $row['gender']==='others' ? 'selected':'' ?>>Other</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>Address</label>
          <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($row['address']) ?></textarea>
        </div>
        <div style="display:flex; gap:10px;">
          <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
          <button type="reset" class="btn btn-secondary"><i class="fa fa-rotate-left"></i> Reset</button>
        </div>
      </form>
    </div>
  </div>

</div>

<?php include("../includes/footer.php"); ?>
