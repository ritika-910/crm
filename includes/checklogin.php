<?php
require_once __DIR__ . '/../config/auth.php';

// Check if user is logged in
function check_login() {
    checkLogin();
}

// Check if user has permission
function require_permission($permission) {
    checkPermission($permission);
}

?>