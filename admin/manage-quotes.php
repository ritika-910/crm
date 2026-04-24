<?php
session_start();
include("../config/dbconnection.php");
include("checklogin.php");
check_login();

$pageTitle  = "Manage Quotes";
$activeMenu = "quotes";
include("header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar"><a href="home.php">Dashboard</a><span>/</span><span>Manage Quotes</span></div>
  <h2>Manage Quotes</h2>
  <p>All service quote requests submitted by users</p>
</div>

<div class="card">
  <div class="card-header">
    <h3><i class="fa fa-file-invoice" style="color:var(--primary);margin-right:8px;"></i>Quote Requests</h3>
    <span class="badge badge-purple"><?= mysqli_num_rows(mysqli_query($con,"SELECT id FROM prequest")) ?> Total</span>
  </div>
  <div class="table-wrapper">
    <table class="crm-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Services</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $serviceFields = ['wdd','cms','seo','smo','swd','dwd','fwd','dr','whs','wm','ed','wta','opi','ld','da','osc','nd','others'];
      $ret = mysqli_query($con, "SELECT * FROM prequest ORDER BY id DESC");
      $cnt = 1;
      $count = mysqli_num_rows($ret);
      if ($count > 0):
        while ($row = mysqli_fetch_assoc($ret)):
          $services = [];
          foreach ($serviceFields as $f) {
              if (!empty($row[$f])) $services[] = $row[$f];
          }
        $sLabel = !empty($services) 
    ? implode(', ', array_slice($services, 0, 2)) . 
      (count($services) > 2 ? ' +' . (count($services) - 2) . ' more' : '') 
    : '—';
      ?>
        <tr>
          <td style="color:var(--text-muted);"><?= $cnt++ ?></td>
          <td style="font-weight:500;"><?= htmlspecialchars($row['name']) ?></td>
          <td style="color:var(--text-muted); font-size:12px;"><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['contactno']) ?></td>
          <td style="font-size:12px; max-width:200px; color:var(--text-muted);"><?= htmlspecialchars($sLabel) ?></td>
          <td><span class="badge badge-gray"><?= $row['posting_date'] ?></span></td>
          <td>
            <a href="quote-details.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
              <i class="fa fa-eye"></i> View
            </a>
          </td>
        </tr>
      <?php endwhile; else: ?>
        <tr><td colspan="7">
          <div class="empty-state"><i class="fa fa-file-invoice"></i><p>No quote requests found.</p></div>
        </td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include("footer.php"); ?>
