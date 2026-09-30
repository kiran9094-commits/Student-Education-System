<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/database/Database.php';
require_once __DIR__ . '/includes/functions.php';

$db = Database::getInstance();

$preInstId = (int)($_GET['institution_id'] ?? 0);
$preCourseId = (int)($_GET['course_id'] ?? 0);

// Fetch all institutions for dropdown
$institutions = $db->fetchAll("SELECT id, name, city FROM institutions ORDER BY name ASC");

// Handle POST submission if submitted directly without AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentName = trim($_POST['student_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $qualification = trim($_POST['qualification'] ?? '');
    $institutionId = !empty($_POST['institution_id']) ? (int)$_POST['institution_id'] : null;
    $courseId = !empty($_POST['course_id']) ? (int)$_POST['course_id'] : null;
    $message = trim($_POST['message'] ?? '');

    if (!empty($studentName) && !empty($email) && !empty($phone)) {
        $db->query("
            INSERT INTO inquiries (student_name, email, phone, city, qualification, institution_id, course_id, message, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')
        ", [$studentName, $email, $phone, $city, $qualification, $institutionId, $courseId, $message]);

        setFlash('success', 'Your admission guidance request has been registered! An academic counselor will contact you within 24 hours.');
        header("Location: inquiry.php");
        exit;
    } else {
        setFlash('error', 'Please fill in all mandatory fields (Name, Email, and Phone).');
    }
}

$pageTitle = "Student Admission Counseling & Guidance - " . APP_NAME;
$metaDescription = "Book a free one-on-one educational counseling consultation with certified academic advisors for college admissions.";
$activePage = 'inquiry';

require_once __DIR__ . '/includes/header.php';
?>

<main class="section">
    <div class="container">
        <div style="display:grid; grid-template-columns: 1.2fr 0.8fr; gap:48px; align-items:flex-start;">
            <!-- Left Column: Form -->
            <div style="background:#fff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:36px; box-shadow:var(--shadow-md);">
                <span class="section-tag"><i class="fas fa-headset"></i> Academic Guidance</span>
                <h1 style="font-size:2rem; font-weight:800; color:#0f172a; margin:10px 0 12px 0;">Student Admission Consultation</h1>
                <p style="font-size:0.98rem; color:#475569; margin-bottom:28px;">
                    Fill out the form below to receive personalized guidance on cutoffs, scholarship opportunities, hostel availability, and direct admission application support.
                </p>

                <form method="POST" action="inquiry.php">
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="student_name" class="form-control" required placeholder="KIRAN CHAUDHARY" value="KIRAN CHAUDHARY">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Phone / WhatsApp *</label>
                            <input type="tel" name="phone" class="form-control" required placeholder="7046483464" value="7046483464">
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control" required placeholder="kiranchaudhary@gmail.com" value="kiranchaudhary@gmail.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Your Current City / State</label>
                            <input type="text" name="city" class="form-control" placeholder="e.g. Ahmedabad, Gujarat" value="Ahmedabad, Gujarat">
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Preferred School / College</label>
                            <select name="institution_id" id="inquiryInstSelect" class="form-control">
                                <option value="">Select an institution (Optional)</option>
                                <?php foreach ($institutions as $inst): ?>
                                    <option value="<?= $inst['id'] ?>" <?= ($preInstId === (int)$inst['id']) ? 'selected' : '' ?>>
                                        <?= sanitize($inst['name']) ?> (<?= sanitize($inst['city']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Current Academic Qualification</label>
                            <input type="text" name="qualification" class="form-control" placeholder="e.g. 12th Standard / B.Sc / Diploma">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Specific Query or Target Degree</label>
                        <textarea name="message" class="form-control" placeholder="Tell us which degree or course you are interested in, your scores/ranks, budget preference, or any questions for the admission panel..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                        <i class="fas fa-paper-plane"></i> Book Free Consultation Call
                    </button>
                </form>
            </div>

            <!-- Right Column: Counseling Features & FAQ -->
            <div>
                <div style="background:#f1f5f9; border-radius:var(--radius-lg); padding:32px; margin-bottom:30px;">
                    <h3 style="font-size:1.3rem; font-weight:800; color:#0f172a; margin-bottom:16px;">Why Use Our Education Counseling?</h3>
                    
                    <div style="display:flex; flex-direction:column; gap:18px;">
                        <div style="display:flex; gap:14px;">
                            <div style="width:38px; height:38px; border-radius:50%; background:#e0e7ff; color:var(--primary); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h4 style="font-size:1rem; font-weight:700; color:#0f172a;">100% Free &amp; Unbiased</h4>
                                <p style="font-size:0.88rem; color:#475569;">No hidden charges. We evaluate campuses purely on academic standards, faculty credentials, and verified placements.</p>
                            </div>
                        </div>

                        <div style="display:flex; gap:14px;">
                            <div style="width:38px; height:38px; border-radius:50%; background:#d1fae5; color:var(--success); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h4 style="font-size:1rem; font-weight:700; color:#0f172a;">Accreditation Verification</h4>
                                <p style="font-size:0.88rem; color:#475569;">Ensure your degrees are valid for civil service examinations, abroad studies, and corporate eligibility.</p>
                            </div>
                        </div>

                        <div style="display:flex; gap:14px;">
                            <div style="width:38px; height:38px; border-radius:50%; background:#fef3c7; color:var(--warning); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <div>
                                <h4 style="font-size:1rem; font-weight:700; color:#0f172a;">Scholarship Assistance</h4>
                                <p style="font-size:0.88rem; color:#475569;">Guidance on merit scholarships, sports quotas, and state financial aid schemes.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ accordion -->
                <div style="background:#fff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:28px;">
                    <h3 style="font-size:1.2rem; font-weight:800; color:#0f172a; margin-bottom:16px;">Frequently Asked Questions</h3>
                    <div style="display:flex; flex-direction:column; gap:16px; font-size:0.92rem;">
                        <div>
                            <strong style="color:#0f172a; display:block; margin-bottom:4px;">How quickly will a counselor contact me?</strong>
                            <span style="color:#64748b;">Our student advisor team typically replies within 2 to 4 business hours via phone or WhatsApp.</span>
                        </div>
                        <div>
                            <strong style="color:#0f172a; display:block; margin-bottom:4px;">Can you assist with hostel and mess queries?</strong>
                            <span style="color:#64748b;">Yes! We provide complete hostel facility breakdowns, fee structures, and campus safety reviews.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
