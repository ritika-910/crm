<?php
session_start();
include("checklogin.php");
check_login();
include("../config/dbconnection.php");

$success = '';
if (isset($_POST['update'])) {
    $name    = mysqli_real_escape_string($con, trim($_POST['name']));
    $alt     = mysqli_real_escape_string($con, trim($_POST['altemail']));
    $contact = mysqli_real_escape_string($con, trim($_POST['contact']));
    $address = mysqli_real_escape_string($con, trim($_POST['address']));
    $gender  = mysqli_real_escape_string($con, $_POST['gender']);
    $uid     = (int)$_GET['id'];
    mysqli_query($con, "UPDATE user SET name='$name', alt_email='$alt', mobile='$contact', gender='$gender', address='$address' WHERE id='$uid'");
    $success = "Profile updated successfully.";
}

$uid = (int)$_GET['id'];
$rw  = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM user WHERE id='$uid'"));

$pageTitle  = "Edit User";
$activeMenu = "users";
include("header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar">
    <a href="home.php">Dashboard</a><span>/</span>
    <a href="manage-users.php">Users</a><span>/</span>
    <span>Edit</span>
  </div>
  <h2>Edit User — <?= htmlspecialchars($rw['name']) ?></h2>
</div>

<?php if ($success): ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?= $success ?></div>
<?php endif; ?>

<div class="card" style="max-width:680px;">
  <div class="card-header">
    <h3><i class="fa fa-pen" style="color:var(--primary);margin-right:8px;"></i>User Details</h3>
  </div>
  <div class="card-body">
    <form method="post" action="">
      <div class="form-grid">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($rw['name']) ?>" required/>
        </div>
        <div class="form-group">
          <label>Primary Email <small style="color:var(--text-muted);">(read only)</small></label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($rw['email']) ?>" readonly/>
        </div>
        <div class="form-group">
          <label>Alternate Email</label>
          <input type="email" name="altemail" class="form-control" value="<?= htmlspecialchars($rw['alt_email']) ?>"/>
        </div>
        <div class="form-group">
          <label>Contact Number</label>
          <input type="text" name="contact" class="form-control" value="<?= htmlspecialchars($rw['mobile']) ?>"/>
        </div>
        <div class="form-group">
          <label>Gender</label>
          <select name="gender" class="form-control">
            <option value="m"      <?= $rw['gender']==='m'      ? 'selected':'' ?>>Male</option>
            <option value="f"      <?= $rw['gender']==='f'      ? 'selected':'' ?>>Female</option>
            <option value="others" <?= $rw['gender']==='others' ? 'selected':'' ?>>Other</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>Address</label>
        <textarea name="address" class="form-control"><?= htmlspecialchars($rw['address']) ?></textarea>
      </div>
      <div style="display:flex; gap:10px;">
        <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
        <a href="manage-users.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
      </div>
    </form>
  </div>
</div>

<?php include("footer.php"); ?>
