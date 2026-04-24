<?php
// $pageTitle must be set before including this file
// $activeMenu must be set before including this file (e.g. 'dashboard', 'users', 'tickets', 'quotes', 'logs', 'password')
$pageTitle  = $pageTitle  ?? 'CRM Admin';
$activeMenu = $activeMenu ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($pageTitle); ?> | CRM Admin</title>
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <!-- Custom CSS -->
  <link href="../assets/css/crm.css" rel="stylesheet"/>
</head>
<body>
<div class="crm-wrapper">

<!-- ── SIDEBAR ── -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <a href="home.php">
      <span class="logo-icon"><i class="fa-solid fa-chart-network"></i></span>
      CRM Admin
    </a>
  </div>

  <div class="sidebar-user">
    <img src="../assets/img/admin.png" alt="Admin"/>
    <div>
      <div class="user-name">Administrator</div>
      <div class="user-role">System Admin</div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-label">Main Menu</div>
    <a href="home.php"            class="<?= $activeMenu==='dashboard' ? 'active':'' ?>"><i class="fa fa-gauge-high"></i> Dashboard</a>
    <a href="manage-users.php"    class="<?= $activeMenu==='users'     ? 'active':'' ?>"><i class="fa fa-users"></i> Manage Users</a>
    <a href="manage-tickets.php"  class="<?= $activeMenu==='tickets'   ? 'active':'' ?>"><i class="fa fa-ticket"></i> Manage Tickets</a>
    <a href="manage-quotes.php"   class="<?= $activeMenu==='quotes'    ? 'active':'' ?>"><i class="fa fa-file-invoice"></i> Manage Quotes</a>
    <a href="user-access-log.php" class="<?= $activeMenu==='logs'      ? 'active':'' ?>"><i class="fa fa-clock-rotate-left"></i> Access Log</a>
    <div class="nav-label">Account</div>
    <a href="change-password.php" class="<?= $activeMenu==='password'  ? 'active':'' ?>"><i class="fa fa-lock"></i> Change Password</a>
    <a href="logout.php"><i class="fa fa-right-from-bracket"></i> Logout</a>
  </nav>
</aside>

<!-- ── TOPBAR ── -->
<div class="topbar">
  <div class="topbar-left">
    <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="fa fa-bars"></i></button>
    <span class="topbar-title"><?php echo htmlspecialchars($pageTitle); ?></span>
  </div>
  <div class="topbar-right">
    <div class="topbar-user" onclick="toggleUserMenu()">
      <img src="../assets/img/admin.png" alt="Admin"/>
      <span>Admin</span>
      <i class="fa fa-chevron-down" style="font-size:10px;"></i>
      <div class="dropdown-menu-custom" id="userDropdown">
        <a href="change-password.php"><i class="fa fa-lock"></i> Change Password</a>
        <a href="logout.php"><i class="fa fa-right-from-bracket"></i> Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- ── MAIN CONTENT ── -->
<main class="main-content">
