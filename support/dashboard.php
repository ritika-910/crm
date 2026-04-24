<?php
session_start();
require_once('../config/auth.php');
require_once('../config/dbconnection.php');
checkPermission(PERM_VIEW_DASHBOARD);

// Ensure user is support staff
$user = $_SESSION['user'];
if ($user['role'] !== ROLE_SUPPORT_STAFF) {
    header("HTTP/1.0 403 Forbidden");
    die('Access Denied: Support Staff access required.');
}

$pageTitle  = "Support Dashboard";
$activeMenu = "dashboard";

// Get statistics
$totalTickets = mysqli_num_rows(mysqli_query($con, "SELECT id FROM ticket"));
$openTickets  = mysqli_num_rows(mysqli_query($con, "SELECT id FROM ticket WHERE status='Open'"));
$totalQuotes  = mysqli_num_rows(mysqli_query($con, "SELECT id FROM prequest"));
$pendingQuotes = mysqli_num_rows(mysqli_query($con, "SELECT id FROM prequest WHERE status='0'"));

include("../includes/header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar"><a href="dashboard.php">Dashboard</a></div>
  <h2>Support Staff Dashboard</h2>
  <p>Manage customer tickets and quote requests</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon orange"><i class="fa fa-ticket"></i></div>
    <div class="stat-info">
      <div class="stat-value"><?= $totalTickets ?></div>
      <div class="stat-label">Total Tickets</div>
      <div class="stat-sub">Open: <span><?= $openTickets ?></span></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon purple"><i class="fa fa-file-invoice"></i></div>
    <div class="stat-info">
      <div class="stat-value"><?= $totalQuotes ?></div>
      <div class="stat-label">Quote Requests</div>
      <div class="stat-sub">Pending: <span><?= $pendingQuotes ?></span></div>
    </div>
  </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
  <!-- Manage Tickets -->
  <div class="card">
    <div class="card-header">
      <h3><i class="fa fa-ticket" style="color:var(--primary);margin-right:8px;"></i>Recent Tickets</h3>
      <a href="manage-tickets.php" class="btn btn-sm btn-outline">Manage All</a>
    </div>
    <div class="table-wrapper">
      <table class="crm-table">
        <thead><tr><th>Subject</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
        <?php
        $rt = mysqli_query($con, "SELECT subject, status, posting_date FROM ticket ORDER BY id DESC LIMIT 5");
        while ($row = mysqli_fetch_assoc($rt)):
            $badge = $row['status'] === 'Open' ? 'badge-warning' : 'badge-success';
        ?>
          <tr>
            <td><?= htmlspecialchars(mb_strimwidth($row['subject'], 0, 28, '…')) ?></td>
            <td><span class="badge <?= $badge ?>"><?= $row['status'] ?></span></td>
            <td><?= $row['posting_date'] ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Manage Quotes -->
  <div class="card">
    <div class="card-header">
      <h3><i class="fa fa-file-invoice" style="color:var(--success);margin-right:8px;"></i>Recent Quotes</h3>
      <a href="manage-quotes.php" class="btn btn-sm btn-outline">Manage All</a>
    </div>
    <div class="table-wrapper">
      <table class="crm-table">
        <thead><tr><th>Company</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
        <?php
        $rq = mysqli_query($con, "SELECT company, status, posting_date FROM prequest ORDER BY id DESC LIMIT 5");
        while ($row = mysqli_fetch_assoc($rq)):
            $badge = $row['status'] == '0' ? 'badge-warning' : 'badge-success';
        ?>
          <tr>
            <td><?= htmlspecialchars(mb_strimwidth($row['company'], 0, 28, '…')) ?></td>
            <td><span class="badge <?= $badge ?>"><?= $row['status'] == '0' ? 'New' : 'In Progress' ?></span></td>
            <td><?= $row['posting_date'] ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include("../includes/footer.php"); ?>