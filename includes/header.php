<?php
// Set $pageTitle and $activeMenu before including
$pageTitle  = $pageTitle  ?? 'CRM';
$activeMenu = $activeMenu ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($pageTitle) ?> | CRM</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link href="../assets/css/crm.css" rel="stylesheet"/>
</head>
<body>
<div class="crm-wrapper">

<!-- SIDEBAR  -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <a href="dashboard.php">
      <span class="logo-icon"><i class="fa-solid fa-chart-pie"></i></span>
      My CRM
    </a>
  </div>

  <div class="sidebar-user">
    <img src="assets/img/user.png" alt="User" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['name'] ?? 'User') ?>&background=4f46e5&color=fff&size=38'"/>
    <div>
      <div class="user-name"><?= htmlspecialchars($_SESSION['name'] ?? 'User') ?></div>
      <div class="user-role" style="color:#10b981;">● Online</div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-label">Main Menu</div>
    <a href="dashboard.php"    class="<?= $activeMenu==='dashboard' ? 'active':'' ?>"><i class="fa fa-gauge-high"></i> Dashboard</a>
    <a href="create-ticket.php" class="<?= $activeMenu==='create-ticket' ? 'active':'' ?>"><i class="fa fa-plus-circle"></i> Create Ticket</a>
    <a href="view-tickets.php"  class="<?= $activeMenu==='tickets' ? 'active':'' ?>"><i class="fa fa-ticket"></i> My Tickets</a>
    <a href="get-quote.php"     class="<?= $activeMenu==='quote' ? 'active':'' ?>"><i class="fa fa-file-invoice-dollar"></i> Request Quote</a>
    <a href="manage-quotes.php" class="<?= $activeMenu==='my-quotes' ? 'active':'' ?>"><i class="fa fa-clock-rotate-left"></i> Quote History</a>
    <div class="nav-label">Account</div>
    <a href="profile.php"          class="<?= $activeMenu==='profile' ? 'active':'' ?>"><i class="fa fa-user"></i> My Profile</a>
    <a href="change-password.php"  class="<?= $activeMenu==='password' ? 'active':'' ?>"><i class="fa fa-lock"></i> Change Password</a>
    <a href="logout.php"><i class="fa fa-right-from-bracket"></i> Logout</a>
  </nav>
</aside>

<!-- TOPBAR  -->
<div class="topbar">
  <div class="topbar-left">
    <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="fa fa-bars"></i></button>
    <span class="topbar-title"><?= htmlspecialchars($pageTitle) ?></span>
  </div>
  <div class="topbar-right">
    <div class="topbar-user" onclick="toggleUserMenu()">
      <img src="assets/img/user.png" alt="User" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['name'] ?? 'U') ?>&background=4f46e5&color=fff&size=32'"/>
      <span><?= htmlspecialchars($_SESSION['name'] ?? 'User') ?></span>
      <i class="fa fa-chevron-down" style="font-size:10px;"></i>
      <div class="dropdown-menu-custom" id="userDropdown">
        <a href="profile.php"><i class="fa fa-user"></i> My Profile</a>
        <a href="change-password.php"><i class="fa fa-lock"></i> Change Password</a>
        <a href="logout.php"><i class="fa fa-right-from-bracket"></i> Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- MAIN CONTENT -->
<main class="main-content">
