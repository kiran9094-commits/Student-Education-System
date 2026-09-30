<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/database/Database.php';
$db = Database::getInstance();

$pageTitle = "Student Education System - Schools, Colleges, Courses & Academic Resources";
$metaDescription = "Explore accredited schools across all 33 Gujarat districts, top universities, premier degree courses, and free educational study materials with admissions guidance.";
$activePage = 'home';

require_once __DIR__ . '/includes/header.php';

// Dynamic counts
$totalDistricts = 33;
$totalSchools = (int)($db->fetch("SELECT COUNT(*) as c FROM schools")['c'] ?? 330);
$totalColleges = (int)($db->fetch("SELECT COUNT(*) as c FROM colleges")['c'] ?? 117);
$totalInstitutions = (int)($db->fetch("SELECT COUNT(*) as c FROM institutions")['c'] ?? 683);
$totalCourses = (int)($db->fetch("SELECT COUNT(*) as c FROM courses")['c'] ?? 1743);
$totalCatalogCourses = (int)($db->fetch("SELECT COUNT(*) as c FROM courses_catalog")['c'] ?? 29);
$totalResources = (int)($db->fetch("SELECT COUNT(*) as c FROM resources")['c'] ?? 6);

// Academic Categories
$categories = $db->fetchAll("SELECT * FROM categories ORDER BY id ASC");

// Featured courses from courses_catalog (Medical, Engineering, IT, Management)
$featuredCatalogCourses = $db->fetchAll("
    SELECT * FROM courses_catalog 
    WHERE slug IN ('mbbs', 'bds', 'bams', 'computer-engineering', 'bca', 'mba')
    ORDER BY id ASC
");

// Landmark Gujarat Colleges
$landmarkColleges = $db->fetchAll("
    SELECT * FROM colleges 
    WHERE rating >= 4.8 
    ORDER BY rating DESC 
    LIMIT 6
");

// Popular / Trending Campus Courses
$popularCourses = $db->fetchAll("
    SELECT c.*, i.name as institution_name, i.city, i.state 
    FROM courses c 
    JOIN institutions i ON c.institution_id = i.id 
    WHERE c.is_popular = 1 
    ORDER BY c.tuition_fee DESC 
    LIMIT 6
");

// Free Educational Resources (Study Materials, Past Papers, Notes)
$featuredResources = $db->fetchAll("
    SELECT r.*, c.name as category_name 
    FROM resources r 
    LEFT JOIN categories c ON r.category_id = c.id 
    ORDER BY r.downloads_count DESC 
    LIMIT 3
");

// Verified Student Reviews & Testimonials
$reviews = $db->fetchAll("
    SELECT r.*, i.name as institution_name 
    FROM reviews r 
    JOIN institutions i ON r.institution_id = i.id 
    ORDER BY r.id DESC 
    LIMIT 3
");

// Banaskantha talukas
$banaskanthaTalukas = [
    'Palanpur', 'Deesa', 'Dhanera', 'Tharad', 'Vadgam', 'Danta',
    'Amirgadh', 'Deodar', 'Kankrej', 'Bhabhar', 'Lakhani', 'Suigam', 'Vav'
];

// All 33 Gujarat Districts
$gujaratDistricts = [
    'Ahmedabad', 'Amreli', 'Anand', 'Aravalli', 'Banaskantha', 'Bharuch',
    'Bhavnagar', 'Botad', 'Chhota Udepur', 'Dahod', 'Dang', 'Devbhumi Dwarka',
    'Gandhinagar', 'Gir Somnath', 'Jamnagar', 'Junagadh', 'Kheda', 'Kutch',
    'Mahisagar', 'Mehsana', 'Morbi', 'Narmada', 'Navsari', 'Panchmahal',
    'Patan', 'Porbandar', 'Rajkot', 'Sabarkantha', 'Surat', 'Surendranagar',
    'Vadodara', 'Valsad'
];
?>

<main>
    <!-- Hero Section -->
    <section class="hero" id="heroSection">
        <div class="container hero-grid">
            <div>
                <div class="hero-badge">
                    <i class="fas fa-sparkles"></i> <span>Empowering 50,000+ Students Across Gujarat</span>
                </div>
                <h1 class="hero-title">
                    Discover Your Ideal <span class="gradient-text">College &amp; Career</span> Path
                </h1>
                <p class="hero-description">
                    Navigate verified schools across all 33 Gujarat districts, explore premier universities, in-demand degree programs, and free academic resources. Make informed decisions with transparent information and direct student guidance.
                </p>

                <!-- Universal Live Search Bar -->
                <div class="hero-search-card" id="heroSearchCard" style="position:relative;">
                    <div class="search-input-group">
                        <i class="fas fa-search" style="color:var(--primary);"></i>
                        <input type="text" id="heroSearchInput" placeholder="Search schools, colleges, courses, or districts (e.g. Banaskantha, BDS, LDCE, Palanpur)..." autocomplete="off">
                    </div>
                    <button type="button" class="btn btn-primary" onclick="const q = document.getElementById('heroSearchInput').value.trim(); if(q) window.location.href='schools.php?q=' + encodeURIComponent(q);">
                        Search
                    </button>

                    <!-- Autocomplete Dropdown List -->
                    <div class="autocomplete-dropdown" id="searchDropdown"></div>
                </div>

                <!-- Quick District Tags -->
                <div class="quick-tags" style="margin-top:16px;">
                    <span style="font-weight:700; color:#334155;"><i class="fas fa-map-marker-alt" style="color:#ef4444; margin-right:4px;"></i> Quick Districts:</span>
                    <a href="schools.php?district=Banaskantha" class="quick-tag" style="background:#eff6ff; color:#1d4ed8; font-weight:700; border-color:#bfdbfe;">Banaskantha (13 Talukas)</a>
                    <a href="schools.php?district=Ahmedabad" class="quick-tag">Ahmedabad</a>
                    <a href="schools.php?district=Surat" class="quick-tag">Surat</a>
                    <a href="schools.php?district=Rajkot" class="quick-tag">Rajkot</a>
                    <a href="schools.php?district=Vadodara" class="quick-tag">Vadodara</a>
                    <a href="schools.php?district=Gandhinagar" class="quick-tag">Gandhinagar</a>
                    <a href="schools.php" class="quick-tag" style="background:#fef3c7; color:#b45309; border-color:#fde68a;"><i class="fas fa-school"></i> All 33 Districts &rarr;</a>
                </div>
            </div>

            <!-- Hero Visual Graphics / Quick Metrics -->
            <div class="hero-illustration">
                <div style="background:#ffffff; border-radius:var(--radius-lg); padding:28px; box-shadow:0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); border:1px solid #e2e8f0;">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px; border-bottom:1px solid #f1f5f9; padding-bottom:14px;">
                        <div class="brand-icon" style="width:44px; height:44px; font-size:1.2rem;">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <div>
                            <h3 style="font-size:1.15rem; font-weight:800; color:#0f172a; margin:0;">Gujarat Education Portal</h3>
                            <span style="font-size:0.8rem; color:#64748b;">Comprehensive Academic Directory</span>
                        </div>
                    </div>

                    <!-- Visual Quick Metrics -->
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:14px; margin-bottom:20px;">
                        <div style="background:#f8fafc; padding:16px; border-radius:10px; text-align:center; border:1px solid #e2e8f0;">
                            <div style="font-size:1.8rem; font-weight:800; color:#2563eb;"><?= $totalDistricts ?></div>
                            <div style="font-size:0.8rem; color:#64748b; font-weight:600;">Districts in Gujarat</div>
                        </div>
                        <div style="background:#f8fafc; padding:16px; border-radius:10px; text-align:center; border:1px solid #e2e8f0;">
                            <div style="font-size:1.8rem; font-weight:800; color:#10b981;"><?= $totalSchools ?></div>
                            <div style="font-size:0.8rem; color:#64748b; font-weight:600;">Schools (10 / District)</div>
                        </div>
                        <div style="background:#f8fafc; padding:16px; border-radius:10px; text-align:center; border:1px solid #e2e8f0;">
                            <div style="font-size:1.8rem; font-weight:800; color:#f59e0b;"><?= $totalColleges ?>+</div>
                            <div style="font-size:0.8rem; color:#64748b; font-weight:600;">Colleges &amp; Universities</div>
                        </div>
                        <div style="background:#f8fafc; padding:16px; border-radius:10px; text-align:center; border:1px solid #e2e8f0;">
                            <div style="font-size:1.8rem; font-weight:800; color:#6366f1;"><?= $totalCatalogCourses ?></div>
                            <div style="font-size:0.8rem; color:#64748b; font-weight:600;">Degree Programs</div>
                        </div>
                    </div>

                    <div style="background:#eff6ff; border-radius:8px; padding:12px 16px; display:flex; align-items:center; gap:10px; font-size:0.85rem; color:#1e40af;">
                        <i class="fas fa-lock-open" style="font-size:1.1rem;"></i>
                        <span><strong>100% Free Open Access:</strong> Instant browsing for all students without any account or login.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 1: Three Primary Exploration Pillars -->
    <section class="section" style="background:#f8fafc;">
        <div class="container">
            <div style="text-align:center; max-width:700px; margin:0 auto 40px;">
                <span class="section-tag"><i class="fas fa-compass"></i> Start Your Educational Journey</span>
                <h2 class="section-title">Explore by Educational Category</h2>
                <p class="section-subtitle">
                    Select one of our primary directories to find verified schools, premier colleges, or detailed course specifications across Gujarat.
                </p>
            </div>

            <div class="card-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:24px;">
                
                <!-- Card 1: Explore Courses -->
                <div class="card" style="padding:32px; display:flex; flex-direction:column; justify-content:space-between; border-top:5px solid #2563eb; transition:transform 0.2s, box-shadow 0.2s;">
                    <div>
                        <div style="width:56px; height:56px; border-radius:14px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-size:1.6rem; margin-bottom:20px;">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 style="font-size:1.35rem; font-weight:800; color:#0f172a; margin-bottom:10px;">
                            Explore Courses
                        </h3>
                        <p style="color:#64748b; font-size:0.92rem; line-height:1.6; margin-bottom:16px;">
                            Detailed, separate information for every course: MBBS, BDS, BAMS, BHMS, BPT, Nursing, Pharmacy, Engineering disciplines, BCA, MCA, MBA, and Arts.
                        </p>
                        <div style="display:flex; flex-wrap:wrap; gap:6px; margin-bottom:20px;">
                            <span class="badge badge-light">Science / Medical</span>
                            <span class="badge badge-light">Engineering</span>
                            <span class="badge badge-light">Computer / IT</span>
                            <span class="badge badge-light">Management</span>
                        </div>
                    </div>
                    <a href="courses.php" class="btn btn-primary" style="width:100%; text-align:center;">
                        Browse All Courses &rarr;
                    </a>
                </div>

                <!-- Card 2: Find Schools -->
                <div class="card" style="padding:32px; display:flex; flex-direction:column; justify-content:space-between; border-top:5px solid #10b981; transition:transform 0.2s, box-shadow 0.2s;">
                    <div>
                        <div style="width:56px; height:56px; border-radius:14px; background:#f0fdf4; color:#10b981; display:flex; align-items:center; justify-content:center; font-size:1.6rem; margin-bottom:20px;">
                            <i class="fas fa-school"></i>
                        </div>
                        <h3 style="font-size:1.35rem; font-weight:800; color:#0f172a; margin-bottom:10px;">
                            Find Schools
                        </h3>
                        <p style="color:#64748b; font-size:0.92rem; line-height:1.6; margin-bottom:16px;">
                            Explore schools across all 33 Gujarat districts with 10 schools in each district. Filter by Government vs Private and discover Banaskantha’s 13 talukas.
                        </p>
                        <div style="display:flex; flex-wrap:wrap; gap:6px; margin-bottom:20px;">
                            <span class="badge badge-success">Government</span>
                            <span class="badge badge-info">Private</span>
                            <span class="badge badge-light">All 33 Districts</span>
                            <span class="badge badge-light">Banaskantha Talukas</span>
                        </div>
                    </div>
                    <a href="schools.php" class="btn btn-outline" style="width:100%; text-align:center; border-color:#10b981; color:#059669;">
                        Explore 330 Schools &rarr;
                    </a>
                </div>

                <!-- Card 3: Find Colleges -->
                <div class="card" style="padding:32px; display:flex; flex-direction:column; justify-content:space-between; border-top:5px solid #f59e0b; transition:transform 0.2s, box-shadow 0.2s;">
                    <div>
                        <div style="width:56px; height:56px; border-radius:14px; background:#fffbeb; color:#f59e0b; display:flex; align-items:center; justify-content:center; font-size:1.6rem; margin-bottom:20px;">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 style="font-size:1.35rem; font-weight:800; color:#0f172a; margin-bottom:10px;">
                            Find Colleges
                        </h3>
                        <p style="color:#64748b; font-size:0.92rem; line-height:1.6; margin-bottom:16px;">
                            Filter premier colleges and universities across Ahmedabad, Gandhinagar, Surat, Vadodara, Rajkot, Kadi, Mehsana, and all Gujarat cities with course offerings.
                        </p>
                        <div style="display:flex; flex-wrap:wrap; gap:6px; margin-bottom:20px;">
                            <span class="badge badge-light">Ahmedabad</span>
                            <span class="badge badge-light">Gandhinagar</span>
                            <span class="badge badge-light">Vadodara</span>
                            <span class="badge badge-light">Surat</span>
                        </div>
                    </div>
                    <a href="colleges.php" class="btn btn-outline" style="width:100%; text-align:center; border-color:#f59e0b; color:#d97706;">
                        Explore 117+ Colleges &rarr;
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION 2: Academic Disciplines & Streams -->
    <?php if (!empty($categories)): ?>
    <section class="section" id="categoriesSection" style="background:#ffffff;">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><i class="fas fa-layer-group"></i> Academic Disciplines</span>
                <h2 class="section-title">Explore by Academic Stream</h2>
                <p class="section-subtitle">Discover premier accredited programs matching your passion and professional ambitions.</p>
            </div>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:20px;">
                <?php foreach ($categories as $cat): ?>
                    <a href="courses.php?category=<?= urlencode($cat['name']) ?>" 
                       style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:24px; text-decoration:none; display:flex; align-items:center; gap:16px; transition:all 0.2s;"
                       onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#2563eb'; this.style.transform='translateY(-2px)';"
                       onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.transform='none';">
                        <div style="width:48px; height:48px; border-radius:10px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-size:1.3rem; flex-shrink:0;">
                            <i class="<?= sanitize($cat['icon']) ?>"></i>
                        </div>
                        <div>
                            <div style="font-weight:700; color:#0f172a; font-size:1rem; margin-bottom:2px;"><?= sanitize($cat['name']) ?></div>
                            <div style="font-size:0.8rem; color:#64748b;"><?= sanitize($cat['description']) ?></div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- SECTION 3: Banaskantha Special Taluka Spotlight -->
    <section class="section" style="background:#f8fafc; border-top:1px solid #f1f5f9; border-bottom:1px solid #f1f5f9;">
        <div class="container">
            <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
                <div>
                    <span class="section-tag"><i class="fas fa-map-pin"></i> Banaskantha Spotlight</span>
                    <h2 class="section-title" style="margin-bottom:6px;">Banaskantha District Schools &amp; Talukas</h2>
                    <p class="section-subtitle">
                        Filter and find verified Government and Private schools across all 13 talukas of Banaskantha.
                    </p>
                </div>
                <a href="schools.php?district=Banaskantha" class="btn btn-primary btn-sm">
                    View Banaskantha Schools &rarr;
                </a>
            </div>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap:12px;">
                <?php foreach ($banaskanthaTalukas as $tal): ?>
                    <a href="schools.php?district=Banaskantha&taluka=<?= urlencode($tal) ?>" 
                       style="background:#ffffff; border:1px solid #e2e8f0; border-radius:10px; padding:14px; text-align:center; text-decoration:none; color:#0f172a; font-weight:700; font-size:0.9rem; transition:all 0.2s;"
                       onmouseover="this.style.borderColor='#2563eb'; this.style.background='#eff6ff'; this.style.color='#1e40af';"
                       onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='#ffffff'; this.style.color='#0f172a';">
                        <i class="fas fa-compass" style="color:#2563eb; display:block; margin-bottom:6px; font-size:1.1rem;"></i>
                        <?= sanitize($tal) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- SECTION 4: Featured Specialized Courses (Medical, Science, Engineering, IT) -->
    <section class="section" style="background:#ffffff;">
        <div class="container">
            <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px; margin-bottom:32px;">
                <div>
                    <span class="section-tag"><i class="fas fa-award"></i> Dedicated Course Intelligence</span>
                    <h2 class="section-title" style="margin-bottom:6px;">Featured Gujarat Academic Courses</h2>
                    <p class="section-subtitle">
                        Each program has its own distinct eligibility criteria, entrance exams, career prospects, and Gujarat college list.
                    </p>
                </div>
                <a href="courses.php" class="btn btn-outline">
                    View All 29 Courses &rarr;
                </a>
            </div>

            <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:22px;">
                <?php foreach ($featuredCatalogCourses as $fc): ?>
                    <div class="card" style="display:flex; flex-direction:column; justify-content:space-between; height:100%; border-top:4px solid #2563eb;">
                        <div class="card-body">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                <span class="badge badge-primary" style="font-size:0.75rem;"><?= sanitize($fc['category']) ?></span>
                                <span class="badge badge-light" style="font-size:0.78rem;"><?= sanitize($fc['duration']) ?></span>
                            </div>

                            <h3 style="font-size:1.2rem; font-weight:800; color:#0f172a; margin-bottom:8px;">
                                <a href="course-detail.php?id=<?= $fc['id'] ?>" style="color:#0f172a; text-decoration:none;">
                                    <?= sanitize($fc['name']) ?>
                                </a>
                            </h3>

                            <p style="font-size:0.86rem; color:#475569; line-height:1.6; margin-bottom:12px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;">
                                <?= sanitize($fc['description']) ?>
                            </p>

                            <div style="background:#f8fafc; border-radius:6px; padding:10px; font-size:0.8rem; color:#334155; margin-bottom:14px; border:1px solid #f1f5f9;">
                                <strong>Eligibility:</strong> <?= sanitize($fc['eligibility']) ?>
                            </div>
                        </div>

                        <div style="padding:14px 20px; background:#ffffff; border-top:1px solid #f1f5f9;">
                            <a href="course-detail.php?id=<?= $fc['id'] ?>" class="btn btn-primary btn-sm" style="width:100%; text-align:center;">
                                View Complete Details &rarr;
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- SECTION 5: Premier Landmark Gujarat Colleges Showcase -->
    <section class="section" style="background:#f8fafc;">
        <div class="container">
            <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px; margin-bottom:32px;">
                <div>
                    <span class="section-tag"><i class="fas fa-university"></i> Top Gujarat Universities &amp; Colleges</span>
                    <h2 class="section-title" style="margin-bottom:6px;">Important Gujarat Institutions</h2>
                    <p class="section-subtitle">
                        Featuring premier government engineering colleges, state universities, and private institutes.
                    </p>
                </div>
                <a href="colleges.php" class="btn btn-outline">
                    View All 117+ Colleges &rarr;
                </a>
            </div>

            <div class="card-grid" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:22px;">
                <?php foreach ($landmarkColleges as $lc): ?>
                    <div class="card" style="display:flex; flex-direction:column; justify-content:space-between; height:100%; border-top:3px solid <?= ($lc['type'] === 'Government') ? '#10b981' : '#2563eb' ?>;">
                        <div class="card-body">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                <span class="badge <?= ($lc['type'] === 'Government') ? 'badge-success' : 'badge-info' ?>">
                                    <?= sanitize($lc['type']) ?>
                                </span>
                                <span class="badge badge-light" style="color:#2563eb;">
                                    <i class="fas fa-city"></i> <?= sanitize($lc['city']) ?>
                                </span>
                            </div>

                            <h3 style="font-size:1.1rem; font-weight:800; color:#0f172a; margin-bottom:8px;">
                                <a href="college-detail.php?id=<?= $lc['id'] ?>" style="color:#0f172a; text-decoration:none;">
                                    <?= sanitize($lc['name']) ?>
                                </a>
                            </h3>

                            <p style="font-size:0.85rem; color:#64748b; line-height:1.5; margin-bottom:12px;">
                                <i class="fas fa-location-dot" style="margin-right:4px;"></i> <?= sanitize($lc['address']) ?>
                            </p>

                            <div style="background:#eff6ff; border-radius:6px; padding:10px; font-size:0.82rem; color:#1e40af;">
                                <strong>Programs:</strong> <?= sanitize($lc['courses_offered']) ?>
                            </div>
                        </div>

                        <div style="padding:14px 20px; background:#ffffff; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; gap:8px;">
                            <a href="college-detail.php?id=<?= $lc['id'] ?>" class="btn btn-outline btn-sm" style="flex:1; text-align:center;">
                                View Details
                            </a>
                            <?php if (!empty($lc['website'])): ?>
                                <a href="<?= sanitize($lc['website']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" title="Website">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- SECTION 6: Free Study Resources Vault (Previous Feature Restored) -->
    <?php if (!empty($featuredResources)): ?>
    <section class="section" id="resourcesSection" style="background:#ffffff;">
        <div class="container">
            <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px; margin-bottom:36px;">
                <div>
                    <span class="section-tag"><i class="fas fa-book-reader"></i> Free Study Materials</span>
                    <h2 class="section-title" style="margin-bottom:6px;">Educational Resources &amp; Notes</h2>
                    <p class="section-subtitle">Download curated lecture notes, board past papers, and competitive examination guides.</p>
                </div>
                <a href="resources.php" class="btn btn-outline">Browse All Study Materials &rarr;</a>
            </div>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:24px;">
                <?php foreach ($featuredResources as $res): ?>
                    <div class="card" style="padding:24px; display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                                <span class="badge badge-light" style="color:#2563eb; font-weight:700;">
                                    <?= sanitize($res['category_name'] ?? 'General Study') ?>
                                </span>
                                <span style="font-size:0.8rem; color:#64748b; font-weight:600;">
                                    <i class="fas fa-file-pdf" style="color:#ef4444; margin-right:4px;"></i> <?= sanitize($res['file_format'] ?? 'PDF') ?>
                                </span>
                            </div>

                            <h3 style="font-size:1.1rem; font-weight:700; color:#0f172a; margin-bottom:8px; line-height:1.4;">
                                <?= sanitize($res['title']) ?>
                            </h3>

                            <p style="font-size:0.85rem; color:#64748b; line-height:1.6; margin-bottom:16px;">
                                <?= sanitize($res['description']) ?>
                            </p>
                        </div>

                        <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #f1f5f9; padding-top:14px;">
                            <span style="font-size:0.8rem; color:#94a3b8;">
                                <i class="fas fa-download"></i> <?= (int)$res['downloads_count'] ?> downloads
                            </span>
                            <a href="resources.php?download=<?= $res['id'] ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- SECTION 7: Verified Student Reviews & Testimonials (Previous Feature Restored) -->
    <?php if (!empty($reviews)): ?>
    <section class="section" id="reviewsSection" style="background:#f8fafc;">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><i class="fas fa-comment-alt"></i> Authentic Student Voices</span>
                <h2 class="section-title">Verified Student Reviews</h2>
                <p class="section-subtitle">Real experiences and feedback from students studying across top universities.</p>
            </div>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:24px;">
                <?php foreach ($reviews as $rev): ?>
                    <div class="card" style="padding:28px; display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                                <div style="color:#f59e0b; font-size:0.9rem;">
                                    <?php for ($i = 0; $i < (int)$rev['rating']; $i++): ?>⭐<?php endfor; ?>
                                </div>
                                <span class="badge badge-success" style="font-size:0.75rem;">Verified Student</span>
                            </div>

                            <h4 style="font-size:1.05rem; font-weight:700; color:#0f172a; margin-bottom:6px;">
                                "<?= sanitize($rev['review_title']) ?>"
                            </h4>

                            <p style="font-size:0.88rem; color:#475569; line-height:1.6; margin-bottom:16px;">
                                <?= sanitize($rev['review_content']) ?>
                            </p>
                        </div>

                        <div style="border-top:1px solid #f1f5f9; padding-top:12px;">
                            <strong style="color:#0f172a; font-size:0.9rem; display:block;"><?= sanitize($rev['student_name']) ?></strong>
                            <span style="font-size:0.8rem; color:#64748b;"><?= sanitize($rev['course_name']) ?> &bull; <?= sanitize($rev['institution_name']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- SECTION 8: Fast 33 District Schools Grid Explorer -->
    <section class="section" style="background:#ffffff;">
        <div class="container">
            <div style="text-align:center; max-width:700px; margin:0 auto 30px;">
                <span class="section-tag"><i class="fas fa-map-marked-alt"></i> Complete Gujarat Coverage</span>
                <h2 class="section-title">All 33 Gujarat Districts</h2>
                <p class="section-subtitle">
                    Select your district to explore 10 verified schools with Government and Private filters.
                </p>
            </div>

            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap:10px;">
                <?php foreach ($gujaratDistricts as $dist): ?>
                    <a href="schools.php?district=<?= urlencode($dist) ?>" 
                       style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px 14px; text-decoration:none; color:#1e293b; font-weight:600; font-size:0.85rem; display:flex; justify-content:space-between; align-items:center; transition:all 0.2s;"
                       onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#2563eb'; this.style.color='#1e40af';"
                       onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#e2e8f0'; this.style.color='#1e293b';">
                        <span><?= sanitize($dist) ?></span>
                        <i class="fas fa-arrow-right" style="font-size:0.75rem; color:#94a3b8;"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- SECTION 9: Project Info & Developer Credit Banner -->
    <section class="section" style="background:linear-gradient(135deg, #1e40af 0%, #2563eb 100%); color:#ffffff;">
        <div class="container" style="text-align:center; max-width:800px;">
            <div style="width:60px; height:60px; border-radius:50%; background:rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:1.6rem;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h2 style="font-size:2rem; font-weight:800; color:#ffffff; margin-bottom:12px;">
                Student Education System
            </h2>
            <p style="font-size:1.05rem; line-height:1.7; color:#dbeafe; margin-bottom:24px;">
                Built and developed by <strong>Kiran Chaudhary</strong> to provide transparent, accurate, and free educational guidance for students across Gujarat.
            </p>
            <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap;">
                <a href="about.php" class="btn" style="background:#ffffff; color:#1e40af; font-weight:700;">
                    <i class="fas fa-info-circle"></i> About Project
                </a>
                <a href="resources.php" class="btn btn-outline" style="border-color:#ffffff; color:#ffffff;">
                    <i class="fas fa-file-alt"></i> Study Materials
                </a>
                <a href="inquiry.php" class="btn btn-outline" style="border-color:#ffffff; color:#ffffff;">
                    <i class="fas fa-headset"></i> Admissions Help
                </a>
                <a href="feedback.php" class="btn btn-outline" style="border-color:#ffffff; color:#ffffff;">
                    <i class="fas fa-star"></i> Give Feedback
                </a>
                <a href="contact.php" class="btn btn-outline" style="border-color:#ffffff; color:#ffffff;">
                    <i class="fas fa-phone-alt"></i> Contact (+91 70464 83464)
                </a>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
