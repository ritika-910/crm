<?php
session_start();
include("../config/dbconnection.php");
include("../includes/checklogin.php");
check_login();

$success = '';
if (isset($_POST['send'])) {
    $email    = $_SESSION['login'];
    $subject  = mysqli_real_escape_string($con, trim($_POST['subject']));
    $tt       = mysqli_real_escape_string($con, $_POST['tasktype']);
    $priority = mysqli_real_escape_string($con, $_POST['priority']);
    $ticket   = mysqli_real_escape_string($con, trim($_POST['description']));
    $pdate    = date('Y-m-d');

    mysqli_query($con, "INSERT INTO ticket(email_id, subject, task_type, priority, ticket, status, posting_date)
                        VALUES('$email','$subject','$tt','$priority','$ticket','Open','$pdate')");
    $success = "Ticket created successfully! You can track it in My Tickets.";
}

$pageTitle  = "Create Ticket";
$activeMenu = "create-ticket";
include("../includes/header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar"><a href="dashboard.php">Dashboard</a><span>/</span><span>Create Ticket</span></div>
  <h2>Create Support Ticket</h2>
  <p>Describe your issue and we'll get back to you as soon as possible</p>
</div>

<?php if ($success): ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?= $success ?>
    <a href="view-tickets.php" style="margin-left:10px; font-weight:600;">View My Tickets →</a>
  </div>
<?php endif; ?>

<div class="card" style="max-width:680px;">
  <div class="card-header">
    <h3><i class="fa fa-plus-circle" style="color:var(--primary); margin-right:8px;"></i>New Ticket</h3>
  </div>
  <div class="card-body">
    <form method="post" action="">
      <div class="form-group">
        <label>Subject <span style="color:#dc2626;">*</span></label>
        <input type="text" name="subject" class="form-control" placeholder="Brief description of your issue" required/>
      </div>
      <div class="form-grid">
        <div class="form-group">
          <label>Task Type <span style="color:#dc2626;">*</span></label>
          <select name="tasktype" class="form-control" required>
            <option value="">— Select Task Type —</option>
            <option value="billing">Billing</option>
            <option value="technical">Technical Issue</option>
            <option value="general">General Query</option>
            <option value="feature">Feature Request</option>
          </select>
        </div>
        <div class="form-group">
          <label>Priority <span style="color:#dc2626;">*</span></label>
          <select name="priority" class="form-control" required>
            <option value="">— Select Priority —</option>
            <option value="urgent">🔴 Urgent (Functional Problem)</option>
            <option value="important">🟠 Important</option>
            <option value="non-urgent">🟢 Non-Urgent</option>
            <option value="question">🔵 Question</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>Description <span style="color:#dc2626;">*</span></label>
        <textarea name="description" class="form-control" rows="6"
          placeholder="Please describe your issue in detail..." required></textarea>
      </div>
      <div style="display:flex; gap:10px;">
        <button type="submit" name="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Submit Ticket</button>
        <button type="reset" class="btn btn-secondary"><i class="fa fa-rotate-left"></i> Clear</button>
      </div>
    </form>
  </div>
</div>

<?php include("../includes/footer.php"); ?>
