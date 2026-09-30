<?php
require_once __DIR__ . '/config/constants.php';
$pageTitle = "Explore Courses & Academic Programs - " . APP_NAME;
$metaDescription = "Explore complete Gujarat undergraduate and postgraduate courses: MBBS, BDS, BAMS, BHMS, Engineering, BCA, MCA, MBA, BBA, B.Com, Arts and more.";
$activePage = 'courses';

require_once __DIR__ . '/includes/header.php';

// Filter inputs
$search = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');
$level = trim($_GET['level'] ?? '');

// Categories
$categories = [
    'SCIENCE' => 'Science & Medical',
    'ENGINEERING' => 'Engineering & Technology',
    'COMPUTER / IT' => 'Computer / IT',
    'MANAGEMENT' => 'Management & Commerce',
    'ARTS' => 'Arts & Social Sciences'
];

// Query Construction
$where = ["1=1"];
$params = [];

if (!empty($search)) {
    $where[] = "(name LIKE ? OR description LIKE ? OR career_options LIKE ? OR eligibility LIKE ? OR related_colleges LIKE ?)";
    $st = "%{$search}%";
    $params = array_merge($params, [$st, $st, $st, $st, $st]);
}

if (!empty($category)) {
    $where[] = "category = ?";
    $params[] = $category;
}

if (!empty($level)) {
    $where[] = "degree_level LIKE ?";
    $params[] = "%{$level}%";
}

$whereClause = "WHERE " . implode(" AND ", $where);
$sql = "SELECT * FROM courses_catalog {$whereClause} ORDER BY category ASC, id ASC";
$courses = $db->fetchAll($sql, $params);

// Category counts
$categoryCounts = [];
foreach ($categories as $catKey => $catLabel) {
    $c = $db->fetch("SELECT COUNT(*) as cnt FROM courses_catalog WHERE category = ?", [$catKey]);
    $categoryCounts[$catKey] = $c['cnt'] ?? 0;
}
$totalCoursesCount = $db->fetch("SELECT COUNT(*) as cnt FROM courses_catalog")['cnt'] ?? 0;
?>

<main class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size:0.85rem; color:#64748b; margin-bottom:16px;">
            <a href="index.php" style="color:#2563eb; text-decoration:none;"><i class="fas fa-home"></i> Home</a> &rsaquo;
            <span style="color:#0f172a; font-weight:600;">Courses</span>
            <?php if (!empty($category) && isset($categories[$category])): ?>
                &rsaquo; <span style="color:#2563eb;"><?= sanitize($categories[$category]) ?></span>
            <?php endif; ?>
        </div>

        <!-- Page Header -->
        <div style="margin-bottom: 24px; display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px;">
            <div>
                <span class="section-tag"><i class="fas fa-book-open"></i> Career Path &amp; Program Directory</span>
                <h1 class="section-title" style="margin-bottom:6px;">Educational Courses &amp; Degrees</h1>
                <p class="section-subtitle">
                    Explore <strong><?= count($courses) ?> dedicated courses</strong> with authentic Gujarat eligibility, admission procedures, and affiliated colleges.
                </p>
            </div>
            <div>
                <a href="contact.php" class="btn btn-primary">
                    <i class="fas fa-compass"></i> Career Counseling
                </a>
            </div>
        </div>

        <!-- Stream Tabs Navigation -->
        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:24px; border-bottom:2px solid #e2e8f0; padding-bottom:12px;">
            <a href="courses.php<?= !empty($search) ? '?q='.urlencode($search) : '' ?>" 
               class="badge <?= empty($category) ? 'badge-primary' : 'badge-light' ?>" 
               style="text-decoration:none; padding:10px 18px; font-size:0.9rem; font-weight:700; border-radius:30px;">
                <i class="fas fa-th-large"></i> All Streams (<?= $totalCoursesCount ?>)
            </a>
            <?php foreach ($categories as $catKey => $catLabel): ?>
                <a href="courses.php?category=<?= urlencode($catKey) ?><?= !empty($search) ? '&q='.urlencode($search) : '' ?>" 
                   class="badge <?= ($category === $catKey) ? 'badge-primary' : 'badge-light' ?>" 
                   style="text-decoration:none; padding:10px 18px; font-size:0.9rem; font-weight:700; border-radius:30px;">
                    <?php
                        $icon = match($catKey) {
                            'SCIENCE' => 'fa-stethoscope',
                            'ENGINEERING' => 'fa-cogs',
                            'COMPUTER / IT' => 'fa-laptop-code',
                            'MANAGEMENT' => 'fa-briefcase',
                            'ARTS' => 'fa-palette',
                            default => 'fa-graduation-cap'
                        };
                    ?>
                    <i class="fas <?= $icon ?>"></i> <?= $catLabel ?> (<?= $categoryCounts[$catKey] ?? 0 ?>)
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Search Bar -->
        <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:18px; margin-bottom:30px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
            <form method="GET" action="courses.php">
                <?php if (!empty($category)): ?>
                    <input type="hidden" name="category" value="<?= sanitize($category) ?>">
                <?php endif; ?>
                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <div style="flex:1; min-width:260px;">
                        <input type="text" name="q" value="<?= sanitize($search) ?>" class="form-control" placeholder="Search courses (e.g. MBBS, BDS, BAMS, Computer Engineering, BCA, MBA...)...">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search Courses
                    </button>
                    <?php if (!empty($search) || !empty($category)): ?>
                        <a href="courses.php" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Clear Filter
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Courses Cards Grid -->
        <?php if (empty($courses)): ?>
            <div style="text-align:center; padding:60px 20px; background:#ffffff; border-radius:var(--radius-lg); border:1px dashed #cbd5e1;">
                <i class="fas fa-graduation-cap" style="font-size:3rem; color:#94a3b8; margin-bottom:16px;"></i>
                <h3 style="color:#1e293b; margin-bottom:8px;">No courses found</h3>
                <p style="color:#64748b; max-width:480px; margin:0 auto 20px;">
                    No academic program matched your search keyword. Please try a different query or select another stream.
                </p>
                <a href="courses.php" class="btn btn-primary">
                    <i class="fas fa-undo"></i> View All Courses
                </a>
            </div>
        <?php else: ?>
            <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap:24px;">
                <?php foreach ($courses as $c): ?>
                    <div class="card" style="display:flex; flex-direction:column; justify-content:space-between; height:100%; transition:transform 0.2s, box-shadow 0.2s; border-top: 4px solid var(--primary);">
                        <div class="card-body">
                            <!-- Stream & Duration badges -->
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; gap:8px;">
                                <span class="badge badge-primary" style="font-size:0.75rem; font-weight:700;">
                                    <?= sanitize($c['category']) ?>
                                </span>
                                <span class="badge badge-light" style="color:#475569; font-size:0.78rem;">
                                    <i class="far fa-clock"></i> <?= sanitize($c['duration']) ?>
                                </span>
                            </div>

                            <!-- Course Title -->
                            <h3 style="font-size:1.25rem; font-weight:800; color:#0f172a; margin-bottom:8px; line-height:1.3;">
                                <a href="course-detail.php?id=<?= $c['id'] ?>" style="color:#0f172a; text-decoration:none;">
                                    <?= sanitize($c['name']) ?>
                                </a>
                            </h3>

                            <!-- Course Description -->
                            <p style="font-size:0.88rem; color:#475569; line-height:1.6; margin-bottom:16px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;">
                                <?= sanitize($c['description']) ?>
                            </p>

                            <!-- Key Specs -->
                            <div style="background:#f8fafc; border-radius:8px; padding:12px; font-size:0.82rem; margin-bottom:14px; border:1px solid #e2e8f0; display:flex; flex-direction:column; gap:6px;">
                                <div>
                                    <strong style="color:#1e293b;"><i class="fas fa-check-circle" style="color:#10b981; margin-right:4px;"></i> Eligibility:</strong> 
                                    <span style="color:#64748b;"><?= sanitize($c['eligibility']) ?></span>
                                </div>
                                <div>
                                    <strong style="color:#1e293b;"><i class="fas fa-id-card" style="color:#2563eb; margin-right:4px;"></i> Admission:</strong> 
                                    <span style="color:#64748b;"><?= sanitize($c['entrance_exam'] ?: 'Merit / Entrance Exam') ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div style="padding:14px 20px; background:#ffffff; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                            <a href="course-detail.php?id=<?= $c['id'] ?>" class="btn btn-primary btn-sm" style="flex:1; text-align:center;">
                                <i class="fas fa-info-circle"></i> View Full Course Details
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
