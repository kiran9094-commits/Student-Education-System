<?php
/**
 * Database Configuration
 * Student Education System
 */

return [
    // Preferred driver: 'auto', 'mysql', or 'sqlite'
    // 'auto' tries MySQL first, falls back to SQLite if credentials fail
    'driver' => 'auto',

    // MySQL Settings
    'mysql' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'student_education_db',
        'username' => 'root',
        'password' => '', // Default XAMPP empty password
        'charset' => 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ],

    // SQLite Fallback Settings (Zero configuration needed)
    'sqlite' => [
        'file' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'education.sqlite'
    ]
];
