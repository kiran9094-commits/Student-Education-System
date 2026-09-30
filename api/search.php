<?php
/**
 * AJAX Live Search API
 * Returns matching schools, colleges, and courses
 */

header('Content-Type: application/json; charset=utf-8');

require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/database/Database.php';
require_once dirname(__DIR__) . '/includes/functions.php';

$query = trim($_GET['q'] ?? '');

if (strlen($query) < 2) {
    echo json_encode(['success' => false, 'schools' => [], 'colleges' => [], 'courses' => []]);
    exit;
}

try {
    $db = Database::getInstance();
    $searchTerm = "%{$query}%";

    // 1. Search Schools
    $schoolSql = "SELECT id, name, type, district, address, website 
                  FROM schools 
                  WHERE name LIKE ? OR district LIKE ? OR address LIKE ? OR taluka LIKE ? 
                  ORDER BY name ASC LIMIT 6";
    $schools = $db->fetchAll($schoolSql, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);

    // 2. Search Colleges
    $collegeSql = "SELECT id, name, type, city, address, website, courses_offered 
                   FROM colleges 
                   WHERE name LIKE ? OR city LIKE ? OR courses_offered LIKE ? OR category LIKE ? 
                   ORDER BY rating DESC, name ASC LIMIT 6";
    $colleges = $db->fetchAll($collegeSql, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);

    // 3. Search Courses
    $courseSql = "SELECT id, name, category, duration, degree_level, eligibility 
                  FROM courses_catalog 
                  WHERE name LIKE ? OR category LIKE ? OR description LIKE ? OR related_colleges LIKE ? 
                  ORDER BY name ASC LIMIT 6";
    $courses = $db->fetchAll($courseSql, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);

    echo json_encode([
        'success' => true,
        'query' => $query,
        'schools' => $schools,
        'colleges' => $colleges,
        'courses' => $courses
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
