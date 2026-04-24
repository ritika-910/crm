<?php
require_once __DIR__ . '/../config/auth.php';

/**
 * Check if user is logged in as admin
 */
function check_login() {
    checkLogin();
    
    // Ensure user has admin role
    $user = $_SESSION['user'] ?? null;
    if (!$user || $user['role'] !== ROLE_ADMIN) {
        header("HTTP/1.0 403 Forbidden");
        die('Access Denied: Admin access required.');
    }
}

?>