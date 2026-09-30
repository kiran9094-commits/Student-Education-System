<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/database/Database.php';
require_once __DIR__ . '/includes/functions.php';

$db = Database::getInstance();

// Handle download trigger & increment count
if (isset($_GET['download'])) {
    $downloadId = (int)$_GET['download'];
    $res = $db->fetch("SELECT * FROM resources WHERE id = ?", [$downloadId]);
    if ($res) {
        $db->query("UPDATE resources SET downloads_count = downloads_count + 1 WHERE id = ?", [$downloadId]);
        setFlash('success', 'Download initiated for: ' . $res['title']);
        header("Location: resources.php");
        exit;
    }
}

$pageTitle = "Educational Study Materials, Notes & Board Papers - " . APP_NAME;
$metaDescription = "Free downloadable academic resources including lecture notes, board past papers, laboratory manuals, and competitive exam guides.";
$activePage = 'resources';

// Filter params
$search = trim($_GET['q'] ?? '');
$categoryId = !empty($_GET['category']) ? (int)$_GET['category'] : 0;
$resourceType = trim($_GET['type'] ?? '');

$where = [];
$params = [];

if (!empty($search)) {
    $where[] = "(r.title LIKE ? OR r.description LIKE ?)";
    $st = "%{$search}%";
    $params = array_merge($params, [$st, $st]);
}

if ($categoryId > 0) {
    $where[] = "r.category_id = ?";
    $params[] = $categoryId;
}

if (!empty($resourceType)) {
    $where[] = "r.resource_type = ?";
    $params[] = $resourceType;
}

$whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

$sql = "
    SELECT r.*, c.name as category_name 
    FROM resources r 
    LEFT JOIN categories c ON r.category_id = c.id 
    {$whereClause} 
    ORDER BY r.downloads_count DESC
";

$resources = $db->fetchAll($sql, $params);
$categories = $db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
$resourceTypes = ['Lecture Notes', 'Sample Papers', 'Study Guide', 'Syllabus', 'E-Book'];

require_once __DIR__ . '/includes/header.php';
?>

<main class="section">
    <div class="container">
        <!-- Header -->
        <div style="margin-bottom: 36px;">
            <span class="section-tag"><i class="fas fa-book-open"></i> Knowledge Vault</span>
            <h1 class="section-title">Verified Educational Resources &amp; Notes</h1>
            <p class="section-subtitle">Access <?= count($resources) ?> high-yield lecture notes, past board question banks, laboratory manuals, and reference guides.</p>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="resources.php" class="filter-bar">
            <div class="filter-grid" style="grid-template-columns: 2fr 1.2fr 1fr auto;">
                <div class="search-input-group" style="background:#f8fafc; padding:10px 14px; border-radius:var(--radius-sm); border:1px solid var(--border-color); display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-search" style="color:var(--primary);"></i>
                    <input type="text" name="q" value="<?= sanitize($search) ?>" placeholder="Search subject, topics (e.g. Data Structures, Physics)..." style="border:none; outline:none; width:100%; background:transparent; font-size:0.95rem;">
                </div>

                <div>
                    <select name="category" class="form-control" onchange="this.form.submit()">
                        <option value="">All Academic Disciplines</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($categoryId === (int)$cat['id']) ? 'selected' : '' ?>>
                                <?= sanitize($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <select name="type" class="form-control" onchange="this.form.submit()">
                        <option value="">All Material Types</option>
                        <?php foreach ($resourceTypes as $rt): ?>
                            <option value="<?= $rt ?>" <?= ($resourceType === $rt) ? 'selected' : '' ?>>
                                <?= $rt ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="display:flex; gap:8px;">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <?php if (!empty($search) || $categoryId > 0 || !empty($resourceType)): ?>
                        <a href="resources.php" class="btn btn-secondary btn-sm" title="Clear Filters">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <!-- Resources Grid -->
        <?php if (!empty($resources)): ?>
            <div class="resources-grid">
                <?php foreach ($resources as $res): ?>
                    <div class="resource-card">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                            <span class="resource-type-badge">
                                <i class="fas fa-file-pdf"></i> <?= sanitize($res['resource_type']) ?>
                            </span>
                            <?php if (!empty($res['category_name'])): ?>
                                <span class="badge badge-secondary"><?= sanitize($res['category_name']) ?></span>
                            <?php endif; ?>
                        </div>

                        <h3 class="resource-title"><?= sanitize($res['title']) ?></h3>
                        <p class="resource-desc"><?= sanitize($res['description']) ?></p>

                        <div class="resource-footer">
                            <span><i class="fas fa-download"></i> <?= number_format($res['downloads_count']) ?> downloads</span>
                            <span><?= sanitize($res['file_size']) ?> • <?= sanitize($res['format']) ?></span>
                        </div>

                        <div style="margin-top: 18px;">
                            <a href="resources.php?download=<?= $res['id'] ?>" class="btn btn-primary btn-sm" style="width:100%;">
                                <i class="fas fa-file-download"></i> Download Resource
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 60px 20px; background:#fff; border:1px solid var(--border-color); border-radius:var(--radius-lg);">
                <i class="fas fa-folder-open" style="font-size:3rem; color:var(--text-muted); margin-bottom:16px;"></i>
                <h3 style="font-size:1.4rem; color:var(--text-primary); margin-bottom:8px;">No Materials Found</h3>
                <p style="color:var(--text-secondary); margin-bottom:24px;">No study resources match the selected criteria.</p>
                <a href="resources.php" class="btn btn-primary">Reset Filters</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
