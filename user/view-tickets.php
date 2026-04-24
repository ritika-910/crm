<?php
session_start();
include("../config/dbconnection.php");
include("../includes/checklogin.php");
check_login();

$email     = $_SESSION['login'];
$pageTitle  = "My Tickets";
$activeMenu = "tickets";
include("../includes/header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar"><a href="dashboard.php">Dashboard</a><span>/</span><span>My Tickets</span></div>
  <h2>My Support Tickets</h2>
  <p>Track status and replies from our support team</p>
</div>

<div style="display:flex; justify-content:flex-end; margin-bottom:16px;">
  <a href="user/create-ticket.php" class="btn btn-primary"><i class="fa fa-plus"></i> New Ticket</a>
</div>

<!--IMPORTANT: wrap content -->
<div id="ticketContainer">

<?php
$rt  = mysqli_query($con, "SELECT * FROM ticket WHERE email_id='$email' ORDER BY id DESC");
$num = mysqli_num_rows($rt);

if ($num === 0):
?>
  <div class="card"><div class="card-body">
    <div class="empty-state">
      <i class="fa fa-ticket"></i>
      <p>You haven't raised any tickets yet.</p>
      <a href="user/create-ticket.php" class="btn btn-primary" style="margin-top:12px; display:inline-flex;">
        <i class="fa fa-plus"></i> Create First Ticket
      </a>
    </div>
  </div></div>

<?php else: 
while ($row = mysqli_fetch_assoc($rt)):
    $isOpen  = $row['status'] === 'Open';
    $badge   = $isOpen ? 'badge-warning' : 'badge-success';
    $prioBadge = match($row['prioprity']) {
        'urgent'     => 'badge-danger',
        'important'  => 'badge-warning',
        'non-urgent' => 'badge-success',
        default      => 'badge-info'
    };
?>

  <div class="ticket-card">
    <div class="ticket-header">
      <div style="flex:1;">
        <div class="ticket-subject"><?= htmlspecialchars($row['subject']) ?></div>
        <div class="ticket-meta">
          <span>#<?= $row['ticket_id'] ?></span>
          <span><?= $row['posting_date'] ?></span>
          <span class="badge <?= $badge ?>"><?= $row['status'] ?></span>

          <?php if (!empty($row['prioprity'])): ?>
            <span class="badge <?= $prioBadge ?>"><?= ucfirst($row['prioprity']) ?></span>
          <?php endif; ?>

          <?php if (!empty($row['admin_remark'])): ?>
            <span class="badge badge-purple">Admin Replied</span>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="ticket-body">

      <div class="ticket-message">
        <strong>Your Message:</strong><br>
        <?= nl2br(htmlspecialchars($row['ticket'])) ?>
      </div>

      <?php if (!empty($row['admin_remark'])): ?>
        <div class="ticket-reply">
          <strong>Support Reply:</strong><br>
          <?= nl2br(htmlspecialchars($row['admin_remark'])) ?>
        </div>
      <?php else: ?>
        <div style="color:orange;">Awaiting reply...</div>
      <?php endif; ?>

    </div>
  </div>

<?php endwhile; endif; ?>

</div>

<!--REAL-TIME AUTO REFRESH SCRIPT -->
<script>
setInterval(function() {
    fetch(window.location.href)
    .then(response => response.text())
    .then(data => {
        let parser = new DOMParser();
        let doc = parser.parseFromString(data, 'text/html');
        let newContent = doc.getElementById('ticketContainer').innerHTML;
        document.getElementById('ticketContainer').innerHTML = newContent;
    });
}, 5000); // 5 sec me update
</script>

<?php include("../includes/footer.php"); ?>