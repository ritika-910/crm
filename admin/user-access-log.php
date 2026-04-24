<?php
session_start();
include("../config/dbconnection.php");
include("checklogin.php");
check_login();

$pageTitle  = "User Access Log";
$activeMenu = "logs";
include("header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar"><a href="home.php">Dashboard</a><span>/</span><span>Access Log</span></div>
  <h2>User Access Log</h2>
  <p>Complete login history of all users</p>
</div>

<div class="card">
  <div class="card-header">
    <h3><i class="fa fa-clock-rotate-left" style="color:var(--primary);margin-right:8px;"></i>Login History</h3>
    <span class="badge badge-info"><?= mysqli_num_rows(mysqli_query($con,"SELECT id FROM usercheck")) ?> Records</span>
  </div>
  <div class="table-wrapper">
    <table class="crm-table">
      <thead>
        <tr>
          <th>User ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Login Date</th>
          <th>Login Time</th>
          <th>IP Address</th>
          <th>MAC Address</th> 
          <th>City / Country</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $ret = mysqli_query($con, "SELECT * FROM usercheck ORDER BY id DESC");
      $count = mysqli_num_rows($ret);
      if ($count > 0):
        while ($row = mysqli_fetch_assoc($ret)):
      ?>
        <tr>
          <td><span class="badge badge-gray">#<?= $row['user_id'] ?></span></td>
          <td style="font-weight:500;"><?= htmlspecialchars($row['username']) ?></td>
          <td style="color:var(--text-muted); font-size:12px;"><?= htmlspecialchars($row['email']) ?></td>
          <td><?= $row['logindate'] ?></td>
          <td><?= $row['logintime'] ?></td>
          <td><span class="badge badge-info"><?= htmlspecialchars($row['ip']) ?></span></td>
          <td style="font-size:12px; color:var(--text-muted);">
            <?= htmlspecialchars($row['city']) ?><?= !empty($row['country']) ? ', '.htmlspecialchars($row['country']) : '' ?>
          </td>
          <td><span class="badge badge-warning">
            <?= htmlspecialchars($row['mac']) ?>
        </span>
    </td>

    <td style="font-size:12px; color:var(--text-muted);">
        <?= htmlspecialchars($row['city']) ?>
        <?= !empty($row['country']) ? ', '.htmlspecialchars($row['country']) : '' ?>
    </td>
</tr>
        </tr>
        
      <?php endwhile; else: ?>
        <tr><td colspan="7">
          <div class="empty-state"><i class="fa fa-clock-rotate-left"></i><p>No login records found.</p></div>
        </td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include("footer.php"); ?>
