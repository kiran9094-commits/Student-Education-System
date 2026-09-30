<?php
$activeNav = 'dashboard';
require_once __DIR__ . '/header.php';

// Quick action: update inquiry status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_inquiry_status') {
    $inqId = (int)$_POST['inquiry_id'];
    $newStatus = trim($_POST['status']);
    $allowed = ['Pending', 'Contacted', 'Under Review', 'Enrolled'];
    if (in_array($newStatus, $allowed)) {
        $db->query("UPDATE inquiries SET status = ? WHERE id = ?", [$newStatus, $inqId]);
        setFlash('success', "Inquiry #{$inqId} status updated to {$newStatus}.");
        header("Location: index.php");
        exit;
    }
}

// Fetch stats
$totalInstitutions = (int)($db->fetch("SELECT COUNT(*) as c FROM institutions")['c'] ?? 0);
$totalCourses = (int)($db->fetch("SELECT COUNT(*) as c FROM courses")['c'] ?? 0);
$totalResources = (int)($db->fetch("SELECT COUNT(*) as c FROM resources")['c'] ?? 0);
$totalInquiries = (int)($db->fetch("SELECT COUNT(*) as c FROM inquiries")['c'] ?? 0);

// Fetch recent inquiries
$recentInquiries = $db->fetchAll("
    SELECT inq.*, inst.name as institution_name, c.name as course_name 
    FROM inquiries inq 
    LEFT JOIN institutions inst ON inq.institution_id = inst.id 
    LEFT JOIN courses c ON inq.course_id = c.id 
    ORDER BY inq.id DESC 
    LIMIT 6
");

// Fetch featured institutions
$recentInstitutions = $db->fetchAll("SELECT id, name, type, city, state, rating, student_count FROM institutions ORDER BY id DESC LIMIT 5");
?>

<div style="margin-bottom: 28px; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h1 style="font-size:1.8rem; font-weight:800; color:#0f172a; margin-bottom:4px;">Administration Console</h1>
        <p style="color:#64748b; font-size:0.95rem;">Monitor institution listings, academic programs, and student admission inquiries.</p>
    </div>

    <div style="display:flex; gap:12px;">
        <a href="institutions.php?action=new" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Institution
        </a>
        <a href="courses.php?action=new" class="btn btn-secondary btn-sm">
            <i class="fas fa-plus"></i> Add Course
        </a>
    </div>
</div>

<!-- Key Metric Cards -->
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div>
            <div style="font-size:0.85rem; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:6px;">Institutions</div>
            <div style="font-size:2rem; font-weight:800; color:#0f172a;"><?= $totalInstitutions ?></div>
            <div style="font-size:0.8rem; color:#059669; margin-top:4px;"><i class="fas fa-check-circle"></i> Active in database</div>
        </div>
        <div class="admin-stat-icon icon-indigo">
            <i class="fas fa-university"></i>
        </div>
    </div>

    <div class="admin-stat-card">
        <div>
            <div style="font-size:0.85rem; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:6px;">Programs &amp; Degrees</div>
            <div style="font-size:2rem; font-weight:800; color:#0f172a;"><?= $totalCourses ?></div>
            <div style="font-size:0.8rem; color:#0284c7; margin-top:4px;"><i class="fas fa-book"></i> Verified syllabi</div>
        </div>
        <div class="admin-stat-icon icon-blue">
            <i class="fas fa-graduation-cap"></i>
        </div>
    </div>

    <div class="admin-stat-card">
        <div>
            <div style="font-size:0.85rem; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:6px;">Study Resources</div>
            <div style="font-size:2rem; font-weight:800; color:#0f172a;"><?= $totalResources ?></div>
            <div style="font-size:0.8rem; color:#d97706; margin-top:4px;"><i class="fas fa-download"></i> Notes &amp; past papers</div>
        </div>
        <div class="admin-stat-icon icon-amber">
            <i class="fas fa-book-reader"></i>
        </div>
    </div>

    <div class="admin-stat-card">
        <div>
            <div style="font-size:0.85rem; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:6px;">Student Inquiries</div>
            <div style="font-size:2rem; font-weight:800; color:#0f172a;"><?= $totalInquiries ?></div>
            <div style="font-size:0.8rem; color:#4f46e5; margin-top:4px;"><i class="fas fa-user-clock"></i> Guidance requests</div>
        </div>
        <div class="admin-stat-icon icon-emerald">
            <i class="fas fa-inbox"></i>
        </div>
    </div>
</div>

<!-- Recent Inquiries Table -->
<div class="admin-table-card">
    <div class="admin-table-header">
        <h2 class="admin-table-title">Recent Student Admission Inquiries</h2>
        <a href="inquiries.php" class="btn btn-secondary btn-sm">View All Inquiries</a>
    </div>

    <?php if (!empty($recentInquiries)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Contact Info</th>
                    <th>Target Campus / Program</th>
                    <th>Received</th>
                    <th>Status</th>
                    <th>Quick Update</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentInquiries as $inq): ?>
                    <tr>
                        <td>
                            <strong style="color:#0f172a; display:block;"><?= sanitize($inq['student_name']) ?></strong>
                            <span style="font-size:0.8rem; color:#64748b;"><?= sanitize($inq['city']) ?> • <?= sanitize($inq['qualification']) ?></span>
                        </td>
                        <td>
                            <div style="font-size:0.88rem;"><?= sanitize($inq['phone']) ?></div>
                            <div style="font-size:0.8rem; color:#64748b;"><?= sanitize($inq['email']) ?></div>
                        </td>
                        <td>
                            <div style="font-weight:600; color:#0f172a;">
                                <?= sanitize($inq['institution_name'] ?? 'General Consultation') ?>
                            </div>
                            <?php if (!empty($inq['course_name'])): ?>
                                <div style="font-size:0.8rem; color:#4f46e5;"><?= sanitize($inq['course_name']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span style="font-size:0.85rem; color:#64748b;"><?= timeAgo($inq['created_at']) ?></span>
                        </td>
                        <td>
                            <?= renderBadge($inq['status'], $inq['status']) ?>
                        </td>
                        <td>
                            <form method="POST" action="index.php" style="display:inline-flex; align-items:center; gap:6px;">
                                <input type="hidden" name="action" value="update_inquiry_status">
                                <input type="hidden" name="inquiry_id" value="<?= $inq['id'] ?>">
                                <select name="status" class="form-control" style="padding:6px 10px; font-size:0.82rem; height:auto;" onchange="this.form.submit()">
                                    <option value="Pending" <?= ($inq['status'] === 'Pending') ? 'selected' : '' ?>>Pending</option>
                                    <option value="Contacted" <?= ($inq['status'] === 'Contacted') ? 'selected' : '' ?>>Contacted</option>
                                    <option value="Under Review" <?= ($inq['status'] === 'Under Review') ? 'selected' : '' ?>>Under Review</option>
                                    <option value="Enrolled" <?= ($inq['status'] === 'Enrolled') ? 'selected' : '' ?>>Enrolled</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="padding: 40px; text-align:center; color:#94a3b8;">
            No student inquiries logged yet.
        </div>
    <?php endif; ?>
</div>

<!-- Institutions Quick Table -->
<div class="admin-table-card">
    <div class="admin-table-header">
        <h2 class="admin-table-title">Managed Institutions Overview</h2>
        <a href="institutions.php" class="btn btn-secondary btn-sm">Manage All</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Campus Name</th>
                <th>Type</th>
                <th>Location</th>
                <th>Rating</th>
                <th>Students</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentInstitutions as $inst): ?>
                <tr>
                    <td>
                        <strong style="color:#0f172a;"><?= sanitize($inst['name']) ?></strong>
                    </td>
                    <td><?= renderBadge($inst['type'], $inst['type']) ?></td>
                    <td><?= sanitize($inst['city']) ?>, <?= sanitize($inst['state']) ?></td>
                    <td><?= renderRatingStars($inst['rating']) ?></td>
                    <td><?= number_format($inst['student_count']) ?>+</td>
                    <td>
                        <a href="../institution-detail.php?id=<?= $inst['id'] ?>" target="_blank" class="btn btn-outline btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
