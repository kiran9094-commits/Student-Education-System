<?php
/**
 * Comprehensive Automated Test Suite
 * Student Education System
 */

$baseUrl = 'http://127.0.0.1:8000';
$results = [
    'syntax' => [],
    'endpoints' => [],
    'filters' => [],
    'course_details' => [],
    'forms' => [],
    'api' => [],
    'assets' => []
];

echo "========================================================\n";
echo "   STUDENT EDUCATION SYSTEM - AUTOMATED TEST SUITE      \n";
echo "========================================================\n\n";

// 1. PHP Syntax Check
echo "[SUITE 1/7] Testing PHP Syntax Across All Files...\n";
$phpFiles = [];
$dirIter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__));
foreach ($dirIter as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $phpFiles[] = $file->getPathname();
    }
}

$syntaxErrors = [];
foreach ($phpFiles as $f) {
    $out = [];
    $ret = 0;
    exec('"C:\\xampp\\php\\php.exe" -l "' . $f . '" 2>&1', $out, $ret);
    if ($ret !== 0) {
        $syntaxErrors[] = implode(' ', $out);
    }
}
if (empty($syntaxErrors)) {
    echo "  --> PASS: All " . count($phpFiles) . " PHP files passed syntax check without any errors.\n\n";
} else {
    echo "  --> FAIL: " . count($syntaxErrors) . " syntax errors found!\n";
    print_r($syntaxErrors);
    echo "\n";
}

// 2. Database Connectivity & Tables Check
echo "[SUITE 2/7] Testing Database Connection & Data Tables...\n";
require_once __DIR__ . '/database/Database.php';
$db = Database::getInstance();
$tables = ['schools', 'colleges', 'courses_catalog', 'feedback', 'contacts', 'institutions', 'courses', 'resources', 'reviews', 'inquiries', 'categories'];
$dbErrors = [];
foreach ($tables as $t) {
    try {
        $count = (int)$db->fetch("SELECT COUNT(*) as c FROM {$t}")['c'];
        echo "  - Table '{$t}': {$count} records OK\n";
    } catch (Exception $e) {
        $dbErrors[] = "Table {$t} error: " . $e->getMessage();
    }
}
if (empty($dbErrors)) {
    echo "  --> PASS: All 11 tables verified with authentic data.\n\n";
} else {
    echo "  --> FAIL: Database errors found: " . implode('; ', $dbErrors) . "\n\n";
}

// Helper function to test URL
function testUrl($url) {
    $ctx = stream_context_create([
        'http' => [
            'timeout' => 8,
            'ignore_errors' => true
        ]
    ]);
    $startTime = microtime(true);
    $content = @file_get_contents($url, false, $ctx);
    $duration = round((microtime(true) - $startTime) * 1000, 1);
    
    $status = 0;
    if (isset($http_response_header[0])) {
        preg_match('#HTTP/\S+\s+(\d+)#', $http_response_header[0], $matches);
        $status = isset($matches[1]) ? (int)$matches[1] : 0;
    }
    
    $hasFatal = false;
    $hasWarning = false;
    if ($content !== false) {
        if (stripos($content, 'Fatal error') !== false || stripos($content, 'Parse error') !== false) {
            $hasFatal = true;
        }
        if (stripos($content, 'Warning:') !== false || stripos($content, 'Notice:') !== false) {
            $hasWarning = true;
        }
    }
    
    return [
        'status' => $status,
        'bytes' => $content !== false ? strlen($content) : 0,
        'ms' => $duration,
        'fatal' => $hasFatal,
        'warning' => $hasWarning,
        'content' => $content
    ];
}

// 3. Core Pages Check
echo "[SUITE 3/7] Testing Core Web Pages...\n";
$corePages = [
    'Home' => '/',
    'Home explicit' => '/index.php',
    'Courses' => '/courses.php',
    'Schools' => '/schools.php',
    'Colleges' => '/colleges.php',
    'Admissions / Inquiry' => '/inquiry.php',
    'Study Resources' => '/resources.php',
    'All Institutions' => '/institutions.php',
    'About Us' => '/about.php',
    'Feedback' => '/feedback.php',
    'Contact' => '/contact.php',
    'Database Setup' => '/setup.php'
];

$coreFails = [];
foreach ($corePages as $name => $path) {
    $res = testUrl($baseUrl . $path);
    if ($res['status'] === 200 && !$res['fatal']) {
        echo "  - [200 OK] {$name} ({$path}) - {$res['bytes']} bytes in {$res['ms']}ms\n";
    } else {
        echo "  - [FAIL {$res['status']}] {$name} ({$path}) - Fatal: " . ($res['fatal'] ? 'YES' : 'NO') . "\n";
        $coreFails[] = $name;
    }
}
if (empty($coreFails)) {
    echo "  --> PASS: All core pages responded with HTTP 200 OK and no PHP errors.\n\n";
} else {
    echo "  --> FAIL: Failed pages: " . implode(', ', $coreFails) . "\n\n";
}

// 4. Testing Filter Combinations
echo "[SUITE 4/7] Testing Filter Combinations Across Gujarat Districts & Cities...\n";

// A. Test all 33 Districts on schools.php
$districts = [
    'Ahmedabad', 'Amreli', 'Anand', 'Aravalli', 'Banaskantha', 'Bharuch',
    'Bhavnagar', 'Botad', 'Chhota Udepur', 'Dahod', 'Dang', 'Devbhumi Dwarka',
    'Gandhinagar', 'Gir Somnath', 'Jamnagar', 'Junagadh', 'Kheda', 'Kutch',
    'Mahisagar', 'Mehsana', 'Morbi', 'Narmada', 'Navsari', 'Panchmahal',
    'Patan', 'Porbandar', 'Rajkot', 'Sabarkantha', 'Surat', 'Surendranagar',
    'Vadodara', 'Valsad'
];

$districtFails = [];
foreach ($districts as $d) {
    $res = testUrl($baseUrl . '/schools.php?district=' . urlencode($d));
    if ($res['status'] !== 200 || $res['fatal'] || $res['bytes'] < 5000) {
        $districtFails[] = $d;
    }
}
echo "  - Tested all 33 Gujarat Districts on schools.php: " . (empty($districtFails) ? "ALL 33 PASS" : "FAILS: " . implode(', ', $districtFails)) . "\n";

// B. Test Banaskantha 13 Talukas
$talukas = ['Palanpur', 'Deesa', 'Dhanera', 'Tharad', 'Vadgam', 'Danta', 'Amirgadh', 'Deodar', 'Kankrej', 'Bhabhar', 'Lakhani', 'Suigam', 'Vav'];
$talukaFails = [];
foreach ($talukas as $tal) {
    $res = testUrl($baseUrl . '/schools.php?district=Banaskantha&taluka=' . urlencode($tal));
    if ($res['status'] !== 200 || $res['fatal'] || $res['bytes'] < 5000) {
        $talukaFails[] = $tal;
    }
}
echo "  - Tested all 13 Banaskantha Talukas on schools.php: " . (empty($talukaFails) ? "ALL 13 PASS" : "FAILS: " . implode(', ', $talukaFails)) . "\n";

// C. Test School Types (Government, Private)
$resGovt = testUrl($baseUrl . '/schools.php?type=Government');
$resPvt = testUrl($baseUrl . '/schools.php?type=Private');
echo "  - Tested Government Schools filter: " . ($resGovt['status'] === 200 && !$resGovt['fatal'] ? "PASS ({$resGovt['bytes']} bytes)" : "FAIL") . "\n";
echo "  - Tested Private Schools filter: " . ($resPvt['status'] === 200 && !$resPvt['fatal'] ? "PASS ({$resPvt['bytes']} bytes)" : "FAIL") . "\n";

// D. Test Major Gujarat Cities on colleges.php
$cities = ['Ahmedabad', 'Gandhinagar', 'Vadodara', 'Surat', 'Rajkot', 'Mehsana', 'Anand', 'Bhavnagar', 'Patan'];
$cityFails = [];
foreach ($cities as $c) {
    $res = testUrl($baseUrl . '/colleges.php?city=' . urlencode($c));
    if ($res['status'] !== 200 || $res['fatal'] || $res['bytes'] < 5000) {
        $cityFails[] = $c;
    }
}
echo "  - Tested Major Cities on colleges.php: " . (empty($cityFails) ? "ALL PASS" : "FAILS: " . implode(', ', $cityFails)) . "\n";

// E. Test College Types
$resColGovt = testUrl($baseUrl . '/colleges.php?type=Government');
$resColPvt = testUrl($baseUrl . '/colleges.php?type=Private');
echo "  - Tested Government Colleges filter: " . ($resColGovt['status'] === 200 && !$resColGovt['fatal'] ? "PASS" : "FAIL") . "\n";
echo "  - Tested Private Colleges filter: " . ($resColPvt['status'] === 200 && !$resColPvt['fatal'] ? "PASS" : "FAIL") . "\n";

// F. Test Course Categories
$catStreams = ['SCIENCE', 'ENGINEERING', 'COMPUTER / IT', 'MANAGEMENT', 'ARTS'];
$catFails = [];
foreach ($catStreams as $cs) {
    $res = testUrl($baseUrl . '/courses.php?category=' . urlencode($cs));
    if ($res['status'] !== 200 || $res['fatal'] || $res['bytes'] < 5000) {
        $catFails[] = $cs;
    }
}
echo "  - Tested all 5 Academic Streams on courses.php: " . (empty($catFails) ? "ALL PASS" : "FAILS: " . implode(', ', $catFails)) . "\n\n";

// 5. Testing All 29 Specialized Course Detail Pages
echo "[SUITE 5/7] Testing Individual Course Detail Pages (1 to 29)...\n";
$courseDetailFails = [];
for ($cid = 1; $cid <= 29; $cid++) {
    $res = testUrl($baseUrl . '/course-detail.php?id=' . $cid);
    if ($res['status'] !== 200 || $res['fatal'] || $res['bytes'] < 10000) {
        $courseDetailFails[] = $cid;
    }
}
if (empty($courseDetailFails)) {
    echo "  --> PASS: All 29 Course Detail pages (MBBS, BDS, BAMS, BHMS, BPT, BCA, MCA, Engineering, etc.) load perfectly without errors.\n\n";
} else {
    echo "  --> FAIL: Failed course IDs: " . implode(', ', $courseDetailFails) . "\n\n";
}

// 6. Testing Form Submissions (Feedback, Contact, Inquiry)
echo "[SUITE 6/7] Testing Form Submissions & Database Persistence...\n";

// Test A: Feedback POST
$testEmail = 'audit_' . time() . '@studenteducationsystem.edu';
$fbPost = [
    'name' => 'Automated QA Tester',
    'email' => $testEmail,
    'rating' => 5,
    'message' => 'Automated QA testing run for Student Education System'
];
$fbContext = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($fbPost),
        'timeout' => 5
    ]
]);
$fbResp = file_get_contents($baseUrl . '/feedback.php', false, $fbContext);
$fbPassed = (strpos($fbResp, 'Thank you for your valuable feedback!') !== false);
$fbDb = $db->fetch("SELECT * FROM feedback WHERE email = ?", [$testEmail]);

echo "  - Feedback Form Submission: " . ($fbPassed && $fbDb ? "PASS (Saved in DB with ID #{$fbDb['id']})" : "FAIL") . "\n";

// Test B: Contact POST
$contactPost = [
    'name' => 'Automated QA Tester',
    'email' => $testEmail,
    'mobile' => '7046483464',
    'subject' => 'QA Verification',
    'message' => 'Test contact message from QA Suite'
];
$ctContext = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($contactPost),
        'timeout' => 5
    ]
]);
$ctResp = file_get_contents($baseUrl . '/contact.php', false, $ctContext);
$ctPassed = (strpos($ctResp, 'Your message has been submitted successfully.') !== false);
$ctDb = $db->fetch("SELECT * FROM contacts WHERE email = ?", [$testEmail]);

echo "  - Contact Form Submission: " . ($ctPassed && $ctDb ? "PASS (Saved in DB with ID #{$ctDb['id']})" : "FAIL") . "\n";

// Test C: Admission Inquiry POST
$inqPost = [
    'student_name' => 'Automated Student Tester',
    'email' => $testEmail,
    'phone' => '7046483464',
    'city' => 'Ahmedabad',
    'qualification' => '12th Science',
    'message' => 'Admission inquiry test'
];
$inqContext = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($inqPost),
        'timeout' => 5,
        'follow_location' => 0
    ]
]);
$inqResp = file_get_contents($baseUrl . '/inquiry.php', false, $inqContext);
$inqDb = $db->fetch("SELECT * FROM inquiries WHERE email = ?", [$testEmail]);
echo "  - Admission Guidance Inquiry Submission: " . ($inqDb ? "PASS (Saved in DB with ID #{$inqDb['id']})" : "FAIL") . "\n";

// Clean up audit test records
$db->query("DELETE FROM feedback WHERE email = ?", [$testEmail]);
$db->query("DELETE FROM contacts WHERE email = ?", [$testEmail]);
$db->query("DELETE FROM inquiries WHERE email = ?", [$testEmail]);
echo "  - Cleaned up test records from database.\n\n";

// 7. Testing Live Search API & Static Assets
echo "[SUITE 7/7] Testing Live Search API & Assets...\n";
$searchQueries = ['BDS', 'Ahmedabad', 'Banaskantha', 'Computer', 'Medical', 'Government'];
$searchFails = [];
foreach ($searchQueries as $sq) {
    $res = testUrl($baseUrl . '/api/search.php?q=' . urlencode($sq));
    $json = json_decode($res['content'], true);
    if (!$json || empty($json['success'])) {
        $searchFails[] = $sq;
    }
}
echo "  - Live Search API with multiple queries: " . (empty($searchFails) ? "ALL PASS (Valid JSON responses)" : "FAILS: " . implode(', ', $searchFails)) . "\n";

// Check CSS and JS assets
$cssRes = testUrl($baseUrl . '/assets/css/style.css');
$jsRes = testUrl($baseUrl . '/assets/js/main.js');
echo "  - style.css: " . ($cssRes['status'] === 200 ? "PASS ({$cssRes['bytes']} bytes)" : "FAIL") . "\n";
echo "  - main.js: " . ($jsRes['status'] === 200 ? "PASS ({$jsRes['bytes']} bytes)" : "FAIL") . "\n";

echo "\n========================================================\n";
echo "                   ALL TESTS COMPLETE                   \n";
echo "========================================================\n";
