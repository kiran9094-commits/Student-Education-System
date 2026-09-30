<?php
require_once __DIR__ . '/config/constants.php';
$pageTitle = "About Us - Student Education System | Developed by Kiran Chaudhary";
$metaDescription = "Learn about Student Education System, a Gujarat-focused educational portal helping students discover schools, colleges, and courses across all 33 districts.";
$activePage = 'about';

require_once __DIR__ . '/includes/header.php';

// Quick stats
$totalSchools = $db->fetch("SELECT COUNT(*) as c FROM schools")['c'] ?? 330;
$totalColleges = $db->fetch("SELECT COUNT(*) as c FROM colleges")['c'] ?? 117;
$totalCourses = $db->fetch("SELECT COUNT(*) as c FROM courses_catalog")['c'] ?? 29;
$totalDistricts = 33;
?>

<main class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="font-size:0.85rem; color:#64748b; margin-bottom:20px;">
            <a href="index.php" style="color:#2563eb; text-decoration:none;"><i class="fas fa-home"></i> Home</a> &rsaquo;
            <span style="color:#0f172a; font-weight:600;">About Us</span>
        </div>

        <!-- Hero Section -->
        <div style="background:linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border-radius:var(--radius-lg); padding:48px 36px; color:#ffffff; margin-bottom:40px; box-shadow:0 10px 25px -5px rgba(37, 99, 235, 0.25);">
            <div style="max-width:820px;">
                <span class="badge" style="background:rgba(255,255,255,0.2); color:#ffffff; margin-bottom:14px; padding:6px 14px; font-weight:700;">
                    📘 Gujarat Educational Information Portal
                </span>
                <h1 style="font-size:2.4rem; font-weight:800; line-height:1.2; margin-bottom:14px;">
                    About Student Education System
                </h1>
                <p style="font-size:1.1rem; line-height:1.7; color:#e0e7ff; margin-bottom:0;">
                    A comprehensive, Gujarat-focused educational platform built to guide students, parents, and educators with authentic information on schools across all 33 districts, top colleges across major cities, and comprehensive course career paths.
                </p>
            </div>
        </div>

        <!-- Numbers Counter Bar -->
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:40px;">
            <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-md); padding:24px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="font-size:2.2rem; font-weight:800; color:#2563eb; margin-bottom:4px;"><?= $totalDistricts ?></div>
                <div style="font-size:0.9rem; font-weight:600; color:#475569;">Gujarat Districts Covered</div>
            </div>
            <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-md); padding:24px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="font-size:2.2rem; font-weight:800; color:#10b981; margin-bottom:4px;"><?= $totalSchools ?>+</div>
                <div style="font-size:0.9rem; font-weight:600; color:#475569;">Verified Schools Directory</div>
            </div>
            <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-md); padding:24px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="font-size:2.2rem; font-weight:800; color:#f59e0b; margin-bottom:4px;"><?= $totalColleges ?>+</div>
                <div style="font-size:0.9rem; font-weight:600; color:#475569;">Premier Colleges &amp; Universities</div>
            </div>
            <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-md); padding:24px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="font-size:2.2rem; font-weight:800; color:#6366f1; margin-bottom:4px;"><?= $totalCourses ?></div>
                <div style="font-size:0.9rem; font-weight:600; color:#475569;">Detailed Academic Programs</div>
            </div>
        </div>

        <!-- Section 1: What is Student Education System? & Why it was created -->
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:28px; margin-bottom:40px;">
            <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:32px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="width:48px; height:48px; border-radius:12px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-size:1.4rem; margin-bottom:18px;">
                    <i class="fas fa-question"></i>
                </div>
                <h2 style="font-size:1.35rem; font-weight:700; color:#0f172a; margin-bottom:12px;">What is Student Education System?</h2>
                <p style="color:#475569; font-size:0.95rem; line-height:1.7;">
                    <strong>Student Education System</strong> is an open educational directory created specifically for Gujarat students. It bridges the information gap between students and authentic academic institutions by organizing schools, colleges, courses, admission processes, and career pathways into an intuitive, accessible portal.
                </p>
            </div>

            <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:32px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="width:48px; height:48px; border-radius:12px; background:#f0fdf4; color:#10b981; display:flex; align-items:center; justify-content:center; font-size:1.4rem; margin-bottom:18px;">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h2 style="font-size:1.35rem; font-weight:700; color:#0f172a; margin-bottom:12px;">Why This Website Was Created?</h2>
                <p style="color:#475569; font-size:0.95rem; line-height:1.7;">
                    Students after 10th and 12th standards often face confusion regarding stream selection, entrance examinations (NEET, GUJCET, JEE, ACPC), college availability in their home district, and career opportunities. This website was created to provide reliable, organized, and transparent educational data in one unified place without any barrier.
                </p>
            </div>
        </div>

        <!-- Section 2: How Students Can Use It? -->
        <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:36px; margin-bottom:40px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
            <h2 style="font-size:1.4rem; font-weight:700; color:#0f172a; margin-bottom:24px; text-align:center;">
                <i class="fas fa-compass" style="color:#2563eb; margin-right:8px;"></i> How Students Can Use This Website
            </h2>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap:24px;">
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:22px;">
                    <div style="font-size:1.6rem; font-weight:800; color:#2563eb; margin-bottom:8px;">01</div>
                    <h3 style="font-size:1.05rem; font-weight:700; color:#0f172a; margin-bottom:6px;">Explore Courses</h3>
                    <p style="color:#64748b; font-size:0.88rem; line-height:1.6; margin:0;">
                        Browse Science/Medical (MBBS, BDS, BAMS), Engineering, IT (BCA/MCA), Management, and Arts to review durations, eligibility, and career prospects.
                    </p>
                </div>

                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:22px;">
                    <div style="font-size:1.6rem; font-weight:800; color:#10b981; margin-bottom:8px;">02</div>
                    <h3 style="font-size:1.05rem; font-weight:700; color:#0f172a; margin-bottom:6px;">Find Gujarat Schools</h3>
                    <p style="color:#64748b; font-size:0.88rem; line-height:1.6; margin:0;">
                        Filter schools across all 33 Gujarat districts and explore Banaskantha’s 13 talukas with Government vs Private classification.
                    </p>
                </div>

                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:22px;">
                    <div style="font-size:1.6rem; font-weight:800; color:#f59e0b; margin-bottom:8px;">03</div>
                    <h3 style="font-size:1.05rem; font-weight:700; color:#0f172a; margin-bottom:6px;">Discover Colleges</h3>
                    <p style="color:#64748b; font-size:0.88rem; line-height:1.6; margin:0;">
                        Locate colleges in Ahmedabad, Gandhinagar, Surat, Vadodara, Rajkot, Kadi, Mehsana, and beyond, with course offerings and websites.
                    </p>
                </div>

                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:22px;">
                    <div style="font-size:1.6rem; font-weight:800; color:#8b5cf6; margin-bottom:8px;">04</div>
                    <h3 style="font-size:1.05rem; font-weight:700; color:#0f172a; margin-bottom:6px;">Connect &amp; Share Feedback</h3>
                    <p style="color:#64748b; font-size:0.88rem; line-height:1.6; margin:0;">
                        Submit admission queries directly to the student desk or provide feedback to enhance the portal’s educational directory.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 3: Features & Benefits -->
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:28px; margin-bottom:40px;">
            <!-- Features -->
            <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:32px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <h3 style="font-size:1.25rem; font-weight:700; color:#0f172a; margin-bottom:18px; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-star" style="color:#f59e0b;"></i> Key Features
                </h3>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:12px; font-size:0.92rem; color:#475569;">
                    <li style="display:flex; align-items:flex-start; gap:10px;">
                        <i class="fas fa-check-circle" style="color:#10b981; margin-top:3px;"></i>
                        <span><strong>33 Gujarat Districts:</strong> 10 verified schools in every single district of Gujarat.</span>
                    </li>
                    <li style="display:flex; align-items:flex-start; gap:10px;">
                        <i class="fas fa-check-circle" style="color:#10b981; margin-top:3px;"></i>
                        <span><strong>Banaskantha Talukas:</strong> Detailed filtering across Palanpur, Deesa, Dhanera, Tharad, etc.</span>
                    </li>
                    <li style="display:flex; align-items:flex-start; gap:10px;">
                        <i class="fas fa-check-circle" style="color:#10b981; margin-top:3px;"></i>
                        <span><strong>Distinct Course Datasets:</strong> BDS has Dental data, MBBS has Medical data, BCA has Computer data.</span>
                    </li>
                    <li style="display:flex; align-items:flex-start; gap:10px;">
                        <i class="fas fa-check-circle" style="color:#10b981; margin-top:3px;"></i>
                        <span><strong>Government &amp; Private Filters:</strong> Instant classification for fee and eligibility planning.</span>
                    </li>
                    <li style="display:flex; align-items:flex-start; gap:10px;">
                        <i class="fas fa-check-circle" style="color:#10b981; margin-top:3px;"></i>
                        <span><strong>Direct Access Without Login:</strong> Open to all students with zero mandatory account creation.</span>
                    </li>
                </ul>
            </div>

            <!-- Benefits -->
            <div style="background:#ffffff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:32px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <h3 style="font-size:1.25rem; font-weight:700; color:#0f172a; margin-bottom:18px; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-award" style="color:#2563eb;"></i> Student Benefits
                </h3>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:12px; font-size:0.92rem; color:#475569;">
                    <li style="display:flex; align-items:flex-start; gap:10px;">
                        <i class="fas fa-check-double" style="color:#2563eb; margin-top:3px;"></i>
                        <span><strong>Saves Time &amp; Effort:</strong> Eliminates browsing hundreds of scattered websites.</span>
                    </li>
                    <li style="display:flex; align-items:flex-start; gap:10px;">
                        <i class="fas fa-check-double" style="color:#2563eb; margin-top:3px;"></i>
                        <span><strong>Authentic Information:</strong> Accurate admission eligibility, duration, and career paths.</span>
                    </li>
                    <li style="display:flex; align-items:flex-start; gap:10px;">
                        <i class="fas fa-check-double" style="color:#2563eb; margin-top:3px;"></i>
                        <span><strong>Local Gujarat Guidance:</strong> Focuses specifically on Gujarat education boards and councils.</span>
                    </li>
                    <li style="display:flex; align-items:flex-start; gap:10px;">
                        <i class="fas fa-check-double" style="color:#2563eb; margin-top:3px;"></i>
                        <span><strong>Completely Free:</strong> Open educational resource for students from all economic backgrounds.</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Section 4: Developer Credit Spotlight -->
        <div style="background:#ffffff; border:2px solid #bfdbfe; border-radius:var(--radius-lg); padding:36px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05); text-align:center;">
            <div style="width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg, #1d4ed8, #3b82f6); color:#ffffff; display:flex; align-items:center; justify-content:center; font-size:1.8rem; margin:0 auto 16px;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <span class="badge badge-primary" style="margin-bottom:8px; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px;">Project Creator &amp; Developer</span>
            <h2 style="font-size:1.8rem; font-weight:800; color:#0f172a; margin-bottom:8px;">Kiran Chaudhary</h2>
            <p style="color:#475569; font-size:1rem; max-width:620px; margin:0 auto 20px; line-height:1.6;">
                Developed and designed by <strong>Kiran Chaudhary</strong> as an academic BCA education web project to deliver transparent, comprehensive educational intelligence to students across Gujarat.
            </p>

            <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap; font-size:0.95rem; color:#1e293b;">
                <div><i class="fas fa-phone-alt" style="color:#2563eb; margin-right:6px;"></i> +91 70464 83464</div>
                <div><i class="fas fa-envelope" style="color:#2563eb; margin-right:6px;"></i> admissions@studenteducationsystem.edu</div>
                <div><i class="fas fa-map-marker-alt" style="color:#2563eb; margin-right:6px;"></i> Gujarat, India</div>
            </div>

            <div style="margin-top:24px;">
                <a href="contact.php" class="btn btn-primary">
                    <i class="fas fa-envelope"></i> Contact Developer
                </a>
            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
