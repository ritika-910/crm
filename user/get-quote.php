<?php
session_start();
include("../config/dbconnection.php");
include("../includes/checklogin.php");
check_login();

$success = '';
if (isset($_POST['submit'])) {
    $uid     = (int)$_SESSION['id'];
    $udata   = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM user WHERE id='$uid'"));
    $name    = mysqli_real_escape_string($con, $udata['name']);
    $email   = mysqli_real_escape_string($con, $udata['email']);
    $contact = mysqli_real_escape_string($con, $udata['mobile']);
    $company = mysqli_real_escape_string($con, trim($_POST['company']));
    $query   = mysqli_real_escape_string($con, trim($_POST['query']));
    $pd      = date('Y-m-d');

    $services = ['wdd','cms','seo','smo','swd','dwd','fwd','dr','whs','wm','ed','wta','opi','ld','dba','osc','nd','others'];
    $vals = [];
    foreach ($services as $s) {
        $vals[$s] = isset($_POST[$s]) ? mysqli_real_escape_string($con, $_POST[$s]) : '';
    }

    mysqli_query($con, "INSERT INTO prequest(name,email,contactno,company,wdd,cms,seo,smo,swd,dwd,fwd,dr,whs,wm,ed,wta,opi,ld,da,osc,nd,others,query,posting_date,status)
        VALUES('$name','$email','$contact','$company',
        '{$vals['wdd']}','{$vals['cms']}','{$vals['seo']}','{$vals['smo']}',
        '{$vals['swd']}','{$vals['dwd']}','{$vals['fwd']}','{$vals['dr']}',
        '{$vals['whs']}','{$vals['wm']}','{$vals['ed']}','{$vals['wta']}',
        '{$vals['opi']}','{$vals['ld']}','{$vals['dba']}','{$vals['osc']}',
        '{$vals['nd']}','{$vals['other']}','$query','$pd','0')");
    $success = "Quote request submitted! We'll contact you soon.";
}

$uid   = (int)$_SESSION['id'];
$udata = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM user WHERE id='$uid'"));

$pageTitle  = "Request a Quote";
$activeMenu = "quote";
include("../includes/header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar"><a href="dashboard.php">Dashboard</a><span>/</span><span>Request Quote</span></div>
  <h2>Request a Service Quote</h2>
  <p>Select the services you need and we'll send you a custom quote</p>
</div>

<?php if ($success): ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?= $success ?>
    <a href="manage-quotes.php" style="margin-left:10px; font-weight:600;">View Quote History →</a>
  </div>
<?php endif; ?>

<form method="post" action="">
<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; align-items:start;">

  <!-- Left column -->
  <div>
    <div class="card">
      <div class="card-header"><h3><i class="fa fa-user" style="color:var(--primary); margin-right:8px;"></i>Your Details</h3></div>
      <div class="card-body">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($udata['name']) ?>" readonly/>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" value="<?= htmlspecialchars($udata['email']) ?>" readonly/>
        </div>
        <div class="form-group">
          <label>Contact</label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($udata['mobile']) ?>" readonly/>
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label>Company Name <span style="color:#dc2626;">*</span></label>
          <input type="text" name="company" class="form-control" placeholder="Your company name" required/>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3><i class="fa fa-pen" style="color:var(--primary); margin-right:8px;"></i>Project Description</h3></div>
      <div class="card-body">
        <div class="form-group" style="margin-bottom:0;">
          <label>Tell us about your requirements <span style="color:#dc2626;">*</span></label>
          <textarea name="query" class="form-control" rows="6"
            placeholder="Describe your project, goals, timeline, budget etc..." required></textarea>
        </div>
      </div>
    </div>
  </div>

  <!-- Right column — Services -->
  <div class="card">
    <div class="card-header"><h3><i class="fa fa-list-check" style="color:var(--success); margin-right:8px;"></i>Services Required</h3></div>
    <div class="card-body">
      <p style="font-size:13px; color:var(--text-muted); margin-bottom:14px;">Select all services you are interested in:</p>
      <div class="checkbox-grid">
        <?php
        $serviceList = [
          'wdnd' => 'Website Design & Development',
          'cms'  => 'CMS Development',
          'seo'  => 'SEO Optimization',
          'smo'  => 'Social Media (SMO)',
          'swd'  => 'Static Website Design',
          'dwd'  => 'Dynamic Website Design',
          'fwd'  => 'Flash Website Development',
          'dr'   => 'Domain Registration',
          'whs'  => 'Web Hosting Services',
          'wm'   => 'Website Maintenance',
          'ed'   => 'Ecommerce Development',
          'wta'  => 'Walk Through Animation',
          'opi'  => 'Online Payment Integration',
          'ld'   => 'Logo Design',
          'dba'  => 'Dashboard Application',
          'osc'  => 'Open Source Customization',
          'nd'   => 'Newsletter Design',
          'other'=> 'Others',
        ];
        foreach ($serviceList as $name => $label):
            $checked = ($name === 'wdnd') ? 'checked' : '';
        ?>
          <label class="checkbox-item">
            <input type="checkbox" name="<?= $name ?>" value="<?= $label ?>" <?= $checked ?> 
                   onchange="this.closest('.checkbox-item').classList.toggle('checked', this.checked)"/>
            <?= $label ?>
          </label>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

</div>

<div style="margin-top:4px; display:flex; gap:10px;">
  <button type="submit" name="submit" class="btn btn-primary" style="padding:11px 28px;">
    <i class="fa fa-paper-plane"></i> Submit Quote Request
  </button>
  <button type="reset" class="btn btn-secondary"><i class="fa fa-rotate-left"></i> Clear</button>
</div>
</form>

<?php include("../includes/footer.php"); ?>
