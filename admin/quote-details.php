<?php
session_start();
include("../config/dbconnection.php");
include("checklogin.php");
check_login();

$success = '';
if (isset($_POST['remark'])) {
    $remark = mysqli_real_escape_string($con, trim($_POST['adminremark']));
    $qid    = (int)$_GET['id'];
    mysqli_query($con, "UPDATE prequest SET remark='$remark', status='1' WHERE id='$qid'");
    $success = "Remark saved successfully.";
}

$qid = (int)$_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM prequest WHERE id='$qid'"));

$serviceFields = [
    'wdd' => 'Website Design & Development', 'cms' => 'CMS', 'seo' => 'SEO', 'smo' => 'SMO',
    'swd' => 'Static Website Design', 'dwd' => 'Dynamic Website Design', 'fwd' => 'Flash Website Development',
    'dr' => 'Domain Registration', 'whs' => 'Web Hosting', 'wm' => 'Website Maintenance',
    'ed' => 'Ecommerce Development', 'wta' => 'Walk Through Animation', 'opi' => 'Online Payment Integration',
    'ld' => 'Logo Design', 'da' => 'Dashboard Application', 'osc' => 'Open Source Customization',
    'nd' => 'Newsletter Design', 'others' => 'Others'
];

$pageTitle  = "Quote Details";
$activeMenu = "quotes";
include("header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar">
    <a href="home.php">Dashboard</a><span>/</span>
    <a href="manage-quotes.php">Quotes</a><span>/</span>
    <span>Details</span>
  </div>
  <h2>Quote — <?= htmlspecialchars($row['name']) ?></h2>
</div>

<?php if ($success): ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?= $success ?></div>
<?php endif; ?>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; align-items:start;">

  <!-- Customer Info -->
  <div class="card">
    <div class="card-header"><h3><i class="fa fa-user" style="color:var(--primary);margin-right:8px;"></i>Customer Info</h3></div>
    <div class="card-body">
      <table class="crm-table">
        <tr><td style="font-weight:500; width:120px;">Name</td><td><?= htmlspecialchars($row['name']) ?></td></tr>
        <tr><td style="font-weight:500;">Email</td><td><?= htmlspecialchars($row['email']) ?></td></tr>
        <tr><td style="font-weight:500;">Contact</td><td><?= htmlspecialchars($row['contactno']) ?></td></tr>
        <tr><td style="font-weight:500;">Company</td><td><?= htmlspecialchars($row['company']) ?></td></tr>
        <tr><td style="font-weight:500;">Date</td><td><?= $row['posting_date'] ?></td></tr>
      </table>
    </div>
  </div>

  <!-- Services Selected -->
  <div class="card">
    <div class="card-header"><h3><i class="fa fa-list-check" style="color:var(--success);margin-right:8px;"></i>Services Required</h3></div>
    <div class="card-body">
      <div style="display:flex; flex-wrap:wrap; gap:8px;">
      <?php foreach ($serviceFields as $field => $label): ?>
        <?php if (!empty($row[$field])): ?>
          <span class="badge badge-purple" style="padding:5px 12px; font-size:12px;">
            <i class="fa fa-check" style="margin-right:4px;"></i><?= $label ?>
          </span>
        <?php endif; ?>
      <?php endforeach; ?>
      </div>
      <?php if (!empty($row['query'])): ?>
        <div style="margin-top:14px; padding:12px; background:#f8fafc; border-radius:8px; font-size:13px;">
          <div style="font-weight:600; margin-bottom:6px; color:var(--text-muted); font-size:11px; text-transform:uppercase;">Description</div>
          <?= nl2br(htmlspecialchars($row['query'])) ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Admin Remark -->
<div class="card">
  <div class="card-header">
    <h3><i class="fa fa-reply" style="color:var(--warning);margin-right:8px;"></i>Admin Remark / Quotation</h3>
  </div>
  <div class="card-body">
    <form method="post" action="">
      <div class="form-group">
        <label><?= empty($row['remark']) ? 'Write your remark or quote' : 'Update remark' ?></label>
        <textarea name="adminremark" class="form-control" rows="5"><?= htmlspecialchars($row['remark']) ?></textarea>
      </div>
      <div style="display:flex; gap:10px;">
        <button type="submit" name="remark" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Save Remark</button>
        <a href="manage-quotes.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
      </div>
    </form>
  </div>
</div>

<?php include("footer.php"); ?>
