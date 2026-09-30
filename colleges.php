<?php
require_once __DIR__ . '/config/constants.php';
$pageTitle = "Gujarat Colleges & Universities Directory - " . APP_NAME;
$metaDescription = "Explore premier Government and Private colleges and universities across Ahmedabad, Gandhinagar, Vadodara, Surat, Rajkot, and all Gujarat cities.";
$activePage = 'colleges';

require_once __DIR__ . '/includes/header.php';

// Filter inputs
$search = trim($_GET['q'] ?? '');
$city = trim($_GET['city'] ?? '');
$type = trim($_GET['type'] ?? '');
$category = trim($_GET['category'] ?? '');
$sortBy = trim($_GET['sort'] ?? 'rating');

// City data dynamically extracted from the college dataset
$citiesList = $db->fetchAll("SELECT DISTINCT city, COUNT(*) as total_colleges FROM colleges GROUP BY city ORDER BY city ASC");

// Categories list
$categoriesList = $db->fetchAll("SELECT DISTINCT category FROM colleges WHERE category != '' ORDER BY category ASC");

// Query Construction
$where = ["1=1"];
$params = [];

if (!empty($search)) {
    $where[] = "(name LIKE ? OR city LIKE ? OR address LIKE ? OR courses_offered LIKE ? OR category LIKE ?)";
    $st = "%{$search}%";
    $params = array_merge($params, [$st, $st, $st, $st, $st]);
}

if (!empty($city)) {
    $where[] = "city = ?";
    $params[] = $city;
}

if (!empty($type)) {
    $where[] = "type = ?";
    $params[] = $type;
}

if (!empty($category)) {
    $where[] = "(category LIKE ? OR courses_offered LIKE ?)";
    $catTerm = "%{$category}%";
    $params = array_merge($params, [$catTerm, $catTerm]);
}

$whereClause = "WHERE " . implode(" AND ", $where);

// Sorting
$orderClause = match($sortBy) {
    'name' => "ORDER BY name ASC",
    'city' => "ORDER BY city ASC, name ASC",
    'type' => "ORDER BY type ASC, rating DESC",
    'established' => "ORDER BY established_year ASC",
    default => "ORDER BY rating DESC, name ASC"
};

$sql = "SELECT * FROM colleges {$whereClause} {$orderClause}";
$colleges = $db->fetchAll($sql, $params);

// Landmark list for spotlight
$landmarks = $db->fetchAll("SELECT id, name, city, type FROM colleges WHERE rating >= 4.8 ORDER BY rating DESC, name ASC LIMIT 10");
?>

<main class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size:0.85rem; color:#64748b; margin-bottom:16px;">
            <a href="index.php" style="color:#2563eb; text-decoration:none;"><i class="fas fa-home"></i> Home</a> &rsaquo;
            <span style="color:#0f172a; font-weight:600;">Colleges &amp; Universities</span>
            <?php if (!empty($city)): ?>
                &rsaquo; <span style="color:#2563eb;"><?= sanitize($city) ?></span>
            <?php endif; ?>
        </div>

        <!-- Page Header -->
        <div style="margin-bottom: 24px; display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px;">
            <div>
                <span class="section-tag"><i class="fas fa-graduation-cap"></i> Higher Education in Gujarat</span>
                <h1 class="section-title" style="margin-bottom:6px;">Colleges &amp; Universities in Gujarat</h1>
                <p class="section-subtitle">
                    Showing <strong><?= count($colleges) ?> higher education institutions</strong> 
                    <?= !empty($city) ? "in <strong>" . sanitize($city) . "</strong>" : "across major Gujarat educational hubs" ?>
                    <?= !empty($type) ? " &bull; Filtered by <strong>" . sanitize($type) . "</strong>" : "" ?>.
                </p>
            </div>
            <div>
                <a href="courses.php" class="btn btn-outline">
                    <i class="fas fa-book-open"></i> Explore Courses First
                </a>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:20px; margin-bottom:24px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
            <form method="GET" action="colleges.php" id="collegesFilterForm">
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:14px; align-items:end;">
                    
                    <!-- Search input -->
                    <div>
                        <label class="form-label" style="font-size:0.82rem; font-weight:700; color:#334155; margin-bottom:4px; display:block;">
                            <i class="fas fa-search" style="color:#2563eb;"></i> Search College / Degree
                        </label>
                        <input type="text" name="q" value="<?= sanitize($search) ?>" class="form-control" placeholder="Search by name, courses, city...">
                    </div>

                    <!-- City Filter (Dynamic from Data) -->
                    <div>
                        <label class="form-label" style="font-size:0.82rem; font-weight:700; color:#334155; margin-bottom:4px; display:block;">
                            <i class="fas fa-city" style="color:#2563eb;"></i> Select City
                        </label>
                        <select name="city" class="form-control" onchange="this.form.submit()">
                            <option value="">All Gujarat Cities</option>
                            <?php foreach ($citiesList as $cRow): ?>
                                <option value="<?= sanitize($cRow['city']) ?>" <?= ($city === $cRow['city']) ? 'selected' : '' ?>>
                                    <?= sanitize($cRow['city']) ?> (<?= $cRow['total_colleges'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- College Type Filter -->
                    <div>
                        <label class="form-label" style="font-size:0.82rem; font-weight:700; color:#334155; margin-bottom:4px; display:block;">
                            <i class="fas fa-landmark" style="color:#2563eb;"></i> College Type
                        </label>
                        <select name="type" class="form-control" onchange="this.form.submit()">
                            <option value="">All Types (Govt &amp; Private)</option>
                            <option value="Government" <?= ($type === 'Government') ? 'selected' : '' ?>>Government Colleges</option>
                            <option value="Private" <?= ($type === 'Private') ? 'selected' : '' ?>>Private Colleges &amp; Universities</option>
                        </select>
                    </div>

                    <!-- Category / Stream Filter -->
                    <div>
                        <label class="form-label" style="font-size:0.82rem; font-weight:700; color:#334155; margin-bottom:4px; display:block;">
                            <i class="fas fa-layer-group" style="color:#2563eb;"></i> Academic Stream
                        </label>
                        <select name="category" class="form-control" onchange="this.form.submit()">
                            <option value="">All Streams</option>
                            <?php foreach ($categoriesList as $catRow): ?>
                                <option value="<?= sanitize($catRow['category']) ?>" <?= ($category === $catRow['category']) ? 'selected' : '' ?>>
                                    <?= sanitize($catRow['category']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Action buttons -->
                    <div style="display:flex; gap:8px;">
                        <button type="submit" class="btn btn-primary" style="flex:1;">
                            <i class="fas fa-filter"></i> Apply
                        </button>
                        <a href="colleges.php" class="btn btn-secondary" title="Reset all filters">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- City Quick-Pills Bar -->
        <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-md); padding:14px 18px; margin-bottom:24px;">
            <div style="font-weight:700; color:#334155; font-size:0.84rem; margin-bottom:10px; display:flex; align-items:center; justify-content:space-between;">
                <span><i class="fas fa-map-pin" style="color:#2563eb; margin-right:6px;"></i> Browse by Major City Hubs:</span>
                <span style="font-size:0.75rem; color:#64748b;">(Click any city to filter)</span>
            </div>
            <div style="display:flex; flex-wrap:wrap; gap:6px;">
                <a href="colleges.php" class="badge <?= empty($city) ? 'badge-primary' : 'badge-light' ?>" style="text-decoration:none; padding:6px 12px; font-size:0.82rem;">
                    All Cities (<?= count($colleges) ?>)
                </a>
                <?php foreach ($citiesList as $cRow): ?>
                    <a href="colleges.php?city=<?= urlencode($cRow['city']) ?><?= !empty($type) ? '&type='.urlencode($type) : '' ?>" 
                       class="badge <?= ($city === $cRow['city']) ? 'badge-primary' : 'badge-light' ?>" 
                       style="text-decoration:none; padding:6px 12px; font-size:0.82rem;">
                        <?= sanitize($cRow['city']) ?> (<?= $cRow['total_colleges'] ?>)
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Colleges Results Grid -->
        <?php if (empty($colleges)): ?>
            <div style="text-align:center; padding:60px 20px; background:#ffffff; border-radius:var(--radius-lg); border:1px dashed #cbd5e1;">
                <i class="fas fa-university" style="font-size:3rem; color:#94a3b8; margin-bottom:16px;"></i>
                <h3 style="color:#1e293b; margin-bottom:8px;">No colleges found</h3>
                <p style="color:#64748b; max-width:480px; margin:0 auto 20px;">
                    We couldn't find any colleges matching your current filter criteria. Try resetting the filters or searching for another city/keyword.
                </p>
                <a href="colleges.php" class="btn btn-primary">
                    <i class="fas fa-undo"></i> Reset All Filters
                </a>
            </div>
        <?php else: ?>
            <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap:22px;">
                <?php foreach ($colleges as $col): ?>
                    <div class="card" style="display:flex; flex-direction:column; justify-content:space-between; height:100%; transition:transform 0.2s, box-shadow 0.2s; border-top: 3px solid <?= ($col['type'] === 'Government') ? '#10b981' : '#2563eb' ?>;">
                        <div class="card-body">
                            <!-- Badges -->
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; gap:8px;">
                                <span class="badge <?= ($col['type'] === 'Government') ? 'badge-success' : 'badge-info' ?>" style="font-weight:700;">
                                    <i class="fas <?= ($col['type'] === 'Government') ? 'fa-landmark' : 'fa-building' ?>"></i> <?= sanitize($col['type']) ?>
                                </span>
                                <span class="badge badge-light" style="color:#475569;">
                                    <i class="fas fa-map-marker-alt" style="color:#2563eb;"></i> <?= sanitize($col['city']) ?>
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 style="font-size:1.1rem; font-weight:700; color:#0f172a; line-height:1.4; margin-bottom:8px;">
                                <a href="college-detail.php?id=<?= $col['id'] ?>" style="color:#0f172a; text-decoration:none;">
                                    <?= sanitize($col['name']) ?>
                                </a>
                            </h3>

                            <!-- Address -->
                            <p style="font-size:0.85rem; color:#64748b; line-height:1.5; margin-bottom:12px;">
                                <i class="fas fa-location-dot" style="color:#94a3b8; margin-right:4px;"></i>
                                <?= sanitize($col['address']) ?>
                            </p>

                            <!-- Courses Offered -->
                            <div style="background:#f8fafc; border-radius:6px; padding:10px 12px; margin-bottom:14px; border:1px solid #f1f5f9;">
                                <div style="font-size:0.75rem; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:4px;">
                                    <i class="fas fa-graduation-cap" style="color:#2563eb;"></i> Courses &amp; Programs:
                                </div>
                                <div style="font-size:0.85rem; color:#1e293b; font-weight:500;">
                                    <?= sanitize($col['courses_offered']) ?>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer / Actions -->
                        <div style="padding:14px 20px; background:#ffffff; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                            <a href="college-detail.php?id=<?= $col['id'] ?>" class="btn btn-outline btn-sm" style="flex:1; text-align:center;">
                                <i class="fas fa-info-circle"></i> View Details
                            </a>
                            <?php if (!empty($col['website'])): ?>
                                <a href="<?= sanitize($col['website']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" title="Visit Official Website">
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
