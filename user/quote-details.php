<?php
session_start();
include("../config/dbconnection.php");
check_login();
include("../includes/checklogin.php");

$qid   = (int)$_GET['id'];
$email = $_SESSION['login'];
$row   = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM prequest WHERE id='$qid' AND email='$email'"));
if (!$row) { header("Location: ../user/manage-quotes.php"); exit(); }

$serviceFields = [
    'wdd' => 'Website Design & Development', 'cms' => 'CMS', 'seo' => 'SEO',
    'smo' => 'SMO', 'swd' => 'Static Website', 'dwd' => 'Dynamic Website',
    'fwd' => 'Flash Website', 'dr' => 'Domain Registration', 'whs' => 'Web Hosting',
    'wm'  => 'Website Maintenance', 'ed' => 'Ecommerce', 'wta' => 'Walk Through Animation',
    'opi' => 'Online Payment', 'ld' => 'Logo Design', 'da' => 'Dashboard App',
    'osc' => 'Open Source', 'nd' => 'Newsletter Design', 'others' => 'Others'
];

$pageTitle  = "Quote Details";
$activeMenu = "my-quotes";
include("../includes/header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar">
    <a href="dashboard.php">Dashboard</a><span>/</span>
    <a href="manage-quotes.php">Quote History</a><span>/</span>
    <span>Details</span>
  </div>
  <h2>Quote Details</h2>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; align-items:start;">

  <div class="card">
    <div class="card-header"><h3><i class="fa fa-user" style="color:var(--primary); margin-right:8px;"></i>Request Info</h3></div>
    <div class="card-body">
      <table class="crm-table">
        <tr><td style="font-weight:500; width:110px;">Name</td><td><?= htmlspecialchars($row['name']) ?></td></tr>
        <tr><td style="font-weight:500;">Email</td><td><?= htmlspecialchars($row['email']) ?></td></tr>
        <tr><td style="font-weight:500;">Contact</td><td><?= htmlspecialchars($row['contactno']) ?></td></tr>
        <tr><td style="font-weight:500;">Company</td><td><?= htmlspecialchars($row['company']) ?></td></tr>
        <tr><td style="font-weight:500;">Submitted</td><td><?= $row['posting_date'] ?></td></tr>
        <tr>
          <td style="font-weight:500;">Status</td>
          <td><span class="badge <?= $row['status']=='0'?'badge-warning':'badge-success' ?>">
            <?= $row['status']=='0'?'New':'In Progress' ?>
          </span></td>
        </tr>
      </table>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><h3><i class="fa fa-list-check" style="color:var(--success); margin-right:8px;"></i>Services Selected</h3></div>
    <div class="card-body">
      <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:14px;">
        <?php foreach ($serviceFields as $field => $label): ?>
          <?php if (!empty($row[$field])): ?>
            <span class="badge badge-purple" style="padding:5px 12px; font-size:12px;">
              <i class="fa fa-check" style="margin-right:4px;"></i><?= $label ?>
            </span>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
      <?php if (!empty($row['query'])): ?>
        <div style="background:#f8fafc; border-radius:8px; padding:14px; font-size:13px;">
          <div style="font-weight:600; font-size:11px; color:var(--text-muted); text-transform:uppercase; margin-bottom:6px;">Your Description</div>
          <?= nl2br(htmlspecialchars($row['query'])) ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Admin Remark -->
<div class="card">
  <div class="card-header">
    <h3><i class="fa fa-reply" style="color:var(--warning); margin-right:8px;"></i>Admin Response / Quotation</h3>
  </div>
  <div class="card-body">
    <?php if (!empty($row['remark'])): ?>
      <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:16px; font-size:14px;">
        <div style="font-size:11px; font-weight:700; color:#2563eb; text-transform:uppercase; margin-bottom:8px;">
          <i class="fa fa-headset"></i> Response from Admin
        </div>
        <?= nl2br(htmlspecialchars($row['remark'])) ?>
      </div>
    <?php else: ?>
      <div style="background:#fef9c3; border:1px solid #fde68a; border-radius:8px; padding:14px; font-size:13px; color:#92400e;">
        <i class="fa fa-clock"></i> &nbsp;No response yet. Our team will review your request and respond soon.
      </div>
    <?php endif; ?>
  </div>
</div>

<a href="user/manage-quotes.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back to Quote History</a>

<?php include("../includes/footer.php"); ?>
