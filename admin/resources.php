<?php
$activeNav = 'resources';
require_once __DIR__ . '/header.php';

$action = $_GET['action'] ?? 'list';
$editId = (int)($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'create' || $postAction === 'update') {
        $title = trim($_POST['title'] ?? '');
        $categoryId = (int)($_POST['category_id'] ?? 1);
        $resourceType = trim($_POST['resource_type'] ?? 'Lecture Notes');
        $format = trim($_POST['format'] ?? 'PDF');
        $fileSize = trim($_POST['file_size'] ?? '2.5 MB');
        $description = trim($_POST['description'] ?? '');
        $downloadUrl = trim($_POST['download_url'] ?? '#');
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;

        if ($postAction === 'create') {
            $db->query("
                INSERT INTO resources (title, category_id, resource_type, format, file_size, description, download_url, is_featured, downloads_count) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)
            ", [$title, $categoryId, $resourceType, $format, $fileSize, $description, $downloadUrl, $isFeatured]);
            setFlash('success', "Study resource '{$title}' added successfully!");
        } else {
            $id = (int)$_POST['id'];
            $db->query("
                UPDATE resources SET title=?, category_id=?, resource_type=?, format=?, file_size=?, description=?, download_url=?, is_featured=? 
                WHERE id=?
            ", [$title, $categoryId, $resourceType, $format, $fileSize, $description, $downloadUrl, $isFeatured, $id]);
            setFlash('success', "Resource updated successfully!");
        }
        header("Location: resources.php");
        exit;
    }

    if ($postAction === 'delete') {
        $id = (int)$_POST['id'];
        $db->query("DELETE FROM resources WHERE id = ?", [$id]);
        setFlash('success', "Resource removed from vault.");
        header("Location: resources.php");
        exit;
    }
}

$editItem = null;
if ($action === 'edit' && $editId > 0) {
    $editItem = $db->fetch("SELECT * FROM resources WHERE id = ?", [$editId]);
}

$resources = $db->fetchAll("
    SELECT r.*, cat.name as category_name 
    FROM resources r 
    LEFT JOIN categories cat ON r.category_id = cat.id 
    ORDER BY r.id DESC
");

$categories = $db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
$types = ['Lecture Notes', 'Sample Papers', 'Study Guide', 'Syllabus', 'E-Book'];
?>

<div style="margin-bottom: 28px; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h1 style="font-size:1.8rem; font-weight:800; color:#0f172a; margin-bottom:4px;">Manage Study Resources</h1>
        <p style="color:#64748b; font-size:0.95rem;">Upload lecture notes, past exam papers, and syllabus guides.</p>
    </div>

    <div>
        <?php if ($action === 'list'): ?>
            <a href="resources.php?action=new" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Material
            </a>
        <?php else: ?>
            <a href="resources.php" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Resources
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($action === 'new' || ($action === 'edit' && $editItem)): ?>
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:var(--radius-lg); padding:32px; max-width:800px; margin-bottom:40px;">
        <h2 style="font-size:1.4rem; font-weight:800; margin-bottom:24px; color:#0f172a;">
            <?= ($action === 'new') ? 'Add New Educational Resource' : 'Edit Resource: ' . sanitize($editItem['title']) ?>
        </h2>

        <form method="POST" action="resources.php">
            <input type="hidden" name="action" value="<?= ($action === 'new') ? 'create' : 'update' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label class="form-label">Resource Title *</label>
                <input type="text" name="title" class="form-control" value="<?= sanitize($editItem['title'] ?? '') ?>" required placeholder="e.g. Operating Systems Semester 4 Comprehensive Notes">
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Category / Stream</label>
                    <select name="category_id" class="form-control">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (($editItem['category_id'] ?? 1) == $cat['id']) ? 'selected' : '' ?>>
                                <?= sanitize($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Material Type</label>
                    <select name="resource_type" class="form-control">
                        <?php foreach ($types as $t): ?>
                            <option value="<?= $t ?>" <?= (($editItem['resource_type'] ?? '') === $t) ? 'selected' : '' ?>><?= $t ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">File Format</label>
                    <select name="format" class="form-control">
                        <option value="PDF" <?= (($editItem['format'] ?? '') === 'PDF') ? 'selected' : '' ?>>PDF Document</option>
                        <option value="EPUB" <?= (($editItem['format'] ?? '') === 'EPUB') ? 'selected' : '' ?>>EPUB E-Book</option>
                        <option value="DOCX" <?= (($editItem['format'] ?? '') === 'DOCX') ? 'selected' : '' ?>>DOCX Word File</option>
                        <option value="LINK" <?= (($editItem['format'] ?? '') === 'LINK') ? 'selected' : '' ?>>Online Video Lecture Link</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Estimated File Size</label>
                    <input type="text" name="file_size" class="form-control" value="<?= sanitize($editItem['file_size'] ?? '3.5 MB') ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description / Topics Covered</label>
                <textarea name="description" class="form-control" rows="3"><?= sanitize($editItem['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" <?= (!empty($editItem['is_featured'])) ? 'checked' : '' ?>>
                <label for="is_featured" style="font-weight:600; cursor:pointer;">Highlight in Homepage Knowledge Vault</label>
            </div>

            <div style="display:flex; gap:12px; margin-top:24px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Resource
                </button>
                <a href="resources.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php endif; ?>

<!-- Resources Table -->
<div class="admin-table-card">
    <div class="admin-table-header">
        <h2 class="admin-table-title">Available Resources (<?= count($resources) ?>)</h2>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Type</th>
                <th>Format &amp; Size</th>
                <th>Downloads</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resources as $res): ?>
                <tr>
                    <td>
                        <strong style="color:#0f172a; display:block;"><?= sanitize($res['title']) ?></strong>
                        <span style="font-size:0.8rem; color:#64748b;"><?= sanitize(mb_substr($res['description'], 0, 70)) ?>...</span>
                    </td>
                    <td><?= sanitize($res['category_name']) ?></td>
                    <td><span class="badge badge-info"><?= sanitize($res['resource_type']) ?></span></td>
                    <td><?= sanitize($res['format']) ?> • <?= sanitize($res['file_size']) ?></td>
                    <td><strong style="color:var(--primary);"><?= number_format($res['downloads_count']) ?></strong></td>
                    <td>
                        <div class="action-buttons">
                            <a href="resources.php?action=edit&id=<?= $res['id'] ?>" class="btn btn-secondary btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="resources.php" onsubmit="return confirm('Delete this resource?');" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $res['id'] ?>">
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
