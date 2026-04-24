<?php
session_start();
include("../config/dbconnection.php");
include("checklogin.php");
check_login();

// Delete user
if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    mysqli_query($con, "DELETE FROM user WHERE id='$id'");
    header("Location: manage-users.php?deleted=1");
    exit();
}

$pageTitle  = "Manage Users";
$activeMenu = "users";
include("header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar"><a href="home.php">Dashboard</a><span>/</span><span>Manage Users</span></div>
  <h2>Manage Users</h2>
  <p>View, edit and delete registered users</p>
</div>

<?php if (isset($_GET['deleted'])): ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> User deleted successfully.</div>
<?php endif; ?>

<div class="card">
  <div class="card-header">
    <h3><i class="fa fa-users" style="color:var(--primary);margin-right:8px;"></i>All Users</h3>
    <span class="badge badge-info"><?= mysqli_num_rows(mysqli_query($con,"SELECT id FROM user")) ?> Total</span>
  </div>
  <div class="table-wrapper">
    <table class="crm-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Registered On</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $ret = mysqli_query($con, "SELECT * FROM user ORDER BY id DESC");
      $cnt = 1;
      $count = mysqli_num_rows($ret);
      if ($count > 0):
        while ($row = mysqli_fetch_assoc($ret)):
      ?>
        <tr>
          <td style="color:var(--text-muted);"><?= $cnt++ ?></td>
          <td style="font-weight:500;"><?= htmlspecialchars($row['name']) ?></td>
          <td style="color:var(--text-muted); font-size:12px;"><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['mobile']) ?></td>
          <td><span class="badge badge-gray"><?= $row['posting_date'] ?></span></td>
          <td style="display:flex; gap:6px; flex-wrap:wrap;">
            <a href="edit-user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
              <i class="fa fa-pen"></i> Edit
            </a>
            <a href="manage-users.php?del=<?= $row['id'] ?>" class="btn btn-sm btn-danger btn-delete-confirm">
              <i class="fa fa-trash"></i> Delete
            </a>
          </td>
        </tr>
      <?php endwhile; else: ?>
        <tr><td colspan="6">
          <div class="empty-state"><i class="fa fa-users"></i><p>No users found.</p></div>
        </td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include("footer.php"); ?>
