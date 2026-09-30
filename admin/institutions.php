<?php
$activeNav = 'institutions';
require_once __DIR__ . '/header.php';

// Handle Add / Edit / Delete
$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'create' || $postAction === 'update') {
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '') ?: preg_replace('/[^a-z0-9]+/i', '-', strtolower($name));
        $type = trim($_POST['type'] ?? 'College');
        $categoryId = (int)($_POST['category_id'] ?? 1);
        $accreditation = trim($_POST['accreditation'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $state = trim($_POST['state'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $establishedYear = (int)($_POST['established_year'] ?? date('Y'));
        $rankingNirf = trim($_POST['ranking_nirf'] ?? '');
        $rating = (float)($_POST['rating'] ?? 4.5);
        $tuitionRange = trim($_POST['tuition_range'] ?? '');
        $studentCount = (int)($_POST['student_count'] ?? 1000);
        $description = trim($_POST['description'] ?? '');
        $facilities = trim($_POST['facilities'] ?? '');
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
        $bannerImage = trim($_POST['banner_image'] ?? '') ?: 'assets/images/college_banner_default.svg';
        $logoImage = trim($_POST['logo_image'] ?? '') ?: 'assets/images/college_logo_default.svg';
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $website = trim($_POST['website'] ?? '');

        if ($postAction === 'create') {
            $db->query("
                INSERT INTO institutions 
                (name, slug, type, category_id, accreditation, city, state, address, established_year, ranking_nirf, rating, tuition_range, student_count, description, facilities, is_featured, banner_image, logo_image, email, phone, website) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ", [$name, $slug, $type, $categoryId, $accreditation, $city, $state, $address, $establishedYear, $rankingNirf, $rating, $tuitionRange, $studentCount, $description, $facilities, $isFeatured, $bannerImage, $logoImage, $email, $phone, $website]);
            setFlash('success', "Institution '{$name}' created successfully!");
        } else {
            $id = (int)$_POST['id'];
            $db->query("
                UPDATE institutions SET 
                name=?, slug=?, type=?, category_id=?, accreditation=?, city=?, state=?, address=?, established_year=?, ranking_nirf=?, rating=?, tuition_range=?, student_count=?, description=?, facilities=?, is_featured=?, banner_image=?, logo_image=?, email=?, phone=?, website=? 
                WHERE id=?
            ", [$name, $slug, $type, $categoryId, $accreditation, $city, $state, $address, $establishedYear, $rankingNirf, $rating, $tuitionRange, $studentCount, $description, $facilities, $isFeatured, $bannerImage, $logoImage, $email, $phone, $website, $id]);
            setFlash('success', "Institution '{$name}' updated successfully!");
        }
        header("Location: institutions.php");
        exit;
    }

    if ($postAction === 'delete') {
        $id = (int)$_POST['id'];
        $db->query("DELETE FROM institutions WHERE id = ?", [$id]);
        $db->query("DELETE FROM courses WHERE institution_id = ?", [$id]);
        setFlash('success', "Institution and its associated courses removed.");
        header("Location: institutions.php");
        exit;
    }
}

// If edit
$editItem = null;
if ($action === 'edit' && $editId > 0) {
    $editItem = $db->fetch("SELECT * FROM institutions WHERE id = ?", [$editId]);
}

$institutions = $db->fetchAll("
    SELECT i.*, cat.name as category_name, 
           (SELECT COUNT(*) FROM courses WHERE institution_id = i.id) as courses_count 
    FROM institutions i 
    LEFT JOIN categories cat ON i.category_id = cat.id 
    ORDER BY i.id DESC
");

$categories = $db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
?>

<div style="margin-bottom: 28px; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h1 style="font-size:1.8rem; font-weight:800; color:#0f172a; margin-bottom:4px;">Manage Institutions</h1>
        <p style="color:#64748b; font-size:0.95rem;">Add, update, or inspect colleges, universities, and schools.</p>
    </div>

    <div>
        <?php if ($action === 'list'): ?>
            <a href="institutions.php?action=new" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Institution
            </a>
        <?php else: ?>
            <a href="institutions.php" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Listing
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($action === 'new' || ($action === 'edit' && $editItem)): ?>
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:var(--radius-lg); padding:32px; max-width:850px; margin-bottom:40px;">
        <h2 style="font-size:1.4rem; font-weight:800; margin-bottom:24px; color:#0f172a;">
            <?= ($action === 'new') ? 'Add New Academic Institution' : 'Edit Institution: ' . sanitize($editItem['name']) ?>
        </h2>

        <form method="POST" action="institutions.php">
            <input type="hidden" name="action" value="<?= ($action === 'new') ? 'create' : 'update' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Institution Name *</label>
                    <input type="text" name="name" class="form-control" value="<?= sanitize($editItem['name'] ?? '') ?>" required placeholder="e.g. National Institute of Tech">
                </div>
                <div class="form-group">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control">
                        <option value="University" <?= (($editItem['type'] ?? '') === 'University') ? 'selected' : '' ?>>University</option>
                        <option value="College" <?= (($editItem['type'] ?? '') === 'College') ? 'selected' : '' ?>>College</option>
                        <option value="School" <?= (($editItem['type'] ?? '') === 'School') ? 'selected' : '' ?>>School</option>
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Primary Academic Category</label>
                    <select name="category_id" class="form-control">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (($editItem['category_id'] ?? 1) == $cat['id']) ? 'selected' : '' ?>>
                                <?= sanitize($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Accreditation / Approval</label>
                    <input type="text" name="accreditation" class="form-control" value="<?= sanitize($editItem['accreditation'] ?? 'NAAC A+ Grade') ?>">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">City *</label>
                    <input type="text" name="city" class="form-control" value="<?= sanitize($editItem['city'] ?? '') ?>" required placeholder="e.g. Bengaluru">
                </div>
                <div class="form-group">
                    <label class="form-label">State *</label>
                    <input type="text" name="state" class="form-control" value="<?= sanitize($editItem['state'] ?? '') ?>" required placeholder="e.g. Karnataka">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Full Campus Address</label>
                <input type="text" name="address" class="form-control" value="<?= sanitize($editItem['address'] ?? '') ?>">
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Established Year</label>
                    <input type="number" name="established_year" class="form-control" value="<?= sanitize($editItem['established_year'] ?? 2000) ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">NIRF / State Ranking</label>
                    <input type="text" name="ranking_nirf" class="form-control" value="<?= sanitize($editItem['ranking_nirf'] ?? 'NIRF Rank #25') ?>">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Tuition Fee Range</label>
                    <input type="text" name="tuition_range" class="form-control" value="<?= sanitize($editItem['tuition_range'] ?? '₹80,000 - ₹2,20,000 / yr') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Enrolled Student Count</label>
                    <input type="number" name="student_count" class="form-control" value="<?= sanitize($editItem['student_count'] ?? 4000) ?>">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Contact Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?= sanitize($editItem['phone'] ?? '+91 98765 00000') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Official Email</label>
                    <input type="email" name="email" class="form-control" value="<?= sanitize($editItem['email'] ?? 'admissions@campus.edu') ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Campus Description</label>
                <textarea name="description" class="form-control" rows="4"><?= sanitize($editItem['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Facilities (Comma-separated)</label>
                <input type="text" name="facilities" class="form-control" value="<?= sanitize($editItem['facilities'] ?? 'Smart Labs, Library, Hostel, Wi-Fi, Sports Complex') ?>">
            </div>

            <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" <?= (!empty($editItem['is_featured'])) ? 'checked' : '' ?>>
                <label for="is_featured" style="font-weight:600; cursor:pointer;">Highlight as Featured on Homepage</label>
            </div>

            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Institution
                </button>
                <a href="institutions.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<!-- Institutions Table -->
<div class="admin-table-card">
    <div class="admin-table-header">
        <h2 class="admin-table-title">Institutions List (<?= count($institutions) ?>)</h2>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Location</th>
                <th>Rating</th>
                <th>Offered Courses</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($institutions as $inst): ?>
                <tr>
                    <td>
                        <strong style="color:#0f172a; display:block;"><?= sanitize($inst['name']) ?></strong>
                        <span style="font-size:0.8rem; color:#64748b;"><?= sanitize($inst['accreditation']) ?></span>
                    </td>
                    <td><?= renderBadge($inst['type'], $inst['type']) ?></td>
                    <td><?= sanitize($inst['city']) ?>, <?= sanitize($inst['state']) ?></td>
                    <td><?= renderRatingStars($inst['rating']) ?></td>
                    <td>
                        <a href="courses.php?institution_id=<?= $inst['id'] ?>" class="badge badge-primary">
                            <?= (int)$inst['courses_count'] ?> Programs
                        </a>
                    </td>
                    <td>
                        <?= $inst['is_featured'] ? '<span class="badge badge-success">Featured</span>' : '<span style="color:#94a3b8; font-size:0.8rem;">Standard</span>' ?>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="../institution-detail.php?id=<?= $inst['id'] ?>" target="_blank" class="btn btn-outline btn-sm" title="View Public Page">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <a href="institutions.php?action=edit&id=<?= $inst['id'] ?>" class="btn btn-secondary btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="institutions.php" onsubmit="return confirm('Are you sure you want to delete this institution and all its courses?');" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $inst['id'] ?>">
                                <button type="submit" class="btn btn-sm" style="background:#fee2e2; color:#ef4444; border:none;" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
