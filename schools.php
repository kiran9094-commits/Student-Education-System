<?php
require_once __DIR__ . '/config/constants.php';
$pageTitle = "Gujarat Schools Directory (All 33 Districts & Banaskantha Talukas) - " . APP_NAME;
$metaDescription = "Explore verified Government and Private schools across all 33 Gujarat districts with taluka-level filtering for Banaskantha.";
$activePage = 'schools';

require_once __DIR__ . '/includes/header.php';

// Filter inputs
$search = trim($_GET['q'] ?? '');
$district = trim($_GET['district'] ?? '');
$type = trim($_GET['type'] ?? '');
$taluka = trim($_GET['taluka'] ?? '');
$sortBy = trim($_GET['sort'] ?? 'name');

// Get all 33 districts dynamically from schools table
$districtsList = $db->fetchAll("SELECT DISTINCT district, COUNT(*) as total_schools FROM schools GROUP BY district ORDER BY district ASC");

// Banaskantha talukas list
$banaskanthaTalukas = [
    'Palanpur', 'Deesa', 'Dhanera', 'Tharad', 'Vadgam', 'Danta',
    'Amirgadh', 'Deodar', 'Kankrej', 'Bhabhar', 'Lakhani', 'Suigam', 'Vav'
];

// Query Construction
$where = ["1=1"];
$params = [];

if (!empty($search)) {
    $where[] = "(name LIKE ? OR address LIKE ? OR district LIKE ? OR taluka LIKE ?)";
    $st = "%{$search}%";
    $params = array_merge($params, [$st, $st, $st, $st]);
}

if (!empty($district)) {
    $where[] = "district = ?";
    $params[] = $district;
}

if (!empty($type)) {
    $where[] = "type = ?";
    $params[] = $type;
}

if (!empty($taluka)) {
    $where[] = "taluka LIKE ?";
    $params[] = "%{$taluka}%";
}

$whereClause = "WHERE " . implode(" AND ", $where);

// Sorting
$orderClause = match($sortBy) {
    'rating' => "ORDER BY rating DESC, name ASC",
    'type' => "ORDER BY type ASC, name ASC",
    'district' => "ORDER BY district ASC, name ASC",
    default => "ORDER BY name ASC"
};

$sql = "SELECT * FROM schools {$whereClause} {$orderClause}";
$schools = $db->fetchAll($sql, $params);

// Quick counts for stats
$totalGovt = $db->fetch("SELECT COUNT(*) as c FROM schools WHERE type = 'Government'")['c'] ?? 0;
$totalPvt = $db->fetch("SELECT COUNT(*) as c FROM schools WHERE type = 'Private'")['c'] ?? 0;
?>

<main class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size:0.85rem; color:#64748b; margin-bottom:16px;">
            <a href="index.php" style="color:#2563eb; text-decoration:none;"><i class="fas fa-home"></i> Home</a> &rsaquo;
            <span style="color:#0f172a; font-weight:600;">Schools</span>
            <?php if (!empty($district)): ?>
                &rsaquo; <span style="color:#2563eb;"><?= sanitize($district) ?> District</span>
            <?php endif; ?>
        </div>

        <!-- Page Header -->
        <div style="margin-bottom: 24px; display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px;">
            <div>
                <span class="section-tag"><i class="fas fa-school"></i> Gujarat K-12 &amp; Higher Secondary Education</span>
                <h1 class="section-title" style="margin-bottom:6px;">Schools in Gujarat</h1>
                <p class="section-subtitle">
                    Showing <strong><?= count($schools) ?> schools</strong> 
                    <?= !empty($district) ? "in <strong>" . sanitize($district) . " District</strong>" : "across all 33 districts of Gujarat" ?>
                    <?= !empty($type) ? " &bull; Filtered by <strong>" . sanitize($type) . "</strong>" : "" ?>
                    <?= !empty($taluka) ? " &bull; Taluka: <strong>" . sanitize($taluka) . "</strong>" : "" ?>.
                </p>
            </div>
            <div style="display:flex; gap:10px;">
                <a href="contact.php" class="btn btn-outline">
                    <i class="fas fa-question-circle"></i> Need School Guidance?
                </a>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:20px; margin-bottom:24px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
            <form method="GET" action="schools.php" id="schoolsFilterForm">
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:14px; align-items:end;">
                    
                    <!-- Search input -->
                    <div>
                        <label class="form-label" style="font-size:0.82rem; font-weight:700; color:#334155; margin-bottom:4px; display:block;">
                            <i class="fas fa-search" style="color:#2563eb;"></i> Search School / Location
                        </label>
                        <input type="text" name="q" value="<?= sanitize($search) ?>" class="form-control" placeholder="Search by name, address...">
                    </div>

                    <!-- District Dropdown (Dynamic from Data) -->
                    <div>
                        <label class="form-label" style="font-size:0.82rem; font-weight:700; color:#334155; margin-bottom:4px; display:block;">
                            <i class="fas fa-map-marker-alt" style="color:#2563eb;"></i> Select District (All 33)
                        </label>
                        <select name="district" class="form-control" id="districtSelect" onchange="this.form.submit()">
                            <option value="">All Gujarat Districts (33)</option>
                            <?php foreach ($districtsList as $dRow): ?>
                                <option value="<?= sanitize($dRow['district']) ?>" <?= ($district === $dRow['district']) ? 'selected' : '' ?>>
                                    <?= sanitize($dRow['district']) ?> (<?= $dRow['total_schools'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- School Type Filter -->
                    <div>
                        <label class="form-label" style="font-size:0.82rem; font-weight:700; color:#334155; margin-bottom:4px; display:block;">
                            <i class="fas fa-landmark" style="color:#2563eb;"></i> School Type
                        </label>
                        <select name="type" class="form-control" onchange="this.form.submit()">
                            <option value="">All Types (Govt &amp; Private)</option>
                            <option value="Government" <?= ($type === 'Government') ? 'selected' : '' ?>>Government Schools</option>
                            <option value="Private" <?= ($type === 'Private') ? 'selected' : '' ?>>Private Schools</option>
                        </select>
                    </div>

                    <!-- Banaskantha Taluka Filter (Dynamic / Conditional) -->
                    <?php if ($district === 'Banaskantha' || empty($district)): ?>
                    <div>
                        <label class="form-label" style="font-size:0.82rem; font-weight:700; color:#334155; margin-bottom:4px; display:block;">
                            <i class="fas fa-compass" style="color:#2563eb;"></i> Banaskantha Taluka
                        </label>
                        <select name="taluka" class="form-control" onchange="this.form.submit()">
                            <option value="">All Talukas</option>
                            <?php foreach ($banaskanthaTalukas as $tal): ?>
                                <option value="<?= sanitize($tal) ?>" <?= ($taluka === $tal) ? 'selected' : '' ?>>
                                    <?= sanitize($tal) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <!-- Action buttons -->
                    <div style="display:flex; gap:8px;">
                        <button type="submit" class="btn btn-primary" style="flex:1;">
                            <i class="fas fa-filter"></i> Apply
                        </button>
                        <a href="schools.php" class="btn btn-secondary" title="Reset all filters">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Banaskantha Special Taluka Pill Bar (If Banaskantha selected or quick-explore) -->
        <?php if ($district === 'Banaskantha'): ?>
            <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:var(--radius-md); padding:14px 18px; margin-bottom:24px;">
                <div style="font-weight:700; color:#1e40af; font-size:0.86rem; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-map-pin"></i> Banaskantha Talukas Filter:
                </div>
                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                    <a href="schools.php?district=Banaskantha" class="badge <?= empty($taluka) ? 'badge-primary' : 'badge-light' ?>" style="text-decoration:none; padding:5px 10px;">
                        All Banaskantha
                    </a>
                    <?php foreach ($banaskanthaTalukas as $tal): ?>
                        <a href="schools.php?district=Banaskantha&taluka=<?= urlencode($tal) ?>" 
                           class="badge <?= ($taluka === $tal) ? 'badge-primary' : 'badge-light' ?>" 
                           style="text-decoration:none; padding:5px 10px;">
                            <?= sanitize($tal) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Quick 33 District Fast-Switch Bar -->
        <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-md); padding:14px 18px; margin-bottom:24px;">
            <div style="font-weight:700; color:#334155; font-size:0.84rem; margin-bottom:10px; display:flex; align-items:center; justify-content:space-between;">
                <span><i class="fas fa-city" style="color:#2563eb; margin-right:6px;"></i> Browse by District:</span>
                <span style="font-size:0.75rem; color:#64748b;">(Click any district to view its schools)</span>
            </div>
            <div style="display:flex; flex-wrap:wrap; gap:6px; max-height:110px; overflow-y:auto; padding-right:4px;">
                <a href="schools.php" class="badge <?= empty($district) ? 'badge-primary' : 'badge-light' ?>" style="text-decoration:none; padding:5px 9px; font-size:0.78rem;">
                    All (330)
                </a>
                <?php foreach ($districtsList as $dRow): ?>
                    <a href="schools.php?district=<?= urlencode($dRow['district']) ?><?= !empty($type) ? '&type='.urlencode($type) : '' ?>" 
                       class="badge <?= ($district === $dRow['district']) ? 'badge-primary' : 'badge-light' ?>" 
                       style="text-decoration:none; padding:5px 9px; font-size:0.78rem;">
                        <?= sanitize($dRow['district']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Schools Results Grid -->
        <?php if (empty($schools)): ?>
            <div style="text-align:center; padding:60px 20px; background:#ffffff; border-radius:var(--radius-lg); border:1px dashed #cbd5e1;">
                <i class="fas fa-search" style="font-size:3rem; color:#94a3b8; margin-bottom:16px;"></i>
                <h3 style="color:#1e293b; margin-bottom:8px;">No schools found</h3>
                <p style="color:#64748b; max-width:480px; margin:0 auto 20px;">
                    We couldn't find any schools matching your current filter criteria. Try resetting the filters or searching with a different keyword.
                </p>
                <a href="schools.php" class="btn btn-primary">
                    <i class="fas fa-undo"></i> Reset All Filters
                </a>
            </div>
        <?php else: ?>
            <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:20px;">
                <?php foreach ($schools as $sch): ?>
                    <div class="card" style="display:flex; flex-direction:column; justify-content:space-between; height:100%; transition:transform 0.2s, box-shadow 0.2s;">
                        <div class="card-body">
                            <!-- Badges -->
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; gap:8px;">
                                <span class="badge <?= ($sch['type'] === 'Government') ? 'badge-success' : 'badge-info' ?>" style="font-weight:700;">
                                    <i class="fas <?= ($sch['type'] === 'Government') ? 'fa-landmark' : 'fa-building' ?>"></i> <?= sanitize($sch['type']) ?>
                                </span>
                                <span class="badge badge-light" style="color:#475569;">
                                    <i class="fas fa-map-marker-alt" style="color:#ef4444;"></i> <?= sanitize($sch['district']) ?>
                                    <?= !empty($sch['taluka']) ? ' &bull; ' . sanitize($sch['taluka']) : '' ?>
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 style="font-size:1.05rem; font-weight:700; color:#0f172a; line-height:1.4; margin-bottom:8px;">
                                <a href="school-detail.php?id=<?= $sch['id'] ?>" style="color:#0f172a; text-decoration:none;">
                                    <?= sanitize($sch['name']) ?>
                                </a>
                            </h3>

                            <!-- Address -->
                            <p style="font-size:0.85rem; color:#64748b; line-height:1.5; margin-bottom:12px;">
                                <i class="fas fa-location-dot" style="color:#94a3b8; margin-right:4px;"></i>
                                <?= sanitize($sch['address']) ?>
                            </p>

                            <!-- Board & Medium info -->
                            <div style="background:#f8fafc; border-radius:6px; padding:8px 12px; font-size:0.8rem; color:#475569; display:flex; justify-content:space-between; margin-bottom:14px;">
                                <span><strong>Board:</strong> <?= sanitize($sch['board']) ?></span>
                                <span><strong>Medium:</strong> <?= sanitize($sch['medium']) ?></span>
                            </div>
                        </div>

                        <!-- Card Footer / Actions -->
                        <div style="padding:14px 20px; background:#ffffff; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                            <a href="school-detail.php?id=<?= $sch['id'] ?>" class="btn btn-outline btn-sm" style="flex:1; text-align:center;">
                                <i class="fas fa-info-circle"></i> View Details
                            </a>
                            <?php if (!empty($sch['website'])): ?>
                                <a href="<?= sanitize($sch['website']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" title="Visit Official Website">
                                    <i class="fas fa-external-link-alt"></i> Website
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
