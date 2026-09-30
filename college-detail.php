<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/database/Database.php';
$db = Database::getInstance();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$college = $db->fetch("SELECT * FROM colleges WHERE id = ?", [$id]);

if (!$college) {
    header("Location: colleges.php");
    exit;
}

$pageTitle = sanitize($college['name']) . " (" . sanitize($college['city']) . ") - " . APP_NAME;
$metaDescription = "Explore " . sanitize($college['name']) . " in " . sanitize($college['city']) . ", Gujarat. " . sanitize($college['type']) . " institution offering " . sanitize($college['courses_offered']);
$activePage = 'colleges';

require_once __DIR__ . '/includes/header.php';

// Other colleges in the same city
$relatedColleges = $db->fetchAll(
    "SELECT * FROM colleges WHERE city = ? AND id != ? LIMIT 4",
    [$college['city'], $id]
);
?>

<main class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size:0.85rem; color:#64748b; margin-bottom:20px;">
            <a href="index.php" style="color:#2563eb; text-decoration:none;"><i class="fas fa-home"></i> Home</a> &rsaquo;
            <a href="colleges.php" style="color:#2563eb; text-decoration:none;">Colleges</a> &rsaquo;
            <a href="colleges.php?city=<?= urlencode($college['city']) ?>" style="color:#2563eb; text-decoration:none;"><?= sanitize($college['city']) ?></a> &rsaquo;
            <span style="color:#0f172a; font-weight:600;"><?= sanitize($college['name']) ?></span>
        </div>

        <!-- College Hero Card -->
        <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:32px; margin-bottom:32px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05); border-top: 4px solid <?= ($college['type'] === 'Government') ? '#10b981' : '#2563eb' ?>;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:20px;">
                <div style="flex:1; min-width:280px;">
                    <div style="display:flex; gap:10px; margin-bottom:12px; flex-wrap:wrap;">
                        <span class="badge <?= ($college['type'] === 'Government') ? 'badge-success' : 'badge-info' ?>" style="font-size:0.85rem; font-weight:700;">
                            <i class="fas <?= ($college['type'] === 'Government') ? 'fa-landmark' : 'fa-building' ?>"></i> <?= sanitize($college['type']) ?> Institution
                        </span>
                        <span class="badge badge-light" style="font-size:0.85rem; color:#334155;">
                            <i class="fas fa-city" style="color:#2563eb;"></i> <?= sanitize($college['city']) ?>, Gujarat
                        </span>
                        <?php if (!empty($college['category'])): ?>
                            <span class="badge badge-light" style="font-size:0.85rem; color:#1e40af; background:#eff6ff;">
                                <i class="fas fa-tag"></i> <?= sanitize($college['category']) ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($college['rating']) && (float)$college['rating'] >= 4.7): ?>
                            <span class="badge badge-warning" style="font-size:0.85rem; font-weight:700;">
                                <i class="fas fa-award"></i> Premier Gujarat Institution
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 style="font-size:1.85rem; font-weight:800; color:#0f172a; line-height:1.3; margin-bottom:12px;">
                        <?= sanitize($college['name']) ?>
                    </h1>

                    <p style="font-size:1rem; color:#475569; line-height:1.6; margin-bottom:16px;">
                        <i class="fas fa-location-dot" style="color:#2563eb; margin-right:6px;"></i>
                        <?= sanitize($college['address']) ?>
                    </p>
                </div>

                <div style="display:flex; flex-direction:column; gap:10px; min-width:200px;">
                    <?php if (!empty($college['website'])): ?>
                        <a href="<?= sanitize($college['website']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="text-align:center;">
                            <i class="fas fa-globe"></i> Visit Official Website
                        </a>
                    <?php endif; ?>
                    <a href="contact.php" class="btn btn-outline" style="text-align:center;">
                        <i class="fas fa-envelope"></i> Ask Admission Query
                    </a>
                </div>
            </div>
        </div>

        <!-- College Detailed Specifications -->
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:30px; align-items:start;">
            
            <!-- Left Column: Details -->
            <div>
                <!-- Institutional Info -->
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:28px; margin-bottom:28px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h2 style="font-size:1.25rem; font-weight:700; color:#0f172a; margin-bottom:20px; border-bottom:2px solid #f1f5f9; padding-bottom:10px;">
                        <i class="fas fa-university" style="color:#2563eb; margin-right:8px;"></i> College Overview &amp; Specifications
                    </h2>

                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:18px;">
                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">Institution Name</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($college['name']) ?></strong>
                        </div>

                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">College Type</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($college['type']) ?></strong>
                        </div>

                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">City / Region</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($college['city']) ?>, Gujarat</strong>
                        </div>

                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">Stream / Discipline</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($college['category']) ?></strong>
                        </div>

                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">Established Year</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($college['established_year']) ?></strong>
                        </div>

                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">Rating</span>
                            <strong style="color:#0f172a; font-size:1rem;">
                                <i class="fas fa-star" style="color:#f59e0b;"></i> <?= sanitize($college['rating']) ?> / 5.0
                            </strong>
                        </div>
                    </div>

                    <!-- Courses Offered Box -->
                    <div style="margin-top:20px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:20px;">
                        <span style="font-size:0.85rem; font-weight:700; color:#1e40af; display:block; margin-bottom:8px;">
                            <i class="fas fa-graduation-cap"></i> Courses &amp; Programs Offered:
                        </span>
                        <div style="color:#1e293b; font-size:1.05rem; font-weight:600; line-height:1.6;">
                            <?= sanitize($college['courses_offered']) ?>
                        </div>
                        <p style="font-size:0.85rem; color:#475569; margin-top:8px; margin-bottom:0;">
                            Admissions to these programs are conducted via ACPC Gujarat, ACPDC, NEET-UG / ACPUGMEC, or institutional entrance test.
                        </p>
                    </div>

                    <!-- Full Address Card -->
                    <div style="margin-top:20px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px 20px;">
                        <span style="font-size:0.82rem; font-weight:700; color:#334155; display:block; margin-bottom:6px;">
                            <i class="fas fa-map-marked-alt" style="color:#2563eb;"></i> Campus Address:
                        </span>
                        <p style="color:#1e293b; font-size:0.95rem; margin:0;">
                            <?= sanitize($college['address']) ?>, <?= sanitize($college['city']) ?>, Gujarat, India
                        </p>
                    </div>

                    <!-- Official Website Link -->
                    <?php if (!empty($college['website'])): ?>
                    <div style="margin-top:16px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:16px 20px; display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <span style="font-size:0.82rem; font-weight:700; color:#166534; display:block;">Official Institute Website</span>
                            <a href="<?= sanitize($college['website']) ?>" target="_blank" rel="noopener noreferrer" style="color:#15803d; font-weight:600; text-decoration:underline;">
                                <?= sanitize($college['website']) ?>
                            </a>
                        </div>
                        <a href="<?= sanitize($college['website']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">
                            Open <i class="fas fa-arrow-up-right-from-square"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Academic Guidance -->
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="font-size:1.1rem; font-weight:700; color:#0f172a; margin-bottom:12px;">
                        <i class="fas fa-compass" style="color:#2563eb; margin-right:6px;"></i> Admission Guidance &amp; Counseling
                    </h3>
                    <p style="color:#64748b; font-size:0.92rem; line-height:1.6; margin-bottom:16px;">
                        Looking for admission eligibility, cutoff trends, seat matrix, or fee structures for <?= sanitize($college['name']) ?>? Connect with our Gujarat student counseling desk.
                    </p>
                    <a href="contact.php" class="btn btn-primary btn-sm">
                        <i class="fas fa-phone-alt"></i> Contact Student Helpdesk
                    </a>
                </div>
            </div>

            <!-- Right Sidebar: City Colleges & Quick Nav -->
            <div>
                <!-- City Quick Link Card -->
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:20px; margin-bottom:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="font-size:1rem; font-weight:700; color:#0f172a; margin-bottom:14px;">
                        <i class="fas fa-university" style="color:#2563eb; margin-right:6px;"></i> More in <?= sanitize($college['city']) ?>
                    </h3>
                    <?php if (empty($relatedColleges)): ?>
                        <p style="font-size:0.85rem; color:#64748b;">Browse more colleges in this city.</p>
                    <?php else: ?>
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <?php foreach ($relatedColleges as $rel): ?>
                                <div style="border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                                    <a href="college-detail.php?id=<?= $rel['id'] ?>" style="font-weight:600; color:#0f172a; text-decoration:none; font-size:0.9rem; display:block; margin-bottom:2px;">
                                        <?= sanitize($rel['name']) ?>
                                    </a>
                                    <span style="font-size:0.75rem; color:#64748b;">
                                        <?= sanitize($rel['type']) ?> &bull; <?= sanitize($rel['category']) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div style="margin-top:16px;">
                        <a href="colleges.php?city=<?= urlencode($college['city']) ?>" class="btn btn-outline btn-sm" style="width:100%; text-align:center;">
                            View All <?= sanitize($college['city']) ?> Colleges &rarr;
                        </a>
                    </div>
                </div>

                <!-- Back to All Colleges -->
                <div style="text-align:center;">
                    <a href="colleges.php" class="btn btn-secondary" style="width:100%;">
                        <i class="fas fa-arrow-left"></i> Back to Colleges Directory
                    </a>
                </div>
            </div>

        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
