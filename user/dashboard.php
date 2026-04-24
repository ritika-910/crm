<?php
session_start();
include("../includes/checklogin.php");
include("../config/dbconnection.php");
check_login();


$email        = $_SESSION['login'];
$totalTickets = mysqli_num_rows(mysqli_query($con, "SELECT id FROM ticket WHERE email_id='$email'"));
$openTickets  = mysqli_num_rows(mysqli_query($con, "SELECT id FROM ticket WHERE email_id='$email' AND status='Open'"));
$totalQuotes  = mysqli_num_rows(mysqli_query($con, "SELECT id FROM prequest WHERE email='$email'"));

$pageTitle  = "Dashboard";
$activeMenu = "dashboard";
include("../includes/header.php");
?>

<!-- Welcome Banner -->
<div style="background:linear-gradient(135deg,#4f46e5,#7c3aed); border-radius:14px; padding:28px 32px; color:#fff; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
  <div>
    <h2 style="font-size:22px; font-weight:700; margin-bottom:6px;">
      Welcome back, <?= htmlspecialchars($_SESSION['name']) ?>! 
    </h2>
    <p style="opacity:0.85; font-size:14px;">Here's a summary of your activity</p>
  </div>
  <div style="display:flex; gap:10px; flex-wrap:wrap;">
    <a href="user/create-ticket.php" class="btn btn-secondary" style="background:rgba(255,255,255,0.15); color:#fff; border:none;">
      <i class="fa fa-plus"></i> New Ticket
    </a>
    <a href="user/get-quote.php" class="btn btn-secondary" style="background:#fff; color:#4f46e5; border:none; font-weight:600;">
      <i class="fa fa-file-invoice-dollar"></i> Get Quote
    </a>
  </div>
</div>

<!-- Stats -->
<div class="stats-grid" style="grid-template-columns:repeat(3,1fr); margin-bottom:24px;">
  <div class="stat-card">
    <div class="stat-icon blue"><i class="fa fa-ticket"></i></div>
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
      <div class="stat-sub"><span>View history</span></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green"><i class="fa fa-circle-check"></i></div>
    <div class="stat-info">
      <div class="stat-value"><?= $totalTickets - $openTickets ?></div>
      <div class="stat-label">Resolved Tickets</div>
      <div class="stat-sub"><span>Closed</span></div>
    </div>
  </div>
</div>

<!-- Quick Actions -->
<div class="card" style="margin-bottom:20px;">
  <div class="card-header"><h3><i class="fa fa-bolt" style="color:#f59e0b; margin-right:8px;"></i>Quick Actions</h3></div>
  <div class="card-body">
    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px;">
      <a href="user/create-ticket.php" style="text-decoration:none;">
        <div style="border:1.5px solid #e0e7ff; border-radius:10px; padding:18px; text-align:center; transition:all 0.2s;" onmouseover="this.style.borderColor='#4f46e5'; this.style.background='#f0f4ff'" onmouseout="this.style.borderColor='#e0e7ff'; this.style.background='#fff'">
          <div style="font-size:24px; color:#4f46e5; margin-bottom:8px;"><i class="fa fa-plus-circle"></i></div>
          <div style="font-weight:600; font-size:13px; color:#1e293b;">Create Ticket</div>
          <div style="font-size:11px; color:#64748b; margin-top:3px;">Raise a support request</div>
        </div>
      </a>
      <a href="user/view-tickets.php" style="text-decoration:none;">
        <div style="border:1.5px solid #e0e7ff; border-radius:10px; padding:18px; text-align:center; transition:all 0.2s;" onmouseover="this.style.borderColor='#4f46e5'; this.style.background='#f0f4ff'" onmouseout="this.style.borderColor='#e0e7ff'; this.style.background='#fff'">
          <div style="font-size:24px; color:#16a34a; margin-bottom:8px;"><i class="fa fa-list-check"></i></div>
          <div style="font-weight:600; font-size:13px; color:#1e293b;">View Tickets</div>
          <div style="font-size:11px; color:#64748b; margin-top:3px;">Check status & replies</div>
        </div>
      </a>
      <a href="user/get-quote.php" style="text-decoration:none;">
        <div style="border:1.5px solid #e0e7ff; border-radius:10px; padding:18px; text-align:center; transition:all 0.2s;" onmouseover="this.style.borderColor='#4f46e5'; this.style.background='#f0f4ff'" onmouseout="this.style.borderColor='#e0e7ff'; this.style.background='#fff'">
          <div style="font-size:24px; color:#7c3aed; margin-bottom:8px;"><i class="fa fa-file-invoice-dollar"></i></div>
          <div style="font-weight:600; font-size:13px; color:#1e293b;">Request Quote</div>
          <div style="font-size:11px; color:#64748b; margin-top:3px;">Get a service estimate</div>
        </div>
      </a>
      <a href="user/profile.php" style="text-decoration:none;">
        <div style="border:1.5px solid #e0e7ff; border-radius:10px; padding:18px; text-align:center; transition:all 0.2s;" onmouseover="this.style.borderColor='#4f46e5'; this.style.background='#f0f4ff'" onmouseout="this.style.borderColor='#e0e7ff'; this.style.background='#fff'">
          <div style="font-size:24px; color:#ea580c; margin-bottom:8px;"><i class="fa fa-user-pen"></i></div>
          <div style="font-weight:600; font-size:13px; color:#1e293b;">My Profile</div>
          <div style="font-size:11px; color:#64748b; margin-top:3px;">Update your details</div>
        </div>
      </a>
    </div>
  </div>
</div>

<!-- Recent Tickets -->
<div class="card">
  <div class="card-header">
    <h3><i class="fa fa-ticket" style="color:var(--primary); margin-right:8px;"></i>My Recent Tickets</h3>
    <a href="user/view-tickets.php" class="btn btn-sm btn-outline">View All</a>
  </div>
  <div class="table-wrapper">
    <table class="crm-table">
      <thead><tr><th>Subject</th><th>Priority</th><th>Status</th><th>Date</th></tr></thead>
      <tbody>
      <?php
      $rt = mysqli_query($con, "SELECT * FROM ticket WHERE email_id='$email' ORDER BY id DESC LIMIT 5");
      $n  = mysqli_num_rows($rt);
      if ($n > 0):
        while ($row = mysqli_fetch_assoc($rt)):
          $badge = $row['status'] === 'Open' ? 'badge-warning' : 'badge-success';
      ?>
        <tr>
          <td style="font-weight:500;"><?= htmlspecialchars($row['subject']) ?></td>
          <td><span class="badge badge-info"><?= htmlspecialchars($row['prioprity'] ?: '—') ?></span></td>
          <td><span class="badge <?= $badge ?>"><?= $row['status'] ?></span></td>
          <td style="font-size:12px; color:var(--text-muted);"><?= $row['posting_date'] ?></td>
        </tr>
      <?php endwhile; else: ?>
        <tr><td colspan="4">
          <div class="empty-state" style="padding:30px 0;">
            <i class="fa fa-ticket"></i>
            <p>No tickets yet. <a href="create-ticket.php" style="color:#4f46e5;">Create your first ticket</a></p>
          </div>
        </td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include("../includes/footer.php"); ?>
