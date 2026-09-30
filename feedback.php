<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/database/Database.php';
$db = Database::getInstance();

$pageTitle = "Student & Parent Feedback - " . APP_NAME;
$metaDescription = "Share your feedback and thoughts to help improve the Gujarat Student Education System portal.";
$activePage = 'feedback';

$submittedSuccess = false;
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rating = (int)($_POST['rating'] ?? 5);
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $errorMessage = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Please enter a valid email address.";
    } else {
        if ($rating < 1) $rating = 1;
        if ($rating > 5) $rating = 5;

        try {
            $db->query(
                "INSERT INTO feedback (name, email, rating, message, created_at) VALUES (?, ?, ?, ?, datetime('now'))",
                [$name, $email, $rating, $message]
            );
            $submittedSuccess = true;
            setFlash('success', 'Thank you for your valuable feedback!');
        } catch (Exception $e) {
            $errorMessage = "Could not save your feedback. Please try again.";
        }
    }
}

// Fetch recent feedbacks from database
$feedbacks = $db->fetchAll("SELECT * FROM feedback ORDER BY id DESC LIMIT 8");

require_once __DIR__ . '/includes/header.php';
?>

<main class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size:0.85rem; color:#64748b; margin-bottom:20px;">
            <a href="index.php" style="color:#2563eb; text-decoration:none;"><i class="fas fa-home"></i> Home</a> &rsaquo;
            <span style="color:#0f172a; font-weight:600;">Feedback</span>
        </div>

        <!-- Page Header -->
        <div style="margin-bottom: 32px; text-align:center; max-width:680px; margin-left:auto; margin-right:auto;">
            <span class="section-tag"><i class="fas fa-comment-dots"></i> Student Voice</span>
            <h1 class="section-title" style="margin-bottom:8px;">Share Your Valuable Feedback</h1>
            <p class="section-subtitle">
                Help us enhance the Gujarat Student Education System by sharing your experience, suggestions, or reviews.
            </p>
        </div>

        <div style="max-width:800px; margin:0 auto 50px;">
            <!-- Success Notification -->
            <?php if ($submittedSuccess): ?>
                <div style="background:#f0fdf4; border:2px solid #86efac; border-radius:var(--radius-lg); padding:24px; text-align:center; margin-bottom:28px;">
                    <i class="fas fa-check-circle" style="font-size:2.5rem; color:#16a34a; margin-bottom:12px; display:block;"></i>
                    <h3 style="color:#15803d; font-size:1.4rem; font-weight:800; margin-bottom:6px;">
                        Thank you for your valuable feedback!
                    </h3>
                    <p style="color:#166534; font-size:0.95rem; margin:0;">
                        Your opinion helps us make this educational portal more helpful and accurate for Gujarat students.
                    </p>
                </div>
            <?php endif; ?>

            <!-- Error Notification -->
            <?php if (!empty($errorMessage)): ?>
                <div style="background:#fef2f2; border:1px solid #fca5a5; border-radius:var(--radius-md); padding:16px; margin-bottom:24px; color:#b91c1c; font-weight:600;">
                    <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i> <?= sanitize($errorMessage) ?>
                </div>
            <?php endif; ?>

            <!-- Feedback Form Card -->
            <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:36px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
                <form method="POST" action="feedback.php">
                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap:20px; margin-bottom:20px;">
                        <!-- Name -->
                        <div class="form-group">
                            <label class="form-label" style="font-weight:700; color:#1e293b; margin-bottom:6px; display:block;">
                                Your Name *
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your full name" required value="<?= isset($_POST['name']) ? sanitize($_POST['name']) : '' ?>">
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label" style="font-weight:700; color:#1e293b; margin-bottom:6px; display:block;">
                                Email Address *
                            </label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com" required value="<?= isset($_POST['email']) ? sanitize($_POST['email']) : '' ?>">
                        </div>
                    </div>

                    <!-- Rating ⭐ 1 - 5 -->
                    <div class="form-group" style="margin-bottom:24px;">
                        <label class="form-label" style="font-weight:700; color:#1e293b; margin-bottom:10px; display:block;">
                            Your Rating *
                        </label>
                        <div style="display:flex; gap:16px; flex-wrap:wrap;">
                            <?php for ($star = 5; $star >= 1; $star--): ?>
                                <label style="display:flex; align-items:center; gap:8px; cursor:pointer; background:#f8fafc; border:1px solid #cbd5e1; padding:10px 16px; border-radius:8px;">
                                    <input type="radio" name="rating" value="<?= $star ?>" <?= ($star === 5) ? 'checked' : '' ?>>
                                    <span style="font-weight:700; color:#0f172a;">
                                        ⭐ <?= $star ?> <?= ($star === 5) ? '(Excellent)' : (($star === 1) ? '(Poor)' : '') ?>
                                    </span>
                                </label>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <!-- Feedback Message -->
                    <div class="form-group" style="margin-bottom:24px;">
                        <label class="form-label" style="font-weight:700; color:#1e293b; margin-bottom:6px; display:block;">
                            Feedback Message *
                        </label>
                        <textarea name="message" class="form-control" rows="5" placeholder="Share your experience, suggest a missing school or college, or suggest new features..." required><?= isset($_POST['message']) ? sanitize($_POST['message']) : '' ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%; padding:14px; font-size:1.05rem;">
                        <i class="fas fa-paper-plane"></i> Submit Feedback
                    </button>
                </form>
            </div>
        </div>

        <!-- Recent Feedbacks from Students -->
        <?php if (!empty($feedbacks)): ?>
        <div style="max-width:960px; margin:0 auto;">
            <h3 style="font-size:1.3rem; font-weight:700; color:#0f172a; margin-bottom:20px; text-align:center;">
                <i class="fas fa-comments" style="color:#2563eb; margin-right:6px;"></i> Recent Student &amp; Community Feedback
            </h3>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:20px;">
                <?php foreach ($feedbacks as $fb): ?>
                    <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-md); padding:20px; box-shadow:0 1px 3px rgba(0,0,0,0.05); display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                <strong style="color:#0f172a; font-size:0.95rem;"><?= sanitize($fb['name']) ?></strong>
                                <span style="color:#f59e0b; font-size:0.85rem;">
                                    <?php for ($i = 0; $i < (int)$fb['rating']; $i++): ?>⭐<?php endfor; ?>
                                </span>
                            </div>
                            <p style="color:#475569; font-size:0.88rem; line-height:1.6; margin:0;">
                                "<?= sanitize($fb['message']) ?>"
                            </p>
                        </div>
                        <div style="margin-top:12px; font-size:0.75rem; color:#94a3b8; text-align:right;">
                            <?= date('M d, Y', strtotime($fb['created_at'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
