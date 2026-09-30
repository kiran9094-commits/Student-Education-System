<?php
$activeNav = 'inquiries';
require_once __DIR__ . '/header.php';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_status') {
        $id = (int)$_POST['inquiry_id'];
        $newStatus = trim($_POST['status']);
        $db->query("UPDATE inquiries SET status = ? WHERE id = ?", [$newStatus, $id]);
        setFlash('success', "Inquiry status updated to '{$newStatus}'.");
        header("Location: inquiries.php");
        exit;
    }

    if ($_POST['action'] === 'delete') {
        $id = (int)$_POST['id'];
        $db->query("DELETE FROM inquiries WHERE id = ?", [$id]);
        setFlash('success', "Inquiry record deleted.");
        header("Location: inquiries.php");
        exit;
    }
}

$statusFilter = trim($_GET['status'] ?? '');
$whereSql = !empty($statusFilter) ? "WHERE inq.status = '{$statusFilter}'" : "";

$inquiries = $db->fetchAll("
    SELECT inq.*, inst.name as institution_name, c.name as course_name 
    FROM inquiries inq 
    LEFT JOIN institutions inst ON inq.institution_id = inst.id 
    LEFT JOIN courses c ON inq.course_id = c.id 
    {$whereSql} 
    ORDER BY inq.id DESC
");
?>

<div style="margin-bottom: 28px; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h1 style="font-size:1.8rem; font-weight:800; color:#0f172a; margin-bottom:4px;">Student Inquiries Management</h1>
        <p style="color:#64748b; font-size:0.95rem;">Track admission consultations, counseling progress, and enrollment outcomes.</p>
    </div>

    <!-- Filter by Status -->
    <div style="display:flex; gap:8px;">
        <a href="inquiries.php" class="btn <?= empty($statusFilter) ? 'btn-primary' : 'btn-secondary' ?> btn-sm">All</a>
        <a href="inquiries.php?status=Pending" class="btn <?= ($statusFilter === 'Pending') ? 'btn-primary' : 'btn-secondary' ?> btn-sm">Pending</a>
        <a href="inquiries.php?status=Contacted" class="btn <?= ($statusFilter === 'Contacted') ? 'btn-primary' : 'btn-secondary' ?> btn-sm">Contacted</a>
        <a href="inquiries.php?status=Under Review" class="btn <?= ($statusFilter === 'Under Review') ? 'btn-primary' : 'btn-secondary' ?> btn-sm">Under Review</a>
        <a href="inquiries.php?status=Enrolled" class="btn <?= ($statusFilter === 'Enrolled') ? 'btn-primary' : 'btn-secondary' ?> btn-sm">Enrolled</a>
    </div>
</div>

<div class="admin-table-card">
    <div class="admin-table-header">
        <h2 class="admin-table-title">Inquiries Archive (<?= count($inquiries) ?> Records)</h2>
    </div>

    <?php if (!empty($inquiries)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Student Details</th>
                    <th>Contact Info</th>
                    <th>Target Campus / Degree</th>
                    <th>Student Query / Message</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inquiries as $inq): ?>
                    <tr>
                        <td>
                            <strong style="color:#0f172a; display:block;"><?= sanitize($inq['student_name']) ?></strong>
                            <span style="font-size:0.8rem; color:#64748b;">
                                <?= sanitize($inq['city']) ?> • <?= sanitize($inq['qualification']) ?>
                            </span>
                        </td>
                        <td>
                            <div style="font-size:0.88rem; font-weight:600; color:#0f172a;"><?= sanitize($inq['phone']) ?></div>
                            <div style="font-size:0.8rem; color:#64748b;"><?= sanitize($inq['email']) ?></div>
                        </td>
                        <td>
                            <div style="font-weight:600; color:#0f172a;"><?= sanitize($inq['institution_name'] ?? 'General Consultation') ?></div>
                            <?php if (!empty($inq['course_name'])): ?>
                                <div style="font-size:0.8rem; color:#4f46e5;"><?= sanitize($inq['course_name']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="max-width:280px; font-size:0.85rem; color:#475569; line-height:1.4;">
                                <?= sanitize($inq['message'] ?: 'No custom message.') ?>
                            </div>
                        </td>
                        <td>
                            <span style="font-size:0.82rem; color:#64748b; white-space:nowrap;"><?= timeAgo($inq['created_at']) ?></span>
                        </td>
                        <td>
                            <form method="POST" action="inquiries.php">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="inquiry_id" value="<?= $inq['id'] ?>">
                                <select name="status" class="form-control" style="padding:6px 10px; font-size:0.82rem; height:auto; width:auto;" onchange="this.form.submit()">
                                    <option value="Pending" <?= ($inq['status'] === 'Pending') ? 'selected' : '' ?>>Pending</option>
                                    <option value="Contacted" <?= ($inq['status'] === 'Contacted') ? 'selected' : '' ?>>Contacted</option>
                                    <option value="Under Review" <?= ($inq['status'] === 'Under Review') ? 'selected' : '' ?>>Under Review</option>
                                    <option value="Enrolled" <?= ($inq['status'] === 'Enrolled') ? 'selected' : '' ?>>Enrolled</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="inquiries.php" onsubmit="return confirm('Delete this inquiry?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $inq['id'] ?>">
                                <button type="submit" class="btn btn-sm" style="background:#fee2e2; color:#ef4444; border:none;" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="padding: 40px; text-align:center; color:#94a3b8;">
            No student inquiries found for this status.
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
