<?php
/**
 * Role-Based Access Control (RBAC) Configuration
 * Defines roles, permissions, and access control logic
 */

// Define roles
define('ROLE_ADMIN', 'admin');
define('ROLE_SUPPORT_STAFF', 'support_staff');
define('ROLE_USER', 'user');

// Define permissions
define('PERM_VIEW_DASHBOARD', 'view_dashboard');
define('PERM_MANAGE_USERS', 'manage_users');
define('PERM_MANAGE_TICKETS', 'manage_tickets');
define('PERM_MANAGE_QUOTES', 'manage_quotes');
define('PERM_VIEW_LOGS', 'view_logs');
define('PERM_CREATE_TICKET', 'create_ticket');
define('PERM_VIEW_OWN_TICKETS', 'view_own_tickets');
define('PERM_REQUEST_QUOTE', 'request_quote');
define('PERM_VIEW_OWN_QUOTES', 'view_own_quotes');
define('PERM_CHANGE_PASSWORD', 'change_password');
define('PERM_EDIT_PROFILE', 'edit_profile');

// Role-Permission Mapping
$rolePermissions = [
    ROLE_ADMIN => [
        PERM_VIEW_DASHBOARD,
        PERM_MANAGE_USERS,
        PERM_MANAGE_TICKETS,
        PERM_MANAGE_QUOTES,
        PERM_VIEW_LOGS,
        PERM_CHANGE_PASSWORD,
        PERM_EDIT_PROFILE,
    ],
    ROLE_SUPPORT_STAFF => [
        PERM_VIEW_DASHBOARD,
        PERM_MANAGE_TICKETS,
        PERM_MANAGE_QUOTES,
        PERM_CHANGE_PASSWORD,
        PERM_EDIT_PROFILE,
    ],
    ROLE_USER => [
        PERM_VIEW_DASHBOARD,
        PERM_CREATE_TICKET,
        PERM_VIEW_OWN_TICKETS,
        PERM_REQUEST_QUOTE,
        PERM_VIEW_OWN_QUOTES,
        PERM_CHANGE_PASSWORD,
        PERM_EDIT_PROFILE,
    ],
];

/**
 * Check if user has permission
 * @param string $permission Permission to check
 * @param array $user User data from session
 * @return bool
 */
function hasPermission($permission, $user = null) {
    global $rolePermissions;
    
    if ($user === null) {
        $user = $_SESSION['user'] ?? null;
    }
    
    if (!$user || !isset($user['role'])) {
        return false;
    }
    
    $role = $user['role'];
    
    return isset($rolePermissions[$role]) && 
           in_array($permission, $rolePermissions[$role]);
}

/**
 * Check if user has any of the given permissions
 * @param array $permissions Permissions to check
 * @param array $user User data from session
 * @return bool
 */
function hasAnyPermission($permissions, $user = null) {
    foreach ($permissions as $permission) {
        if (hasPermission($permission, $user)) {
            return true;
        }
    }
    return false;
}

/**
 * Check if user has all given permissions
 * @param array $permissions Permissions to check
 * @param array $user User data from session
 * @return bool
 */
function hasAllPermissions($permissions, $user = null) {
    foreach ($permissions as $permission) {
        if (!hasPermission($permission, $user)) {
            return false;
        }
    }
    return true;
}

/**
 * Get all permissions for a role
 * @param string $role Role name
 * @return array
 */
function getPermissionsForRole($role) {
    global $rolePermissions;
    return $rolePermissions[$role] ?? [];
}

/**
 * Get role display name
 * @param string $role Role name
 * @return string
 */
function getRoleDisplayName($role) {
    $roleNames = [
        ROLE_ADMIN => 'Administrator',
        ROLE_SUPPORT_STAFF => 'Support Staff',
        ROLE_USER => 'User',
    ];
    return $roleNames[$role] ?? ucfirst(str_replace('_', ' ', $role));
}

?>