<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/database/Database.php';
require_once dirname(__DIR__) . '/includes/functions.php';

// Authentication Guard: Strict Admin-only access with ID and Password
if (empty($_SESSION['admin_logged_in'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? 'index.php';
    header('Location: login.php');
    exit;
}

$db = Database::getInstance();
$dbDriver = $db->getDriver();
$activeNav = $activeNav ?? 'dashboard';
$flash = getFlash();

$adminName = $_SESSION['admin_name'] ?? 'Administrator';
$adminUsername = $_SESSION['admin_username'] ?? 'admin';
$adminRole = $_SESSION['admin_role'] ?? 'admin';
$adminInitials = strtoupper(substr($adminName, 0, 2));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?= APP_NAME ?></title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Base Styles & Admin Theme -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-layout">
    <!-- Admin Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <div class="brand-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <div class="admin-sidebar-title">Student Education System</div>
                <div style="font-size:0.75rem; color:#64748b;">Admin Console</div>
            </div>
        </div>

        <nav class="admin-nav">
            <a href="index.php" class="admin-nav-item <?= ($activeNav === 'dashboard') ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            <a href="institutions.php" class="admin-nav-item <?= ($activeNav === 'institutions') ? 'active' : '' ?>">
                <i class="fas fa-university"></i> <span>Institutions</span>
            </a>
            <a href="courses.php" class="admin-nav-item <?= ($activeNav === 'courses') ? 'active' : '' ?>">
                <i class="fas fa-graduation-cap"></i> <span>Courses &amp; Degrees</span>
            </a>
            <a href="resources.php" class="admin-nav-item <?= ($activeNav === 'resources') ? 'active' : '' ?>">
                <i class="fas fa-book-reader"></i> <span>Study Resources</span>
            </a>
            <a href="inquiries.php" class="admin-nav-item <?= ($activeNav === 'inquiries') ? 'active' : '' ?>">
                <i class="fas fa-inbox"></i> <span>Student Inquiries</span>
            </a>
        </nav>

        <div class="admin-sidebar-footer">
            <a href="../setup.php" class="admin-nav-item" style="color:#38bdf8;">
                <i class="fas fa-database"></i> <span>Database &amp; Setup</span>
            </a>
            <a href="../index.php" class="admin-nav-item" style="color:#ffffff;">
                <i class="fas fa-external-link-alt"></i> <span>Public Website</span>
            </a>
            <a href="logout.php" class="admin-nav-item" style="color:#f87171; margin-top:8px;">
                <i class="fas fa-sign-out-alt"></i> <span>Sign Out</span>
            </a>
        </div>
    </aside>

    <!-- Content Area -->
    <div class="admin-content-wrapper">
        <header class="admin-topbar">
            <div style="font-weight:700; color:#0f172a; font-size:1.1rem; display:flex; align-items:center; gap:10px;">
                <i class="fas fa-shield-alt" style="color:#4f46e5;"></i>
                <span>Student Education System Control Console</span>
            </div>

            <div style="display:flex; align-items:center; gap:16px;">
                <div class="db-status-pill" style="background:#f1f5f9; color:#0284c7; border-color:#e2e8f0;">
                    <span class="status-dot"></span>
                    <span>Engine: <?= sanitize($dbDriver) ?></span>
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="width:36px; height:36px; border-radius:50%; background:#4f46e5; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.88rem;" title="<?= sanitize($adminName) ?> (<?= sanitize($adminUsername) ?>)">
                        <?= sanitize($adminInitials) ?>
                    </div>
                    <div style="line-height:1.2;">
                        <div style="font-size:0.88rem; font-weight:700; color:#0f172a;"><?= sanitize($adminName) ?></div>
                        <div style="font-size:0.75rem; color:#64748b;">@<?= sanitize($adminUsername) ?> (<?= sanitize($adminRole) ?>)</div>
                    </div>
                </div>
                <a href="logout.php" class="btn btn-sm" style="display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border:1px solid #fecaca; background:#fef2f2; color:#dc2626; border-radius:8px; text-decoration:none; font-weight:600; font-size:0.85rem; transition:all 0.2s ease;" title="Log out from Admin Console">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </a>
            </div>
        </header>

        <main class="admin-main">
            <?php if ($flash): ?>
                <div class="toast toast-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>" style="position:static; margin-bottom:24px;">
                    <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                    <span><?= sanitize($flash['message']) ?></span>
                </div>
            <?php endif; ?>
