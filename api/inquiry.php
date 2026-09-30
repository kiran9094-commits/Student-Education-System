<?php
/**
 * AJAX Student Inquiry API
 * Handles admission & counseling inquiries
 */

header('Content-Type: application/json; charset=utf-8');

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/database/Database.php';
require_once dirname(__DIR__) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

$studentName = trim($_POST['student_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$city = trim($_POST['city'] ?? '');
$qualification = trim($_POST['qualification'] ?? '');
$message = trim($_POST['message'] ?? '');
$institutionId = !empty($_POST['institution_id']) ? (int)$_POST['institution_id'] : null;
$courseId = !empty($_POST['course_id']) ? (int)$_POST['course_id'] : null;

// Validation
if (empty($studentName) || empty($email) || empty($phone)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please provide your Full Name, Email, and Phone Number.'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please provide a valid email address.'
    ]);
    exit;
}

try {
    $db = Database::getInstance();
    $sql = "INSERT INTO inquiries (student_name, email, phone, city, qualification, message, institution_id, course_id, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
    $db->query($sql, [
        $studentName,
        $email,
        $phone,
        $city,
        $qualification,
        $message,
        $institutionId,
        $courseId
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Thank you, ' . sanitize($studentName) . '! Your inquiry has been submitted. Our education counselor will contact you shortly.'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error recording inquiry: ' . $e->getMessage()
    ]);
}
