<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/database/Database.php';
$db = Database::getInstance();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$school = $db->fetch("SELECT * FROM schools WHERE id = ?", [$id]);

if (!$school) {
    header("Location: schools.php");
    exit;
}

$pageTitle = sanitize($school['name']) . " (" . sanitize($school['district']) . ") - " . APP_NAME;
$metaDescription = "Details for " . sanitize($school['name']) . " located in " . sanitize($school['district']) . ", Gujarat. " . sanitize($school['type']) . " institution.";
$activePage = 'schools';

require_once __DIR__ . '/includes/header.php';

// Other schools in same district
$relatedSchools = $db->fetchAll(
    "SELECT * FROM schools WHERE district = ? AND id != ? LIMIT 4",
    [$school['district'], $id]
);
?>

<main class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size:0.85rem; color:#64748b; margin-bottom:20px;">
            <a href="index.php" style="color:#2563eb; text-decoration:none;"><i class="fas fa-home"></i> Home</a> &rsaquo;
            <a href="schools.php" style="color:#2563eb; text-decoration:none;">Schools</a> &rsaquo;
            <a href="schools.php?district=<?= urlencode($school['district']) ?>" style="color:#2563eb; text-decoration:none;"><?= sanitize($school['district']) ?></a> &rsaquo;
            <span style="color:#0f172a; font-weight:600;"><?= sanitize($school['name']) ?></span>
        </div>

        <!-- School Hero Card -->
        <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:32px; margin-bottom:32px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:20px;">
                <div style="flex:1; min-width:280px;">
                    <div style="display:flex; gap:10px; margin-bottom:12px; flex-wrap:wrap;">
                        <span class="badge <?= ($school['type'] === 'Government') ? 'badge-success' : 'badge-info' ?>" style="font-size:0.85rem; font-weight:700;">
                            <i class="fas <?= ($school['type'] === 'Government') ? 'fa-landmark' : 'fa-building' ?>"></i> <?= sanitize($school['type']) ?> School
                        </span>
                        <span class="badge badge-light" style="font-size:0.85rem; color:#334155;">
                            <i class="fas fa-map-marker-alt" style="color:#ef4444;"></i> <?= sanitize($school['district']) ?> District
                        </span>
                        <?php if (!empty($school['taluka'])): ?>
                            <span class="badge badge-light" style="font-size:0.85rem; color:#1e40af; background:#eff6ff;">
                                <i class="fas fa-compass"></i> Taluka: <?= sanitize($school['taluka']) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 style="font-size:1.85rem; font-weight:800; color:#0f172a; line-height:1.3; margin-bottom:12px;">
                        <?= sanitize($school['name']) ?>
                    </h1>

                    <p style="font-size:1rem; color:#475569; line-height:1.6; margin-bottom:16px;">
                        <i class="fas fa-location-dot" style="color:#2563eb; margin-right:6px;"></i>
                        <?= sanitize($school['address']) ?>
                        <?= !empty($school['pincode']) ? ' - ' . sanitize($school['pincode']) : '' ?>
                    </p>
                </div>

                <div style="display:flex; flex-direction:column; gap:10px; min-width:200px;">
                    <?php if (!empty($school['website'])): ?>
                        <a href="<?= sanitize($school['website']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="text-align:center;">
                            <i class="fas fa-globe"></i> Visit Official Website
                        </a>
                    <?php endif; ?>
                    <a href="contact.php" class="btn btn-outline" style="text-align:center;">
                        <i class="fas fa-envelope"></i> School Inquiry
                    </a>
                </div>
            </div>
        </div>

        <!-- School Detailed Specifications -->
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:30px; align-items:start;">
            
            <!-- Left Column: Details -->
            <div>
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:28px; margin-bottom:28px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h2 style="font-size:1.25rem; font-weight:700; color:#0f172a; margin-bottom:20px; border-bottom:2px solid #f1f5f9; padding-bottom:10px;">
                        <i class="fas fa-info-circle" style="color:#2563eb; margin-right:8px;"></i> Complete School Information
                    </h2>

                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:18px;">
                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">School Name</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($school['name']) ?></strong>
                        </div>

                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">Institution Type</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($school['type']) ?> School</strong>
                        </div>

                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">District</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($school['district']) ?></strong>
                        </div>

                        <?php if (!empty($school['taluka'])): ?>
                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">Taluka</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($school['taluka']) ?></strong>
                        </div>
                        <?php endif; ?>

                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">Affiliation Board</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($school['board']) ?></strong>
                        </div>

                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">Medium of Instruction</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($school['medium']) ?></strong>
                        </div>

                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">Established Year</span>
                            <strong style="color:#0f172a; font-size:1rem;"><?= sanitize($school['established_year']) ?></strong>
                        </div>

                        <div style="background:#f8fafc; padding:16px; border-radius:8px; border:1px solid #e2e8f0;">
                            <span style="font-size:0.8rem; color:#64748b; display:block; margin-bottom:4px;">Rating</span>
                            <strong style="color:#0f172a; font-size:1rem;">
                                <i class="fas fa-star" style="color:#f59e0b;"></i> <?= sanitize($school['rating']) ?> / 5.0
                            </strong>
                        </div>
                    </div>

                    <!-- Full Address Card -->
                    <div style="margin-top:20px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:16px 20px;">
                        <span style="font-size:0.82rem; font-weight:700; color:#1e40af; display:block; margin-bottom:6px;">
                            <i class="fas fa-map-marked-alt"></i> Complete Address:
                        </span>
                        <p style="color:#1e293b; font-size:0.95rem; margin:0;">
                            <?= sanitize($school['address']) ?>, <?= sanitize($school['district']) ?>, Gujarat, India
                            <?= !empty($school['pincode']) ? ' - ' . sanitize($school['pincode']) : '' ?>
                        </p>
                    </div>

                    <!-- Official Website Link -->
                    <?php if (!empty($school['website'])): ?>
                    <div style="margin-top:16px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:16px 20px; display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <span style="font-size:0.82rem; font-weight:700; color:#166534; display:block;">Official Website</span>
                            <a href="<?= sanitize($school['website']) ?>" target="_blank" rel="noopener noreferrer" style="color:#15803d; font-weight:600; text-decoration:underline;">
                                <?= sanitize($school['website']) ?>
                            </a>
                        </div>
                        <a href="<?= sanitize($school['website']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">
                            Open <i class="fas fa-arrow-up-right-from-square"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Guidance Note -->
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="font-size:1.1rem; font-weight:700; color:#0f172a; margin-bottom:12px;">
                        <i class="fas fa-user-graduate" style="color:#2563eb; margin-right:6px;"></i> Admission &amp; Enrollment Guidance
                    </h3>
                    <p style="color:#64748b; font-size:0.92rem; line-height:1.6; margin-bottom:16px;">
                        Government schools in <?= sanitize($school['district']) ?> conduct admissions through GSEB RTE (Right to Education) regulations and direct registration at the school office. Private institutions follow CBSE/GSEB admission cycles typically starting in December–March.
                    </p>
                    <a href="contact.php" class="btn btn-primary btn-sm">
                        <i class="fas fa-question-circle"></i> Ask Admission Question
                    </a>
                </div>
            </div>

            <!-- Right Sidebar: District Schools & Quick Nav -->
            <div>
                <!-- District Quick Link Card -->
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:20px; margin-bottom:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="font-size:1rem; font-weight:700; color:#0f172a; margin-bottom:14px;">
                        <i class="fas fa-school" style="color:#2563eb; margin-right:6px;"></i> More in <?= sanitize($school['district']) ?>
                    </h3>
                    <?php if (empty($relatedSchools)): ?>
                        <p style="font-size:0.85rem; color:#64748b;">Browse more schools in this district.</p>
                    <?php else: ?>
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <?php foreach ($relatedSchools as $rel): ?>
                                <div style="border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                                    <a href="school-detail.php?id=<?= $rel['id'] ?>" style="font-weight:600; color:#0f172a; text-decoration:none; font-size:0.9rem; display:block; margin-bottom:2px;">
                                        <?= sanitize($rel['name']) ?>
                                    </a>
                                    <span style="font-size:0.75rem; color:#64748b;">
                                        <?= sanitize($rel['type']) ?> &bull; <?= sanitize($rel['board']) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div style="margin-top:16px;">
                        <a href="schools.php?district=<?= urlencode($school['district']) ?>" class="btn btn-outline btn-sm" style="width:100%; text-align:center;">
                            View All <?= sanitize($school['district']) ?> Schools &rarr;
                        </a>
                    </div>
                </div>

                <!-- Back to All Schools -->
                <div style="text-align:center;">
                    <a href="schools.php" class="btn btn-secondary" style="width:100%;">
                        <i class="fas fa-arrow-left"></i> Back to Schools Directory
                    </a>
                </div>
            </div>

        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
