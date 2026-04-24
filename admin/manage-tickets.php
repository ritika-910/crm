<?php
session_start();
include("../config/dbconnection.php");
include("checklogin.php");
check_login();

if (isset($_POST['update'])) {
    $remark = mysqli_real_escape_string($con, trim($_POST['aremark']));
    $fid    = (int)$_POST['frm_id'];
    mysqli_query($con, "UPDATE ticket SET admin_remark='$remark', status='closed', admin_remark_date='".date('Y-m-d')."' WHERE id='$fid'");
    $updated = true;
}

$pageTitle  = "Manage Tickets";
$activeMenu = "tickets";
include("header.php");
?>

<div class="page-header">
  <div class="breadcrumb-bar"><a href="home.php">Dashboard</a><span>/</span><span>Manage Tickets</span></div>
  <h2>Manage Tickets</h2>
  <p>Review and reply to all user support tickets</p>
</div>

<?php if (!empty($updated)): ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> Ticket updated successfully.</div>
<?php endif; ?>

<?php
$rt  = mysqli_query($con, "SELECT * FROM ticket ORDER BY id DESC");
$num = mysqli_num_rows($rt);
if ($num === 0):
?>
  <div class="card"><div class="card-body">
    <div class="empty-state"><i class="fa fa-ticket"></i><p>No tickets found.</p></div>
  </div></div>
<?php else: while ($row = mysqli_fetch_assoc($rt)):
    $isOpen  = $row['status'] === 'Open';
    $badge   = $isOpen ? 'badge-warning' : 'badge-success';
    $statusLabel = $isOpen ? 'Open' : 'Closed';
?>
  <div class="ticket-card">
    <div class="ticket-header">
      <div>
        <div class="ticket-subject"><?= htmlspecialchars($row['subject']) ?></div>
        <div class="ticket-meta">
          <span><i class="fa fa-hashtag"></i> Ticket #<?= $row['ticket_id'] ?></span>
          <span><i class="fa fa-user"></i> <?= htmlspecialchars($row['email_id']) ?></span>
          <span><i class="fa fa-calendar"></i> <?= $row['posting_date'] ?></span>
          <span class="badge <?= $badge ?>"><?= $statusLabel ?></span>
          <?php if (!empty($row['prioprity'])): ?>
            <span class="badge badge-info"><?= htmlspecialchars($row['prioprity']) ?></span>
          <?php endif; ?>
        </div>
      </div>
      <i class="fa fa-chevron-down toggle-icon" style="color:var(--text-muted);font-size:12px;"></i>
    </div>
    <div class="ticket-body">
      <div class="ticket-message">
        <div style="font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:8px;">
          <i class="fa fa-message"></i> User Message
        </div>
        <?= nl2br(htmlspecialchars($row['ticket'])) ?>
      </div>

      <?php if (!empty($row['admin_remark'])): ?>
        <div class="ticket-reply">
          <div class="reply-label"><i class="fa fa-reply"></i> Admin Reply — <?= $row['admin_remark_date'] ?></div>
          <?= nl2br(htmlspecialchars($row['admin_remark'])) ?>
        </div>
      <?php endif; ?>

      <form method="post" action="" style="margin-top:14px;">
        <div class="form-group">
          <label><?= empty($row['admin_remark']) ? 'Write a Reply' : 'Update Reply' ?></label>
          <textarea name="aremark" class="form-control" rows="3" required><?= htmlspecialchars($row['admin_remark']) ?></textarea>
        </div>
        <input type="hidden" name="frm_id" value="<?= $row['id'] ?>"/>
        <button type="submit" name="update" class="btn btn-primary btn-sm">
          <i class="fa fa-paper-plane"></i> <?= empty($row['admin_remark']) ? 'Send Reply & Close' : 'Update Reply' ?>
        </button>
      </form>
    </div>
  </div>
<?php endwhile; endif; ?>

<?php include("footer.php"); ?>
