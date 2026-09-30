<?php
require_once __DIR__ . '/config/constants.php';
$pageTitle = "Explore Schools, Colleges & Universities - " . APP_NAME;
$metaDescription = "Search and filter through top accredited universities, colleges, and premier secondary schools with rankings and fee structures.";
$activePage = 'institutions';

require_once __DIR__ . '/includes/header.php';

// Get filter inputs
$search = trim($_GET['q'] ?? '');
$type = trim($_GET['type'] ?? '');
$state = trim($_GET['state'] ?? '');
$district = trim($_GET['district'] ?? '');
$sortBy = trim($_GET['sort'] ?? 'rating');

// Build query
$where = [];
$params = [];

if (!empty($search)) {
    $where[] = "(name LIKE ? OR city LIKE ? OR state LIKE ? OR address LIKE ? OR description LIKE ?)";
    $st = "%{$search}%";
    $params = array_merge($params, [$st, $st, $st, $st, $st]);
}

if (!empty($type)) {
    $where[] = "type = ?";
    $params[] = $type;
}

if (!empty($state)) {
    $where[] = "state = ?";
    $params[] = $state;
}

if (!empty($district)) {
    $where[] = "(city LIKE ? OR address LIKE ?)";
    $dt = "%{$district}%";
    $params = array_merge($params, [$dt, $dt]);
}

$whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

// Sorting
$orderBy = match($sortBy) {
    'name' => "ORDER BY name ASC",
    'rating' => "ORDER BY rating DESC, reviews_count DESC",
    'established' => "ORDER BY established_year ASC",
    default => "ORDER BY rating DESC"
};

$sql = "SELECT * FROM institutions {$whereClause} {$orderBy}";
$institutions = $db->fetchAll($sql, $params);

// Gujarat 33 Districts List
$gujaratDistricts = [
    'Ahmedabad', 'Amreli', 'Anand', 'Aravalli', 'Banaskantha', 'Bharuch',
    'Bhavnagar', 'Botad', 'Chhota Udaipur', 'Dahod', 'Dang', 'Devbhumi Dwarka',
    'Gandhinagar', 'Gir Somnath', 'Jamnagar', 'Junagadh', 'Kheda', 'Kutch',
    'Mahisagar', 'Mehsana', 'Morbi', 'Narmada', 'Navsari', 'Panchmahal',
    'Patan', 'Porbandar', 'Rajkot', 'Sabarkantha', 'Surat', 'Surendranagar',
    'Tapi', 'Vadodara', 'Valsad'
];

// Get unique states for filter dropdown
$states = $db->fetchAll("SELECT DISTINCT state FROM institutions ORDER BY state ASC");
?>

<main class="section">
    <div class="container">
        <!-- Header -->
        <div style="margin-bottom: 28px;">
            <span class="section-tag"><i class="fas fa-university"></i> Institution Directory</span>
            <h1 class="section-title">Verified Higher Education Campuses &amp; Schools</h1>
            <p class="section-subtitle">Browse <?= count($institutions) ?> verified institutions across all 33 districts of Gujarat and nationwide.</p>
        </div>

        <!-- Quick Gujarat District Filter Chips -->
        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:24px; align-items:center;">
            <span style="font-weight:700; color:#334155; font-size:0.86rem;"><i class="fas fa-map-marked-alt" style="color:#4f46e5;"></i> Quick Districts:</span>
            <a href="institutions.php?district=Banaskantha" class="badge <?= ($district === 'Banaskantha') ? 'badge-primary' : 'badge-light' ?>" style="text-decoration:none; padding:6px 12px; font-size:0.82rem;">Banaskantha</a>
            <a href="institutions.php?district=Ahmedabad" class="badge <?= ($district === 'Ahmedabad') ? 'badge-primary' : 'badge-light' ?>" style="text-decoration:none; padding:6px 12px; font-size:0.82rem;">Ahmedabad</a>
            <a href="institutions.php?district=Surat" class="badge <?= ($district === 'Surat') ? 'badge-primary' : 'badge-light' ?>" style="text-decoration:none; padding:6px 12px; font-size:0.82rem;">Surat</a>
            <a href="institutions.php?district=Rajkot" class="badge <?= ($district === 'Rajkot') ? 'badge-primary' : 'badge-light' ?>" style="text-decoration:none; padding:6px 12px; font-size:0.82rem;">Rajkot</a>
            <a href="institutions.php?district=Vadodara" class="badge <?= ($district === 'Vadodara') ? 'badge-primary' : 'badge-light' ?>" style="text-decoration:none; padding:6px 12px; font-size:0.82rem;">Vadodara</a>
            <a href="institutions.php?district=Mehsana" class="badge <?= ($district === 'Mehsana') ? 'badge-primary' : 'badge-light' ?>" style="text-decoration:none; padding:6px 12px; font-size:0.82rem;">Mehsana</a>
            <a href="institutions.php?district=Kutch" class="badge <?= ($district === 'Kutch') ? 'badge-primary' : 'badge-light' ?>" style="text-decoration:none; padding:6px 12px; font-size:0.82rem;">Kutch</a>
            <a href="institutions.php?type=School" class="badge <?= ($type === 'School') ? 'badge-primary' : 'badge-warning' ?>" style="text-decoration:none; padding:6px 12px; font-size:0.82rem;"><i class="fas fa-school"></i> All Schools (330)</a>
            <a href="institutions.php?type=College" class="badge <?= ($type === 'College') ? 'badge-primary' : 'badge-info' ?>" style="text-decoration:none; padding:6px 12px; font-size:0.82rem;"><i class="fas fa-university"></i> Colleges</a>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="institutions.php" class="filter-bar">
            <div class="filter-grid" style="grid-template-columns: 1.5fr 1fr 1fr 1fr auto;">
                <div class="search-input-group" style="background:#f8fafc; padding:10px 14px; border-radius:var(--radius-sm); border:1px solid var(--border-color); display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-search" style="color:var(--primary);"></i>
                    <input type="text" name="q" value="<?= sanitize($search) ?>" placeholder="Search district (e.g. Banaskantha, Surat), school, college..." style="border:none; outline:none; width:100%; background:transparent; font-size:0.95rem;">
                </div>

                <div>
                    <select name="district" class="form-control" onchange="this.form.submit()">
                        <option value="">All Gujarat Districts (33)</option>
                        <?php foreach ($gujaratDistricts as $d): ?>
                            <option value="<?= sanitize($d) ?>" <?= ($district === $d) ? 'selected' : '' ?>>
                                <?= sanitize($d) ?> District
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <select name="type" class="form-control" onchange="this.form.submit()">
                        <option value="">All Institution Types</option>
                        <option value="School" <?= ($type === 'School') ? 'selected' : '' ?>>Schools (10 per district)</option>
                        <option value="College" <?= ($type === 'College') ? 'selected' : '' ?>>Colleges</option>
                        <option value="University" <?= ($type === 'University') ? 'selected' : '' ?>>Universities</option>
                    </select>
                </div>

                <div>
                    <select name="sort" class="form-control" onchange="this.form.submit()">
                        <option value="rating" <?= ($sortBy === 'rating') ? 'selected' : '' ?>>Highest Rating</option>
                        <option value="name" <?= ($sortBy === 'name') ? 'selected' : '' ?>>Name (A-Z)</option>
                        <option value="established" <?= ($sortBy === 'established') ? 'selected' : '' ?>>Oldest Campus</option>
                    </select>
                </div>

                <div style="display:flex; gap:8px;">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <?php if (!empty($search) || !empty($type) || !empty($state) || !empty($district)): ?>
                        <a href="institutions.php" class="btn btn-secondary btn-sm" title="Clear Filters">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <!-- Institutions Grid -->
        <?php if (!empty($institutions)): ?>
            <div class="institutions-grid">
                <?php foreach ($institutions as $inst): ?>
                    <div class="institution-card">
                        <div class="card-banner">
                            <img src="<?= sanitize($inst['banner_image']) ?>" alt="<?= sanitize($inst['name']) ?>">
                            <div class="card-badge-top">
                                <?= renderBadge($inst['type'], $inst['type']) ?>
                                <?php if (!empty($inst['ranking_nirf'])): ?>
                                    <span class="badge badge-warning"><?= sanitize($inst['ranking_nirf']) ?></span>
                                <?php endif; ?>
                            </div>
                            <button type="button" class="bookmark-btn" 
                                    data-bookmark-id="<?= $inst['id'] ?>" 
                                    data-bookmark-type="institution" 
                                    data-bookmark-name="<?= sanitize($inst['name']) ?>"
                                    aria-label="Bookmark Institution">
                                <i class="far fa-bookmark"></i>
                            </button>
                            <div class="card-logo">
                                <img src="<?= sanitize($inst['logo_image']) ?>" alt="<?= sanitize($inst['name']) ?> Logo">
                            </div>
                        </div>

                        <div class="card-body">
                            <h3 class="card-title">
                                <a href="institution-detail.php?id=<?= $inst['id'] ?>"><?= sanitize($inst['name']) ?></a>
                            </h3>
                            <div class="card-location">
                                <i class="fas fa-map-marker-alt" style="color:#ef4444;"></i>
                                <span><?= sanitize($inst['city']) ?>, <?= sanitize($inst['state']) ?></span>
                                <?php if (!empty($inst['established_year'])): ?>
                                    <span>• Estd. <?= (int)$inst['established_year'] ?></span>
                                <?php endif; ?>
                            </div>

                            <div style="font-size:0.86rem; color:#475569; margin-bottom:12px; line-height:1.5;">
                                <?= sanitize(mb_substr($inst['description'], 0, 110)) ?>...
                            </div>

                            <div class="card-rating-row">
                                <?= renderRatingStars($inst['rating']) ?>
                                <span class="reviews-count"><?= (int)$inst['reviews_count'] ?> reviews</span>
                            </div>

                            <div class="card-fees">
                                Est. Tuition: <strong><?= sanitize($inst['tuition_range']) ?></strong>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="institution-detail.php?id=<?= $inst['id'] ?>" class="btn btn-secondary btn-sm">
                                View Profile
                            </a>
                            <button type="button" class="btn btn-primary btn-sm" 
                                    data-open-inquiry 
                                    data-institution-id="<?= $inst['id'] ?>" 
                                    data-institution-name="<?= sanitize($inst['name']) ?>">
                                Apply / Inquiry
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 60px 20px; background:#fff; border:1px solid var(--border-color); border-radius:var(--radius-lg);">
                <i class="fas fa-search" style="font-size:3rem; color:var(--text-muted); margin-bottom:16px;"></i>
                <h3 style="font-size:1.4rem; color:var(--text-primary); margin-bottom:8px;">No Institutions Found</h3>
                <p style="color:var(--text-secondary); margin-bottom:24px;">No schools or colleges match your selected filters. Try broadening your search.</p>
                <a href="institutions.php" class="btn btn-primary">Reset All Filters</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
