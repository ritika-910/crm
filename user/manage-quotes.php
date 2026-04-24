<?php
session_start();
include("../config/dbconnection.php");
include("../includes/checklogin.php");
check_login();

$email      = $_SESSION['login'];
$pageTitle  = "Quote History";
$activeMenu = "my-quotes";
include("../includes/header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar"><a href="dashboard.php">Dashboard</a><span>/</span><span>Quote History</span></div>
  <h2>My Quote Requests</h2>
  <p>All service quotation requests you have submitted</p>
</div>

<div style="display:flex; justify-content:flex-end; margin-bottom:16px;">
  <a href="get-quote.php" class="btn btn-primary"><i class="fa fa-plus"></i> New Quote Request</a>
</div>

<?php
$serviceFields = ['wdd','cms','seo','smo','swd','dwd','fwd','dr','whs','wm','ed','wta','opi','ld','da','osc','nd','others'];
$ret   = mysqli_query($con, "SELECT * FROM prequest WHERE email='$email' ORDER BY id DESC");
$count = mysqli_num_rows($ret);

if ($count === 0):
?>
  <div class="card"><div class="card-body">
    <div class="empty-state">
      <i class="fa fa-file-invoice"></i>
      <p>You haven't submitted any quote requests yet.</p>
      <a href="get-quote.php" class="btn btn-primary" style="margin-top:12px; display:inline-flex;">
        <i class="fa fa-plus"></i> Request First Quote
      </a>
    </div>
  </div></div>
<?php else:
  while ($row = mysqli_fetch_assoc($ret)):
    $services = [];
    foreach ($serviceFields as $f) {
        if (!empty($row[$f])) $services[] = $row[$f];
    }
    $statusBadge = $row['status'] == '0' ? 'badge-warning' : 'badge-success';
    $statusLabel = $row['status'] == '0' ? 'New' : 'In Progress';
?>
  <div class="card" style="margin-bottom:14px;">
    <div class="card-header">
      <div>
        <div style="font-weight:600; font-size:14px;"><?= htmlspecialchars($row['company']) ?></div>
        <div style="font-size:12px; color:var(--text-muted); margin-top:3px;">
          <i class="fa fa-calendar"></i> <?= $row['posting_date'] ?>
          &nbsp;·&nbsp;
          <?= count($services) ?> service<?= count($services)!==1?'s':'' ?> selected
        </div>
      </div>
      <div style="display:flex; align-items:center; gap:10px;">
        <span class="badge <?= $statusBadge ?>"><?= $statusLabel ?></span>
        <a href="quote-details.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline">
          <i class="fa fa-eye"></i> View Details
        </a>
      </div>
    </div>
    <?php if (!empty($services)): ?>
    <div class="card-body" style="padding:12px 20px;">
      <div style="display:flex; flex-wrap:wrap; gap:6px;">
        <?php foreach ($services as $svc): ?>
          <span class="badge badge-gray"><?= htmlspecialchars($svc) ?></span>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
<?php endwhile; endif; ?>

<?php include("../includes/footer.php"); ?>
