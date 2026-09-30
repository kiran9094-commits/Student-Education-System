<?php
/**
 * Application Constants and Global Settings
 * Student Education System
 */

// Application Info
define('APP_NAME', 'Student Education System');
define('APP_SHORT_NAME', 'Student Education System');
define('APP_TAGLINE', 'Empowering Academic Journeys with Verified Schools, Colleges & Resources');
define('APP_VERSION', '1.0.0');

// Base URL calculation (works for both localhost subfolders and root domain)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$basePath = preg_replace('#/(admin|api|includes|assets.*)$#', '', $scriptName);
$basePath = rtrim($basePath, '/');
define('BASE_URL', $protocol . $host . $basePath);

// File Paths
define('ROOT_PATH', dirname(__DIR__));
define('DATABASE_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'database');
define('INCLUDES_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'includes');
define('ASSETS_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'assets');

// Currency & Formatting
define('CURRENCY_SYMBOL', '₹'); // Can be $, €, etc.
define('SITE_EMAIL', 'admissions@studenteducationsystem.edu');
define('SITE_PHONE', '+91 70464 83464');
define('SITE_ADDRESS', 'Education Knowledge Tower, Ashram Road, Ahmedabad, Gujarat - 380009');

// Auto-load core helper functions
require_once dirname(__DIR__) . '/includes/functions.php';
