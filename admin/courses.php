<?php
$activeNav = 'courses';
require_once __DIR__ . '/header.php';

$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);
$filterInstId = (int)($_GET['institution_id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'create' || $postAction === 'update') {
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '') ?: preg_replace('/[^a-z0-9]+/i', '-', strtolower($name));
        $institutionId = (int)($_POST['institution_id'] ?? 0);
        $categoryId = (int)($_POST['category_id'] ?? 1);
        $degreeLevel = trim($_POST['degree_level'] ?? 'Undergraduate');
        $duration = trim($_POST['duration'] ?? '4 Years');
        $tuitionFee = (float)($_POST['tuition_fee'] ?? 0);
        $eligibility = trim($_POST['eligibility'] ?? '');
        $seats = (int)($_POST['seats'] ?? 60);
        $syllabusSummary = trim($_POST['syllabus_summary'] ?? '');
        $careerProspects = trim($_POST['career_prospects'] ?? '');
        $avgPackage = trim($_POST['avg_package'] ?? '₹6.0 - ₹12.0 LPA');
        $isPopular = isset($_POST['is_popular']) ? 1 : 0;

        if ($postAction === 'create') {
            $db->query("
                INSERT INTO courses 
                (institution_id, category_id, name, slug, degree_level, duration, tuition_fee, eligibility, seats, syllabus_summary, career_prospects, avg_package, is_popular) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ", [$institutionId, $categoryId, $name, $slug, $degreeLevel, $duration, $tuitionFee, $eligibility, $seats, $syllabusSummary, $careerProspects, $avgPackage, $isPopular]);
            setFlash('success', "Course '{$name}' created successfully!");
        } else {
            $id = (int)$_POST['id'];
            $db->query("
                UPDATE courses SET 
                institution_id=?, category_id=?, name=?, slug=?, degree_level=?, duration=?, tuition_fee=?, eligibility=?, seats=?, syllabus_summary=?, career_prospects=?, avg_package=?, is_popular=? 
                WHERE id=?
            ", [$institutionId, $categoryId, $name, $slug, $degreeLevel, $duration, $tuitionFee, $eligibility, $seats, $syllabusSummary, $careerProspects, $avgPackage, $isPopular, $id]);
            setFlash('success', "Course '{$name}' updated successfully!");
        }
        header("Location: courses.php");
        exit;
    }

    if ($postAction === 'delete') {
        $id = (int)$_POST['id'];
        $db->query("DELETE FROM courses WHERE id = ?", [$id]);
        setFlash('success', "Course deleted successfully.");
        header("Location: courses.php");
        exit;
    }
}

$editItem = null;
if ($action === 'edit' && $editId > 0) {
    $editItem = $db->fetch("SELECT * FROM courses WHERE id = ?", [$editId]);
}

$institutions = $db->fetchAll("SELECT id, name, city FROM institutions ORDER BY name ASC");
$categories = $db->fetchAll("SELECT * FROM categories ORDER BY name ASC");

$whereSql = ($filterInstId > 0) ? "WHERE c.institution_id = {$filterInstId}" : "";
$courses = $db->fetchAll("
    SELECT c.*, i.name as institution_name, cat.name as category_name 
    FROM courses c 
    JOIN institutions i ON c.institution_id = i.id 
    LEFT JOIN categories cat ON c.category_id = cat.id 
    {$whereSql} 
    ORDER BY c.id DESC
");
?>

<div style="margin-bottom: 28px; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h1 style="font-size:1.8rem; font-weight:800; color:#0f172a; margin-bottom:4px;">Manage Academic Programs</h1>
        <p style="color:#64748b; font-size:0.95rem;">Add, edit or update course curriculums and fee structures.</p>
    </div>

    <div>
        <?php if ($action === 'list'): ?>
            <a href="courses.php?action=new" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Program
            </a>
        <?php else: ?>
            <a href="courses.php" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Courses
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($action === 'new' || ($action === 'edit' && $editItem)): ?>
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:var(--radius-lg); padding:32px; max-width:850px; margin-bottom:40px;">
        <h2 style="font-size:1.4rem; font-weight:800; margin-bottom:24px; color:#0f172a;">
            <?= ($action === 'new') ? 'Add New Degree Program' : 'Edit Program: ' . sanitize($editItem['name']) ?>
        </h2>

        <form method="POST" action="courses.php">
            <input type="hidden" name="action" value="<?= ($action === 'new') ? 'create' : 'update' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Offering Institution *</label>
                    <select name="institution_id" class="form-control" required>
                        <?php foreach ($institutions as $inst): ?>
                            <option value="<?= $inst['id'] ?>" <?= (($editItem['institution_id'] ?? $filterInstId) == $inst['id']) ? 'selected' : '' ?>>
                                <?= sanitize($inst['name']) ?> (<?= sanitize($inst['city']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Discipline / Category</label>
                    <select name="category_id" class="form-control">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (($editItem['category_id'] ?? 1) == $cat['id']) ? 'selected' : '' ?>>
                                <?= sanitize($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Course Title *</label>
                <input type="text" name="name" class="form-control" value="<?= sanitize($editItem['name'] ?? '') ?>" required placeholder="e.g. B.Tech in Computer Science &amp; AI">
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Degree Level</label>
                    <select name="degree_level" class="form-control">
                        <option value="Undergraduate" <?= (($editItem['degree_level'] ?? '') === 'Undergraduate') ? 'selected' : '' ?>>Undergraduate</option>
                        <option value="Postgraduate" <?= (($editItem['degree_level'] ?? '') === 'Postgraduate') ? 'selected' : '' ?>>Postgraduate</option>
                        <option value="Diploma" <?= (($editItem['degree_level'] ?? '') === 'Diploma') ? 'selected' : '' ?>>Diploma</option>
                        <option value="Higher Secondary" <?= (($editItem['degree_level'] ?? '') === 'Higher Secondary') ? 'selected' : '' ?>>Higher Secondary</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-control" value="<?= sanitize($editItem['duration'] ?? '4 Years (8 Semesters)') ?>">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Annual Tuition Fee (<?= CURRENCY_SYMBOL ?>)</label>
                    <input type="number" step="0.01" name="tuition_fee" class="form-control" value="<?= sanitize($editItem['tuition_fee'] ?? '150000') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Intake Seats</label>
                    <input type="number" name="seats" class="form-control" value="<?= sanitize($editItem['seats'] ?? 60) ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Average Placement Package Highlight</label>
                <input type="text" name="avg_package" class="form-control" value="<?= sanitize($editItem['avg_package'] ?? '₹8.0 - ₹20.0 LPA') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Eligibility Requirements</label>
                <textarea name="eligibility" class="form-control" rows="3"><?= sanitize($editItem['eligibility'] ?? '10+2 with 60% aggregate in Physics, Mathematics &amp; Chemistry.') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Syllabus Overview &amp; Modules</label>
                <textarea name="syllabus_summary" class="form-control" rows="4"><?= sanitize($editItem['syllabus_summary'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Career Prospects &amp; Potential Roles</label>
                <textarea name="career_prospects" class="form-control" rows="3"><?= sanitize($editItem['career_prospects'] ?? '') ?></textarea>
            </div>

            <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="is_popular" id="is_popular" value="1" <?= (!empty($editItem['is_popular'])) ? 'checked' : '' ?>>
                <label for="is_popular" style="font-weight:600; cursor:pointer;">Mark as In-Demand / Popular Degree</label>
            </div>

            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Course
                </button>
                <a href="courses.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<!-- Courses Table -->
<div class="admin-table-card">
    <div class="admin-table-header">
        <h2 class="admin-table-title">Courses Listing (<?= count($courses) ?>)</h2>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Institution</th>
                <th>Level</th>
                <th>Duration</th>
                <th>Tuition Fee</th>
                <th>Avg. Package</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $c): ?>
                <tr>
                    <td>
                        <strong style="color:#0f172a; display:block;"><?= sanitize($c['name']) ?></strong>
                        <span style="font-size:0.8rem; color:#64748b;"><?= sanitize($c['category_name']) ?></span>
                    </td>
                    <td><?= sanitize($c['institution_name']) ?></td>
                    <td><?= renderBadge($c['degree_level'], $c['degree_level']) ?></td>
                    <td><?= sanitize($c['duration']) ?></td>
                    <td><?= formatCurrency($c['tuition_fee']) ?></td>
                    <td><strong style="color:var(--success);"><?= sanitize($c['avg_package']) ?></strong></td>
                    <td>
                        <div class="action-buttons">
                            <a href="../course-detail.php?id=<?= $c['id'] ?>" target="_blank" class="btn btn-outline btn-sm" title="View Public Page">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <a href="courses.php?action=edit&id=<?= $c['id'] ?>" class="btn btn-secondary btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="courses.php" onsubmit="return confirm('Are you sure you want to delete this course?');" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
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
