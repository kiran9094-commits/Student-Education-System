<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/database/Database.php';
require_once __DIR__ . '/includes/functions.php';

$db = Database::getInstance();
$id = (int)($_GET['id'] ?? 0);

$institution = $db->fetch("SELECT * FROM institutions WHERE id = ?", [$id]);

if (!$institution) {
    header("Location: institutions.php");
    exit;
}

$pageTitle = $institution['name'] . " - Courses, Fees, Admissions & Review";
$metaDescription = "Explore courses, admission cutoffs, fee structures, and campus reviews for " . $institution['name'];
$activePage = 'institutions';

// Fetch courses offered by this institution
$courses = $db->fetchAll("
    SELECT c.*, cat.name as category_name 
    FROM courses c 
    LEFT JOIN categories cat ON c.category_id = cat.id 
    WHERE c.institution_id = ? 
    ORDER BY c.is_popular DESC, c.name ASC
", [$id]);

// Fetch reviews for this institution
$reviews = $db->fetchAll("
    SELECT * FROM reviews 
    WHERE institution_id = ? 
    ORDER BY id DESC
", [$id]);

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_review') {
    $reviewerName = trim($_POST['student_name'] ?? '');
    $courseName = trim($_POST['course_name'] ?? '');
    $rating = (int)($_POST['rating'] ?? 5);
    $reviewTitle = trim($_POST['review_title'] ?? '');
    $reviewContent = trim($_POST['review_content'] ?? '');
    $batchYear = trim($_POST['batch_year'] ?? 'Current Student');

    if (!empty($reviewerName) && !empty($reviewTitle) && !empty($reviewContent)) {
        $db->query("
            INSERT INTO reviews (institution_id, student_name, course_name, rating, review_title, review_content, batch_year) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ", [$id, $reviewerName, $courseName, $rating, $reviewTitle, $reviewContent, $batchYear]);

        // Update institution review count & average rating
        $stat = $db->fetch("SELECT COUNT(*) as cnt, AVG(rating) as avg_r FROM reviews WHERE institution_id = ?", [$id]);
        $newCnt = (int)($stat['cnt'] ?? 1);
        $newRating = round((float)($stat['avg_r'] ?? 5.0), 1);
        $db->query("UPDATE institutions SET reviews_count = ?, rating = ? WHERE id = ?", [$newCnt, $newRating, $id]);

        setFlash('success', 'Your campus review has been posted successfully!');
        header("Location: institution-detail.php?id=" . $id);
        exit;
    }
}

require_once __DIR__ . '/includes/header.php';
$facilitiesList = getFacilitiesArray($institution['facilities']);
?>

<main>
    <!-- Detail Hero Banner -->
    <section class="detail-hero">
        <div class="container">
            <div style="margin-bottom: 20px;">
                <a href="institutions.php" style="color:#94a3b8; font-size:0.9rem; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-arrow-left"></i> Back to Institutions
                </a>
            </div>

            <div class="detail-hero-content">
                <img src="<?= sanitize($institution['logo_image']) ?>" alt="<?= sanitize($institution['name']) ?> Logo" class="detail-logo">

                <div style="flex:1;">
                    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                        <?= renderBadge($institution['type'], $institution['type']) ?>
                        <span class="badge badge-warning"><?= sanitize($institution['accreditation']) ?></span>
                        <?php if (!empty($institution['ranking_nirf'])): ?>
                            <span class="badge badge-purple"><?= sanitize($institution['ranking_nirf']) ?></span>
                        <?php endif; ?>
                    </div>

                    <h1 class="detail-title"><?= sanitize($institution['name']) ?></h1>
                    
                    <div class="detail-meta-list">
                        <div class="detail-meta-item">
                            <i class="fas fa-map-marker-alt" style="color:#ef4444;"></i>
                            <span><?= sanitize($institution['city']) ?>, <?= sanitize($institution['state']) ?></span>
                        </div>
                        <?php if (!empty($institution['established_year'])): ?>
                            <div class="detail-meta-item">
                                <i class="fas fa-history" style="color:#38bdf8;"></i>
                                <span>Established <?= (int)$institution['established_year'] ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="detail-meta-item">
                            <i class="fas fa-users" style="color:#10b981;"></i>
                            <span><?= number_format($institution['student_count']) ?>+ Students Enrolled</span>
                        </div>
                        <div class="detail-meta-item">
                            <i class="fas fa-star" style="color:#f59e0b;"></i>
                            <span><?= number_format($institution['rating'], 1) ?> / 5.0 (<?= (int)$institution['reviews_count'] ?> reviews)</span>
                        </div>
                    </div>
                </div>

                <div style="display:flex; flex-direction:column; gap:10px;">
                    <button type="button" class="btn btn-primary" data-open-inquiry data-institution-id="<?= $institution['id'] ?>" data-institution-name="<?= sanitize($institution['name']) ?>">
                        <i class="fas fa-paper-plane"></i> Apply for Admission
                    </button>
                    <button type="button" class="btn btn-secondary bookmark-btn-text" 
                            data-bookmark-id="<?= $institution['id'] ?>" 
                            data-bookmark-type="institution" 
                            data-bookmark-name="<?= sanitize($institution['name']) ?>">
                        <i class="far fa-bookmark"></i> Save to Bookmarks
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Sections -->
    <div class="container section">
        <div style="display:grid; grid-template-columns: 2.2fr 1fr; gap:40px;">
            <!-- Left Column: Details & Programs -->
            <div>
                <!-- About Overview -->
                <div style="background:#fff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:32px; margin-bottom:36px; box-shadow:var(--shadow-sm);">
                    <h2 style="font-size:1.5rem; font-weight:800; margin-bottom:16px; color:#0f172a;">About Campus &amp; Overview</h2>
                    <p style="font-size:1.02rem; color:#334155; line-height:1.8; margin-bottom:20px;">
                        <?= nl2br(sanitize($institution['description'])) ?>
                    </p>

                    <?php if (!empty($facilitiesList)): ?>
                        <h3 style="font-size:1.2rem; font-weight:700; margin:28px 0 16px 0;">Campus Facilities &amp; Amenities</h3>
                        <div class="facilities-list">
                            <?php foreach ($facilitiesList as $facility): ?>
                                <div class="facility-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span><?= sanitize($facility) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Academic Programs Offered -->
                <div style="background:#fff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:32px; margin-bottom:36px; box-shadow:var(--shadow-sm);">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
                        <h2 style="font-size:1.5rem; font-weight:800; color:#0f172a;">Programs &amp; Degrees (<?= count($courses) ?>)</h2>
                        <span class="badge badge-info">2026-2027 Admissions Open</span>
                    </div>

                    <?php if (!empty($courses)): ?>
                        <div style="display:flex; flex-direction:column; gap:20px;">
                            <?php foreach ($courses as $c): ?>
                                <div style="border:1px solid var(--border-color); border-radius:var(--radius-md); padding:24px; transition:var(--transition); background:#fafafa;">
                                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                                        <div>
                                            <span class="badge badge-blue"><?= sanitize($c['degree_level']) ?></span>
                                            <h3 style="font-size:1.25rem; font-weight:700; margin-top:6px; color:#0f172a;">
                                                <a href="course-detail.php?id=<?= $c['id'] ?>"><?= sanitize($c['name']) ?></a>
                                            </h3>
                                        </div>
                                        <div style="text-align:right;">
                                            <div style="font-size:1.2rem; font-weight:800; color:var(--primary);"><?= formatCurrency($c['tuition_fee']) ?></div>
                                            <div style="font-size:0.8rem; color:#64748b;">Annual Tuition</div>
                                        </div>
                                    </div>

                                    <p style="font-size:0.92rem; color:#475569; margin-bottom:16px; line-height:1.5;">
                                        <?= sanitize(mb_substr($c['syllabus_summary'], 0, 150)) ?>...
                                    </p>

                                    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; padding-top:14px; border-top:1px solid #e2e8f0;">
                                        <div style="display:flex; gap:16px; font-size:0.88rem; color:#475569;">
                                            <span><i class="far fa-clock"></i> <?= sanitize($c['duration']) ?></span>
                                            <span><i class="fas fa-chair"></i> <?= (int)$c['seats'] ?> Seats</span>
                                            <span><i class="fas fa-briefcase"></i> <?= sanitize($c['avg_package']) ?></span>
                                        </div>

                                        <div style="display:flex; gap:10px;">
                                            <a href="course-detail.php?id=<?= $c['id'] ?>" class="btn btn-secondary btn-sm">Course Details</a>
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    data-open-inquiry 
                                                    data-institution-id="<?= $institution['id'] ?>" 
                                                    data-course-id="<?= $c['id'] ?>"
                                                    data-institution-name="<?= sanitize($institution['name']) ?>"
                                                    data-course-name="<?= sanitize($c['name']) ?>">
                                                Inquire
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="color:var(--text-secondary);">No individual degree syllabi currently listed for this campus.</p>
                    <?php endif; ?>
                </div>

                <!-- Campus Reviews & Ratings -->
                <div style="background:#fff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:32px; box-shadow:var(--shadow-sm);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                        <h2 style="font-size:1.5rem; font-weight:800; color:#0f172a;">Student Reviews (<?= count($reviews) ?>)</h2>
                        <a href="#writeReviewSection" class="btn btn-outline btn-sm"><i class="fas fa-pen"></i> Write a Review</a>
                    </div>

                    <?php if (!empty($reviews)): ?>
                        <div style="display:flex; flex-direction:column; gap:20px; margin-bottom:40px;">
                            <?php foreach ($reviews as $rev): ?>
                                <div style="border-bottom:1px solid #e2e8f0; padding-bottom:20px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <div class="author-avatar" style="width:36px; height:36px; font-size:0.9rem;">
                                                <?= strtoupper(substr($rev['student_name'], 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div style="font-weight:700; color:#0f172a; font-size:0.92rem;"><?= sanitize($rev['student_name']) ?></div>
                                                <div style="font-size:0.78rem; color:#64748b;"><?= sanitize($rev['course_name']) ?> • <?= sanitize($rev['batch_year']) ?></div>
                                            </div>
                                        </div>
                                        <?= renderRatingStars($rev['rating']) ?>
                                    </div>
                                    <h4 style="font-size:1rem; font-weight:700; margin-bottom:6px; color:#1e293b;">"<?= sanitize($rev['review_title']) ?>"</h4>
                                    <p style="font-size:0.92rem; color:#475569; line-height:1.6;"><?= sanitize($rev['review_content']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Write a review form -->
                    <div id="writeReviewSection" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:var(--radius-md); padding:24px;">
                        <h3 style="font-size:1.2rem; font-weight:700; margin-bottom:16px;">Leave a Verified Review</h3>
                        <form method="POST" action="institution-detail.php?id=<?= $institution['id'] ?>">
                            <input type="hidden" name="action" value="submit_review">
                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label">Your Full Name *</label>
                                    <input type="text" name="student_name" class="form-control" required placeholder="e.g. Ananya Patel">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Course / Program Name</label>
                                    <input type="text" name="course_name" class="form-control" placeholder="e.g. B.Tech Computer Science">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label">Overall Rating (1 to 5 Stars)</label>
                                    <select name="rating" class="form-control">
                                        <option value="5">★★★★★ (5 Stars - Exceptional)</option>
                                        <option value="4">★★★★☆ (4 Stars - Good Experience)</option>
                                        <option value="3">★★★☆☆ (3 Stars - Average)</option>
                                        <option value="2">★★☆☆☆ (2 Stars - Needs Improvement)</option>
                                        <option value="1">★☆☆☆☆ (1 Star - Poor)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Batch / Passing Year</label>
                                    <input type="text" name="batch_year" class="form-control" placeholder="e.g. Class of 2025">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Review Headline *</label>
                                <input type="text" name="review_title" class="form-control" required placeholder="Summarize your experience (e.g. Great faculty &amp; active placement cell)">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Review Description *</label>
                                <textarea name="review_content" class="form-control" required placeholder="Describe campus culture, infrastructure, academics, and practical opportunities..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Post Campus Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Campus Contact & Inquiry Card -->
            <div>
                <div style="background:#fff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:28px; box-shadow:var(--shadow-md); position:sticky; top:100px;">
                    <h3 style="font-size:1.25rem; font-weight:800; margin-bottom:20px; color:#0f172a;">Direct Campus Admissions</h3>

                    <div style="margin-bottom:20px; font-size:0.92rem; color:#475569; display:flex; flex-direction:column; gap:12px;">
                        <div>
                            <strong style="display:block; color:#0f172a; margin-bottom:2px;"><i class="fas fa-map-marker-alt" style="color:#ef4444; width:20px;"></i> Campus Location:</strong>
                            <span style="font-size:0.88rem; line-height:1.4; display:block; padding-left:24px;"><?= sanitize($institution['address']) ?></span>
                        </div>

                        <?php if (!empty($institution['phone'])): ?>
                            <div>
                                <strong style="display:block; color:#0f172a; margin-bottom:2px;"><i class="fas fa-phone-alt" style="color:#10b981; width:20px;"></i> Admission Helpline:</strong>
                                <a href="tel:<?= sanitize($institution['phone']) ?>" style="padding-left:24px; color:var(--primary); font-weight:600;"><?= sanitize($institution['phone']) ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($institution['email'])): ?>
                            <div>
                                <strong style="display:block; color:#0f172a; margin-bottom:2px;"><i class="fas fa-envelope" style="color:#38bdf8; width:20px;"></i> Official Email:</strong>
                                <a href="mailto:<?= sanitize($institution['email']) ?>" style="padding-left:24px; color:var(--primary);"><?= sanitize($institution['email']) ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($institution['website'])): ?>
                            <div>
                                <strong style="display:block; color:#0f172a; margin-bottom:2px;"><i class="fas fa-globe" style="color:#8b5cf6; width:20px;"></i> Website:</strong>
                                <a href="<?= sanitize($institution['website']) ?>" target="_blank" rel="noopener noreferrer" style="padding-left:24px; color:var(--primary); display:inline-flex; align-items:center; gap:4px;">
                                    <?= sanitize($institution['website']) ?> <i class="fas fa-external-link-alt" style="font-size:0.75rem;"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <hr style="border:none; border-top:1px solid #e2e8f0; margin:20px 0;">

                    <h4 style="font-size:1rem; font-weight:700; margin-bottom:12px; color:#0f172a;">Request Official Brochure</h4>
                    <p style="font-size:0.86rem; color:#64748b; margin-bottom:16px;">Submit an inquiry to receive the current academic prospectus and scholarship guidelines.</p>

                    <button type="button" class="btn btn-primary" style="width:100%;" 
                            data-open-inquiry 
                            data-institution-id="<?= $institution['id'] ?>" 
                            data-institution-name="<?= sanitize($institution['name']) ?>">
                        <i class="fas fa-envelope-open-text"></i> Request Free Counseling
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
