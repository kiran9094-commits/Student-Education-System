<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/database/Database.php';
$db = Database::getInstance();

$pageTitle = "Contact Us - Student Education System | Helpdesk";
$metaDescription = "Get in touch with the Gujarat Student Education System helpline. Ask questions regarding admissions, schools, colleges, and courses.";
$activePage = 'contact';

$submittedSuccess = false;
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($mobile) || empty($subject) || empty($message)) {
        $errorMessage = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Please provide a valid email address.";
    } else {
        try {
            $db->query(
                "INSERT INTO contacts (name, email, mobile, subject, message, created_at) VALUES (?, ?, ?, ?, ?, datetime('now'))",
                [$name, $email, $mobile, $subject, $message]
            );
            $submittedSuccess = true;
            setFlash('success', 'Your message has been submitted successfully.');
        } catch (Exception $e) {
            $errorMessage = "Could not submit your message. Please try again.";
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<main class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size:0.85rem; color:#64748b; margin-bottom:20px;">
            <a href="index.php" style="color:#2563eb; text-decoration:none;"><i class="fas fa-home"></i> Home</a> &rsaquo;
            <span style="color:#0f172a; font-weight:600;">Contact Us</span>
        </div>

        <!-- Page Header -->
        <div style="margin-bottom: 32px; text-align:center; max-width:680px; margin-left:auto; margin-right:auto;">
            <span class="section-tag"><i class="fas fa-headset"></i> Student Support &amp; Admission Helpline</span>
            <h1 class="section-title" style="margin-bottom:8px;">Contact Student Education System</h1>
            <p class="section-subtitle">
                Have questions about school admissions, college cutoffs, or course eligibility in Gujarat? Reach out to us directly.
            </p>
        </div>

        <div style="display:grid; grid-template-columns: 1.5fr 1fr; gap:36px; align-items:start;">
            
            <!-- Left: Contact Form -->
            <div>
                <!-- Success Banner -->
                <?php if ($submittedSuccess): ?>
                    <div style="background:#f0fdf4; border:2px solid #86efac; border-radius:var(--radius-lg); padding:24px; text-align:center; margin-bottom:28px;">
                        <i class="fas fa-check-circle" style="font-size:2.5rem; color:#16a34a; margin-bottom:12px; display:block;"></i>
                        <h3 style="color:#15803d; font-size:1.4rem; font-weight:800; margin-bottom:6px;">
                            Your message has been submitted successfully.
                        </h3>
                        <p style="color:#166534; font-size:0.95rem; margin:0;">
                            Our team will review your inquiry and get back to you shortly.
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Error Banner -->
                <?php if (!empty($errorMessage)): ?>
                    <div style="background:#fef2f2; border:1px solid #fca5a5; border-radius:var(--radius-md); padding:16px; margin-bottom:24px; color:#b91c1c; font-weight:600;">
                        <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i> <?= sanitize($errorMessage) ?>
                    </div>
                <?php endif; ?>

                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:36px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
                    <h2 style="font-size:1.25rem; font-weight:700; color:#0f172a; margin-bottom:20px; border-bottom:1px solid #f1f5f9; padding-bottom:12px;">
                        <i class="fas fa-envelope-open-text" style="color:#2563eb; margin-right:8px;"></i> Send Us a Message
                    </h2>

                    <form method="POST" action="contact.php">
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:18px; margin-bottom:18px;">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="form-label" style="font-weight:700; color:#1e293b; margin-bottom:6px; display:block;">
                                    Full Name *
                                </label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your name" required value="<?= isset($_POST['name']) ? sanitize($_POST['name']) : '' ?>">
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="form-label" style="font-weight:700; color:#1e293b; margin-bottom:6px; display:block;">
                                    Email Address *
                                </label>
                                <input type="email" name="email" class="form-control" placeholder="name@example.com" required value="<?= isset($_POST['email']) ? sanitize($_POST['email']) : '' ?>">
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:18px; margin-bottom:18px;">
                            <!-- Mobile -->
                            <div class="form-group">
                                <label class="form-label" style="font-weight:700; color:#1e293b; margin-bottom:6px; display:block;">
                                    Mobile Number *
                                </label>
                                <input type="tel" name="mobile" class="form-control" placeholder="7046483464" required value="<?= isset($_POST['mobile']) ? sanitize($_POST['mobile']) : '' ?>">
                            </div>

                            <!-- Subject -->
                            <div class="form-group">
                                <label class="form-label" style="font-weight:700; color:#1e293b; margin-bottom:6px; display:block;">
                                    Subject *
                                </label>
                                <input type="text" name="subject" class="form-control" placeholder="e.g. Admission in BDS / Banaskantha School query" required value="<?= isset($_POST['subject']) ? sanitize($_POST['subject']) : '' ?>">
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="form-group" style="margin-bottom:24px;">
                            <label class="form-label" style="font-weight:700; color:#1e293b; margin-bottom:6px; display:block;">
                                Message *
                            </label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Write your educational query, course requirements, or questions here..." required><?= isset($_POST['message']) ? sanitize($_POST['message']) : '' ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%; padding:14px; font-size:1.05rem;">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Contact Information & Helpdesk Details -->
            <div>
                <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:30px; box-shadow:0 1px 3px rgba(0,0,0,0.05); margin-bottom:24px;">
                    <h3 style="font-size:1.15rem; font-weight:700; color:#0f172a; margin-bottom:18px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
                        <i class="fas fa-address-book" style="color:#2563eb; margin-right:8px;"></i> Project Helpdesk
                    </h3>

                    <div style="display:flex; flex-direction:column; gap:20px;">
                        <div style="display:flex; align-items:flex-start; gap:14px;">
                            <div style="width:40px; height:40px; border-radius:10px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <span style="font-size:0.8rem; color:#64748b; display:block;">Project Developer</span>
                                <strong style="color:#0f172a; font-size:0.95rem;">Kiran Chaudhary</strong>
                            </div>
                        </div>

                        <div style="display:flex; align-items:flex-start; gap:14px;">
                            <div style="width:40px; height:40px; border-radius:10px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <span style="font-size:0.8rem; color:#64748b; display:block;">Phone / Helpline</span>
                                <strong style="color:#0f172a; font-size:0.95rem;">+91 70464 83464</strong>
                            </div>
                        </div>

                        <div style="display:flex; align-items:flex-start; gap:14px;">
                            <div style="width:40px; height:40px; border-radius:10px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <span style="font-size:0.8rem; color:#64748b; display:block;">Official Email</span>
                                <strong style="color:#0f172a; font-size:0.95rem;">admissions@studenteducationsystem.edu</strong>
                            </div>
                        </div>

                        <div style="display:flex; align-items:flex-start; gap:14px;">
                            <div style="width:40px; height:40px; border-radius:10px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <span style="font-size:0.8rem; color:#64748b; display:block;">Region</span>
                                <strong style="color:#0f172a; font-size:0.95rem;">Gujarat, India</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Help Box -->
                <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:var(--radius-lg); padding:24px;">
                    <h4 style="font-size:1rem; font-weight:700; color:#1e40af; margin-bottom:10px;">
                        <i class="fas fa-info-circle"></i> Looking for Instant Information?
                    </h4>
                    <p style="font-size:0.88rem; color:#1e3a8a; line-height:1.6; margin-bottom:14px;">
                        You can immediately browse and filter all 330 schools, 117+ colleges, and 29 courses directly on our portal without any waiting!
                    </p>
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <a href="schools.php" class="btn btn-outline btn-sm" style="background:#ffffff; text-align:center;">
                            Browse Gujarat Schools &rarr;
                        </a>
                        <a href="colleges.php" class="btn btn-outline btn-sm" style="background:#ffffff; text-align:center;">
                            Browse Gujarat Colleges &rarr;
                        </a>
                        <a href="courses.php" class="btn btn-outline btn-sm" style="background:#ffffff; text-align:center;">
                            Explore Degree Courses &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
