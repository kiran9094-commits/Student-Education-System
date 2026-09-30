<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/database/Database.php';
$db = Database::getInstance();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$course = $db->fetch("SELECT * FROM courses_catalog WHERE id = ?", [$id]);

if (!$course) {
    header("Location: courses.php");
    exit;
}

$pageTitle = sanitize($course['name']) . " Course Details, Eligibility, Admission & Colleges in Gujarat - " . APP_NAME;
$metaDescription = "Complete guide to " . sanitize($course['name']) . " in Gujarat. Duration: " . sanitize($course['duration']) . ". Eligibility: " . sanitize($course['eligibility']) . ". Career options & top colleges.";
$activePage = 'courses';

require_once __DIR__ . '/includes/header.php';

// Other courses in the same category
$relatedCourses = $db->fetchAll(
    "SELECT * FROM courses_catalog WHERE category = ? AND id != ? LIMIT 5",
    [$course['category'], $id]
);
?>

<main class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size:0.85rem; color:#64748b; margin-bottom:20px;">
            <a href="index.php" style="color:#2563eb; text-decoration:none;"><i class="fas fa-home"></i> Home</a> &rsaquo;
            <a href="courses.php" style="color:#2563eb; text-decoration:none;">Courses</a> &rsaquo;
            <a href="courses.php?category=<?= urlencode($course['category']) ?>" style="color:#2563eb; text-decoration:none;"><?= sanitize($course['category']) ?></a> &rsaquo;
            <span style="color:#0f172a; font-weight:600;"><?= sanitize($course['name']) ?></span>
        </div>

        <!-- Course Hero Card -->
        <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:36px; margin-bottom:32px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05); border-top: 5px solid var(--primary);">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:20px;">
                <div style="flex:1; min-width:280px;">
                    <div style="display:flex; gap:10px; margin-bottom:12px; flex-wrap:wrap;">
                        <span class="badge badge-primary" style="font-size:0.85rem; font-weight:700;">
                            <?= sanitize($course['category']) ?>
                        </span>
                        <span class="badge badge-light" style="font-size:0.85rem; color:#334155;">
                            <i class="far fa-clock" style="color:#2563eb;"></i> <?= sanitize($course['duration']) ?>
                        </span>
                        <span class="badge badge-light" style="font-size:0.85rem; color:#334155;">
                            <i class="fas fa-layer-group" style="color:#2563eb;"></i> <?= sanitize($course['degree_level']) ?>
                        </span>
                    </div>

                    <h1 style="font-size:2.2rem; font-weight:800; color:#0f172a; line-height:1.2; margin-bottom:14px;">
                        <?= sanitize($course['name']) ?>
                    </h1>

                    <p style="font-size:1.05rem; color:#475569; line-height:1.7; margin-bottom:0; max-width:850px;">
                        <?= sanitize($course['description']) ?>
                    </p>
                </div>

                <div style="display:flex; flex-direction:column; gap:12px; min-width:220px;">
                    <a href="contact.php" class="btn btn-primary" style="text-align:center;">
                        <i class="fas fa-headset"></i> Get Admission Guidance
                    </a>
                    <a href="colleges.php" class="btn btn-outline" style="text-align:center;">
                        <i class="fas fa-university"></i> Find Colleges
                    </a>
                </div>
            </div>
        </div>

        <!-- Course Detailed Specifications Grid -->
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:30px; align-items:start;">
            
            <!-- Left Column: Primary Course Data -->
            <div>
                <!-- 1. Eligibility & Admission Section -->
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:28px; margin-bottom:28px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h2 style="font-size:1.3rem; font-weight:700; color:#0f172a; margin-bottom:18px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-clipboard-check" style="color:#2563eb;"></i> Eligibility &amp; Admission Process
                    </h2>

                    <div style="display:flex; flex-direction:column; gap:16px;">
                        <div style="background:#f8fafc; border-left:4px solid #10b981; padding:16px 20px; border-radius:0 8px 8px 0;">
                            <h4 style="font-size:0.95rem; font-weight:700; color:#0f172a; margin-bottom:4px;">
                                <i class="fas fa-user-check" style="color:#10b981; margin-right:6px;"></i> Minimum Eligibility Criteria:
                            </h4>
                            <p style="color:#334155; font-size:0.95rem; line-height:1.6; margin:0;">
                                <?= sanitize($course['eligibility']) ?>
                            </p>
                        </div>

                        <div style="background:#f8fafc; border-left:4px solid #2563eb; padding:16px 20px; border-radius:0 8px 8px 0;">
                            <h4 style="font-size:0.95rem; font-weight:700; color:#0f172a; margin-bottom:4px;">
                                <i class="fas fa-id-card" style="color:#2563eb; margin-right:6px;"></i> Admission Process &amp; Entrance Exams:
                            </h4>
                            <p style="color:#334155; font-size:0.95rem; line-height:1.6; margin:0;">
                                <?= sanitize($course['admission_info']) ?>
                            </p>
                        </div>

                        <?php if (!empty($course['entrance_exam'])): ?>
                        <div style="background:#eff6ff; border:1px solid #bfdbfe; padding:14px 18px; border-radius:8px; display:flex; align-items:center; gap:12px;">
                            <i class="fas fa-file-signature" style="color:#2563eb; font-size:1.2rem;"></i>
                            <div>
                                <span style="font-size:0.75rem; text-transform:uppercase; font-weight:700; color:#1e40af; display:block;">Required Entrance Examination:</span>
                                <strong style="color:#1e293b; font-size:0.95rem;"><?= sanitize($course['entrance_exam']) ?></strong>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- 2. Career Opportunities & Job Roles -->
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:28px; margin-bottom:28px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h2 style="font-size:1.3rem; font-weight:700; color:#0f172a; margin-bottom:18px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-briefcase" style="color:#2563eb;"></i> Career Options &amp; Employment Prospects
                    </h2>

                    <p style="color:#475569; font-size:0.98rem; line-height:1.7; margin-bottom:16px;">
                        <?= sanitize($course['career_options']) ?>
                    </p>

                    <?php if (!empty($course['job_roles'])): ?>
                    <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:16px 20px;">
                        <span style="font-size:0.8rem; font-weight:700; color:#166534; text-transform:uppercase; display:block; margin-bottom:6px;">
                            <i class="fas fa-award"></i> Common Career Designations:
                        </span>
                        <div style="color:#15803d; font-size:0.95rem; font-weight:600; line-height:1.6;">
                            <?= sanitize($course['job_roles']) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- 3. Related Colleges in Gujarat (Course Specific) -->
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:28px; margin-bottom:28px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h2 style="font-size:1.3rem; font-weight:700; color:#0f172a; margin-bottom:18px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-university" style="color:#2563eb;"></i> Related Colleges &amp; Institutions in Gujarat
                    </h2>

                    <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:20px; margin-bottom:18px;">
                        <span style="font-size:0.8rem; font-weight:700; color:#1e40af; text-transform:uppercase; display:block; margin-bottom:8px;">
                            <i class="fas fa-landmark"></i> Top Institutions Offering <?= sanitize($course['name']) ?>:
                        </span>
                        <div style="color:#1e293b; font-size:1.02rem; font-weight:600; line-height:1.7;">
                            <?= sanitize($course['related_colleges']) ?>
                        </div>
                    </div>

                    <a href="colleges.php?q=<?= urlencode($course['name']) ?>" class="btn btn-outline" style="width:100%; text-align:center;">
                        <i class="fas fa-search"></i> Browse All Gujarat Colleges Offering <?= sanitize($course['name']) ?>
                    </a>
                </div>

                <!-- 4. Syllabus & Curriculum Overview -->
                <?php if (!empty($course['syllabus_overview'])): ?>
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:28px; margin-bottom:28px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h2 style="font-size:1.3rem; font-weight:700; color:#0f172a; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                        <i class="fas fa-book" style="color:#2563eb;"></i> Syllabus &amp; Key Subjects
                    </h2>
                    <p style="color:#475569; font-size:0.95rem; line-height:1.7; margin:0;">
                        <?= sanitize($course['syllabus_overview']) ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right Sidebar: Quick Summary & Related Courses -->
            <div>
                <!-- Quick Info Box -->
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:24px; margin-bottom:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="font-size:1.05rem; font-weight:700; color:#0f172a; margin-bottom:16px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                        <i class="fas fa-list-check" style="color:#2563eb; margin-right:6px;"></i> Quick Highlights
                    </h3>

                    <div style="display:flex; flex-direction:column; gap:12px; font-size:0.9rem;">
                        <div style="display:flex; justify-content:space-between; border-bottom:1px dashed #e2e8f0; padding-bottom:8px;">
                            <span style="color:#64748b;">Course Stream</span>
                            <strong style="color:#0f172a;"><?= sanitize($course['category']) ?></strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; border-bottom:1px dashed #e2e8f0; padding-bottom:8px;">
                            <span style="color:#64748b;">Duration</span>
                            <strong style="color:#0f172a;"><?= sanitize($course['duration']) ?></strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; border-bottom:1px dashed #e2e8f0; padding-bottom:8px;">
                            <span style="color:#64748b;">Level</span>
                            <strong style="color:#0f172a;"><?= sanitize($course['degree_level']) ?></strong>
                        </div>
                        <?php if (!empty($course['average_fee'])): ?>
                        <div style="display:flex; justify-content:space-between; border-bottom:1px dashed #e2e8f0; padding-bottom:8px;">
                            <span style="color:#64748b;">Avg. Fee</span>
                            <strong style="color:#0f172a;"><?= sanitize($course['average_fee']) ?></strong>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div style="margin-top:20px;">
                        <a href="contact.php" class="btn btn-primary btn-sm" style="width:100%; text-align:center;">
                            <i class="fas fa-question-circle"></i> Ask Guidance
                        </a>
                    </div>
                </div>

                <!-- More Courses in this Stream -->
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:20px; margin-bottom:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="font-size:1rem; font-weight:700; color:#0f172a; margin-bottom:14px;">
                        <i class="fas fa-layer-group" style="color:#2563eb; margin-right:6px;"></i> Other <?= sanitize($course['category']) ?> Courses
                    </h3>

                    <?php if (empty($relatedCourses)): ?>
                        <p style="font-size:0.85rem; color:#64748b;">Explore all available courses.</p>
                    <?php else: ?>
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <?php foreach ($relatedCourses as $rel): ?>
                                <div style="border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                                    <a href="course-detail.php?id=<?= $rel['id'] ?>" style="font-weight:600; color:#0f172a; text-decoration:none; font-size:0.9rem; display:block; margin-bottom:2px;">
                                        <?= sanitize($rel['name']) ?>
                                    </a>
                                    <span style="font-size:0.75rem; color:#64748b;">
                                        <?= sanitize($rel['duration']) ?> &bull; <?= sanitize($rel['degree_level']) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div style="margin-top:16px;">
                        <a href="courses.php?category=<?= urlencode($course['category']) ?>" class="btn btn-outline btn-sm" style="width:100%; text-align:center;">
                            View All <?= sanitize($course['category']) ?> Courses &rarr;
                        </a>
                    </div>
                </div>

                <!-- Back to All Courses -->
                <div style="text-align:center;">
                    <a href="courses.php" class="btn btn-secondary" style="width:100%;">
                        <i class="fas fa-arrow-left"></i> Back to Courses Directory
                    </a>
                </div>
            </div>

        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
