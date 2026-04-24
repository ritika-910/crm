<?php
/**
 * Authentication and Authorization Handler
 */

require_once __DIR__ . '/rbac.php';

/**
 * Check if user is logged in
 * Redirects to login if not authenticated
 */
function checkLogin() {
    if (empty($_SESSION['user_id']) || empty($_SESSION['user'])) {
        header("Location: " . getLoginPath());
        exit();
    }
}

/**
 * Check if user has required permission
 * Redirects to access denied page if not authorized
 * @param string|array $permission Permission or array of permissions
 */
function checkPermission($permission) {
    checkLogin();
    
    $permissions = is_array($permission) ? $permission : [$permission];
    
    if (!hasAnyPermission($permissions)) {
        header("HTTP/1.0 403 Forbidden");
        die('Access Denied: You do not have permission to access this page.');
    }
}

/**
 * Get login path based on user role
 * @return string
 */
function getLoginPath() {
    $user = $_SESSION['user'] ?? null;
    
    if ($user && $user['role'] === ROLE_ADMIN) {
        return 'admin/index.php';
    }
    
    return 'auth/login.php';
}

/**
 * Get dashboard path based on user role
 * @param string $role User role
 * @return string
 */
function getDashboardPath($role) {
    switch ($role) {
        case ROLE_ADMIN:
            return 'admin/home.php';
        case ROLE_SUPPORT_STAFF:
            return 'support/dashboard.php';
        case ROLE_USER:
        default:
            return 'user/dashboard.php';
    }
}

/**
 * Redirect user to appropriate dashboard based on role
 * @param string $role User role
 */
function redirectToDashboard($role) {
    $path = getDashboardPath($role);
    header("Location: $path");
    exit();
}

/**
 * Store user data in session
 * @param array $userData User data from database
 */
function setUserSession($userData) {
    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['user'] = [
        'id' => $userData['id'],
        'name' => $userData['name'],
        'email' => $userData['email'],
        'role' => $userData['role'],
    ];
    
    // Set role-specific session variables
    if ($userData['role'] === ROLE_ADMIN) {
        $_SESSION['alogin'] = $userData['name'];
    } elseif ($userData['role'] === ROLE_SUPPORT_STAFF) {
        $_SESSION['support_login'] = $userData['email'];
    } else {
        $_SESSION['login'] = $userData['email'];
    }
}

/**
 * Destroy user session (logout)
 */
function destroyUserSession() {
    session_unset();
    session_destroy();
}

?>