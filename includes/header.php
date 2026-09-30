<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/database/Database.php';
require_once dirname(__DIR__) . '/includes/functions.php';

$db = Database::getInstance();
$dbDriver = $db->getDriver();
$pageTitle = $pageTitle ?? APP_NAME;
$metaDescription = $metaDescription ?? APP_TAGLINE;
$activePage = $activePage ?? '';
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize($pageTitle) ?></title>
    <meta name="description" content="<?= sanitize($metaDescription) ?>">
    
    <!-- Google Fonts & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Header Navigation -->
<header class="navbar" id="mainNavbar">
    <div class="container nav-container">
        <a href="index.php" class="brand-logo" id="brandLogo" title="Student Education System">
            <div class="brand-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="brand-text">
                <span class="brand-main">Student Education</span>
                <span class="brand-sub">System</span>
            </div>
        </a>

        <nav class="nav-links" id="primaryNav">
            <a href="index.php" class="nav-link <?= ($activePage === 'home') ? 'active' : '' ?>">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="courses.php" class="nav-link <?= ($activePage === 'courses') ? 'active' : '' ?>">
                <i class="fas fa-book-open"></i> Courses
            </a>
            <a href="schools.php" class="nav-link <?= ($activePage === 'schools') ? 'active' : '' ?>">
                <i class="fas fa-school"></i> Schools
            </a>
            <a href="colleges.php" class="nav-link <?= ($activePage === 'colleges') ? 'active' : '' ?>">
                <i class="fas fa-graduation-cap"></i> Colleges
            </a>
            <a href="inquiry.php" class="nav-link <?= ($activePage === 'inquiry') ? 'active' : '' ?>">
                <i class="fas fa-user-graduate"></i> Admissions
            </a>

            <!-- Header Popup Dropdown Option (More) -->
            <div class="nav-item-dropdown" id="moreOptionsDropdown">
                <button type="button" class="dropdown-trigger-btn" id="moreMenuBtn" aria-haspopup="true" aria-expanded="false" title="Click to view more options">
                    <i class="fas fa-th-large" style="color:var(--primary);"></i>
                    <span>More</span>
                    <i class="fas fa-chevron-down chevron-icon"></i>
                </button>

                <div class="nav-popup-menu" id="morePopupMenu" role="menu">
                    <div class="nav-popup-header">
                        <span class="nav-popup-header-title">Additional Educational Portals</span>
                    </div>

                    <a href="resources.php" class="nav-popup-item <?= ($activePage === 'resources') ? 'active' : '' ?>" role="menuitem">
                        <div class="nav-popup-icon" style="background:#eff6ff; color:#2563eb;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div>
                            <div class="nav-popup-title">Study Resources</div>
                            <div class="nav-popup-desc">Free lecture notes &amp; board papers</div>
                        </div>
                    </a>

                    <a href="institutions.php" class="nav-popup-item <?= ($activePage === 'institutions') ? 'active' : '' ?>" role="menuitem">
                        <div class="nav-popup-icon" style="background:#f0fdf4; color:#10b981;">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <div>
                            <div class="nav-popup-title">All Institutions</div>
                            <div class="nav-popup-desc">Browse 680+ Gujarat campuses</div>
                        </div>
                    </a>

                    <a href="about.php" class="nav-popup-item <?= ($activePage === 'about') ? 'active' : '' ?>" role="menuitem">
                        <div class="nav-popup-icon" style="background:#fef3c7; color:#b45309;">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <div class="nav-popup-title">About Portal</div>
                            <div class="nav-popup-desc">Purpose &amp; Kiran Chaudhary credit</div>
                        </div>
                    </a>

                    <a href="feedback.php" class="nav-popup-item <?= ($activePage === 'feedback') ? 'active' : '' ?>" role="menuitem">
                        <div class="nav-popup-icon" style="background:#f5f3ff; color:#7c3aed;">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <div class="nav-popup-title">Student Feedback</div>
                            <div class="nav-popup-desc">Share 1-5 star reviews &amp; ratings</div>
                        </div>
                    </a>

                    <a href="contact.php" class="nav-popup-item <?= ($activePage === 'contact') ? 'active' : '' ?>" role="menuitem">
                        <div class="nav-popup-icon" style="background:#ecfeff; color:#0891b2;">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <div class="nav-popup-title">Contact &amp; Helpline</div>
                            <div class="nav-popup-desc">Direct support (+91 70464 83464)</div>
                        </div>
                    </a>

                    <div style="border-top:1px solid #f1f5f9; margin-top:4px; padding-top:6px; display:flex; justify-content:space-between; gap:8px;">
                        <a href="setup.php" class="nav-popup-item" role="menuitem" style="flex:1; padding:8px 10px;">
                            <div class="nav-popup-icon" style="width:30px; height:30px; font-size:0.85rem; background:#f1f5f9; color:#475569;">
                                <i class="fas fa-database"></i>
                            </div>
                            <div class="nav-popup-title" style="font-size:0.82rem;">Database</div>
                        </a>
                        <a href="admin/index.php" class="nav-popup-item" role="menuitem" style="flex:1; padding:8px 10px;">
                            <div class="nav-popup-icon" style="width:30px; height:30px; font-size:0.85rem; background:#f1f5f9; color:#475569;">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="nav-popup-title" style="font-size:0.82rem;">Admin</div>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="nav-actions">
            <!-- Saved Bookmarks -->
            <button type="button" class="btn btn-secondary btn-sm" id="savedBookmarksTrigger" title="View Saved Colleges & Courses" style="position:relative;">
                <i class="far fa-bookmark"></i>
                <span class="badge badge-primary" id="bookmarkCountBadge" style="display:none; margin-left:4px;">0</span>
            </button>

            <!-- Direct Contact CTA -->
            <a href="contact.php" class="btn btn-primary btn-sm">
                <i class="fas fa-headset"></i> <span>Helpline</span>
            </a>

            <!-- Mobile Hamburger Button -->
            <button type="button" class="mobile-toggle" id="mobileMenuToggle" aria-label="Toggle navigation" style="display:none; background:none; border:none; font-size:1.4rem; color:var(--text); cursor:pointer; padding:6px 10px;">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<?php if ($flash): ?>
    <div class="container" style="margin-top: 20px;">
        <div class="toast toast-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>" style="position:static; margin-bottom:16px;">
            <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
            <span><?= sanitize($flash['message']) ?></span>
        </div>
    </div>
<?php endif; ?>
