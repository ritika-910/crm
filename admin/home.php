<?php
session_start();
include("../config/dbconnection.php");
include("checklogin.php");
check_login();

$pageTitle  = "Dashboard";
$activeMenu = "dashboard";



// Stats queries
$totalVisitors   = mysqli_num_rows(mysqli_query($con, "SELECT id FROM usercheck"));
$todayDate       = date("Y/m/d");
$todayVisitors   = mysqli_num_rows(mysqli_query($con, "SELECT id FROM usercheck WHERE logindate='$todayDate'"));
$totalUsers      = mysqli_num_rows(mysqli_query($con, "SELECT id FROM user"));
$todayUsers      = mysqli_num_rows(mysqli_query($con, "SELECT id FROM user WHERE posting_date='".date('Y-m-d')."'"));
$totalQuotes     = mysqli_num_rows(mysqli_query($con, "SELECT id FROM prequest"));
$pendingQuotes   = mysqli_num_rows(mysqli_query($con, "SELECT id FROM prequest WHERE status='0'"));
$totalTickets    = mysqli_num_rows(mysqli_query($con, "SELECT id FROM ticket"));
$openTickets     = mysqli_num_rows(mysqli_query($con, "SELECT id FROM ticket WHERE status='Open'"));

// Build visitor chart data
$totalDays   = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"));
$dayCount    = array_fill(1, $totalDays, 0);
$visitResult = mysqli_query($con, "SELECT logindate FROM usercheck");
while ($row = mysqli_fetch_row($visitResult)) {
    $parts = explode('/', $row[0]);
    if (count($parts) === 3 && $parts[0] == date("Y") && (int)$parts[1] == (int)date("m")) {
        $day = (int)$parts[2];
        if (isset($dayCount[$day])) $dayCount[$day]++;
    }
}
$chartLabels = array_map(fn($d) => "Day $d", array_keys($dayCount));
$chartData   = array_values($dayCount);

include("header.php");
?>

<!-- Stats Grid -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon blue"><i class=""></i></div>
    <div class="stat-info">
      <div class="stat-value"><?= $totalVisitors ?></div>
      <div class="stat-label">Total Visitors</div>
      <div class="stat-sub">Today: <span><?= $todayVisitors ?></span></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green"><i class="fa fa-users"></i></div>
    <div class="stat-info">
      <div class="stat-value"><?= $totalUsers ?></div>
      <div class="stat-label">Registered Users</div>
      <div class="stat-sub">Today: <span><?= $todayUsers ?></span></div>
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
  <div class="stat-card">
    <div class="stat-icon orange"><i class="fa fa-ticket"></i></div>
    <div class="stat-info">
      <div class="stat-value"><?= $totalTickets ?></div>
      <div class="stat-label">Total Tickets</div>
      <div class="stat-sub">Open: <span><?= $openTickets ?></span></div>
    </div>
  </div>
</div>

<!-- Visitor Chart -->
<div class="chart-container">
  <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
    <div>
      <h3 style="font-size:15px; font-weight:600;">Daily Visitors — <?= date('F Y') ?></h3>
      <p style="font-size:12px; color:var(--text-muted); margin-top:2px;">Login activity this month</p>
    </div>
  </div>
  <canvas id="visitorChart" height="90"></canvas>
</div>

<!-- Recent Tickets & Quotes side by side -->
<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
  <!-- Recent Tickets -->
  <div class="card">
    <div class="card-header">
      <h3><i class="fa fa-ticket" style="color:var(--primary);margin-right:8px;"></i>Recent Tickets</h3>
      <a href="manage-tickets.php" class="btn btn-sm btn-outline">View All</a>
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

  <!-- Recent Users -->
  <div class="card">
    <div class="card-header">
      <h3><i class="fa fa-users" style="color:var(--success);margin-right:8px;"></i>Recent Users</h3>
      <a href="manage-users.php" class="btn btn-sm btn-outline">View All</a>
    </div>
    <div class="table-wrapper">
      <table class="crm-table">
        <thead><tr><th>Name</th><th>Email</th><th>Joined</th></tr></thead>
        <tbody>
        <?php
        $ru = mysqli_query($con, "SELECT name, email, posting_date FROM user ORDER BY id DESC LIMIT 5");
        while ($row = mysqli_fetch_assoc($ru)):
        ?>
          <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td style="color:var(--text-muted); font-size:12px;"><?= htmlspecialchars($row['email']) ?></td>
            <td><?= $row['posting_date'] ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('visitorChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($chartLabels) ?>,
    datasets: [{
      label: 'Visitors',
      data: <?= json_encode($chartData) ?>,
      borderColor: '#4f46e5',
      backgroundColor: 'rgba(79,70,229,0.08)',
      borderWidth: 2,
      pointBackgroundColor: '#4f46e5',
      pointRadius: 3,
      tension: 0.4,
      fill: true
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
      y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f1f5f9' } },
      x: { grid: { display: false } }
    }
  }
});
</script>

<?php include("footer.php"); ?>
