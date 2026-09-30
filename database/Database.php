<?php
/**
 * Database Handler & Query Helper
 * Student Education System
 */

class Database {
    private static ?Database $instance = null;
    private ?PDO $pdo = null;
    private string $driver = 'none';
    private string $statusMessage = '';
    private bool $isConnected = false;

    private function __construct() {
        $this->connect();
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function connect(): void {
        $config = require dirname(__DIR__) . '/config/database.php';
        $preferredDriver = $config['driver'] ?? 'auto';

        // 1. Try MySQL if requested or in auto mode
        if ($preferredDriver === 'mysql' || $preferredDriver === 'auto') {
            try {
                $mc = $config['mysql'];
                $dsn = "mysql:host={$mc['host']};port={$mc['port']};charset={$mc['charset']}";
                $rootPdo = new PDO($dsn, $mc['username'], $mc['password'], $mc['options']);
                
                // Ensure database exists
                $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `{$mc['database']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                
                // Connect directly to the database
                $dsnWithDb = "mysql:host={$mc['host']};port={$mc['port']};dbname={$mc['database']};charset={$mc['charset']}";
                $this->pdo = new PDO($dsnWithDb, $mc['username'], $mc['password'], $mc['options']);
                $this->driver = 'MySQL';
                $this->isConnected = true;
                $this->statusMessage = "Connected to MySQL ({$mc['database']})";
                
                $this->checkAndSeedIfNeeded();
                return;
            } catch (PDOException $e) {
                if ($preferredDriver === 'mysql') {
                    $this->statusMessage = "MySQL Connection Error: " . $e->getMessage();
                    $this->isConnected = false;
                    return;
                }
                // If auto, continue to SQLite fallback
            }
        }

        // 2. Fallback to SQLite (zero setup required, reliable)
        try {
            $sqlitePath = $config['sqlite']['file'];
            $sqliteDir = dirname($sqlitePath);
            if (!is_dir($sqliteDir)) {
                mkdir($sqliteDir, 0777, true);
            }

            $this->pdo = new PDO("sqlite:" . $sqlitePath);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->driver = 'SQLite (Auto-fallback)';
            $this->isConnected = true;
            $this->statusMessage = "Connected to SQLite database";

            $this->checkAndSeedIfNeeded();
        } catch (PDOException $e) {
            $this->statusMessage = "Database Error: " . $e->getMessage();
            $this->isConnected = false;
        }
    }

    public function getPdo(): ?PDO {
        return $this->pdo;
    }

    public function isConnected(): bool {
        return $this->isConnected;
    }

    public function getDriver(): string {
        return $this->driver;
    }

    public function getStatusMessage(): string {
        return $this->statusMessage;
    }

    public function query(string $sql, array $params = []): PDOStatement {
        if (!$this->pdo) {
            throw new Exception("Database is not connected: " . $this->statusMessage);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll(string $sql, array $params = []): array {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetch(string $sql, array $params = []): ?array {
        $result = $this->query($sql, $params)->fetch();
        return $result !== false ? $result : null;
    }

    public function lastInsertId(): string {
        return $this->pdo ? $this->pdo->lastInsertId() : '0';
    }

    public function checkAndSeedIfNeeded(): void {
        if (!$this->pdo) return;

        // Check if institutions table exists
        $tableExists = false;
        try {
            if (strpos($this->driver, 'MySQL') !== false) {
                $check = $this->pdo->query("SHOW TABLES LIKE 'institutions'");
                $tableExists = ($check && $check->rowCount() > 0);
            } else {
                $check = $this->pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='institutions'");
                $tableExists = ($check && $check->fetch() !== false);
            }
        } catch (Exception $e) {
            $tableExists = false;
        }

        if (!$tableExists) {
            $this->initializeSchema();
            $this->seedData();
        } else {
            // Check if institutions has data
            try {
                $count = (int)$this->pdo->query("SELECT COUNT(*) FROM institutions")->fetchColumn();
                if ($count === 0) {
                    $this->seedData();
                }
            } catch (Exception $e) {
                // Table might be corrupted or partial, re-seed
                $this->initializeSchema();
                $this->seedData();
            }
        }
    }

    public function initializeSchema(): void {
        if (!$this->pdo) return;

        if (strpos($this->driver, 'MySQL') !== false) {
            $schemaFile = __DIR__ . '/schema.sql';
            if (file_exists($schemaFile)) {
                $sql = file_get_contents($schemaFile);
                $this->pdo->exec($sql);
            }
        } else {
            // SQLite compatible schema creation
            $sqliteSchema = "
            CREATE TABLE IF NOT EXISTS categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                icon TEXT DEFAULT 'fas fa-graduation-cap',
                description TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS institutions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                type TEXT DEFAULT 'College',
                category_id INTEGER,
                accreditation TEXT DEFAULT 'UGC / AICTE Approved',
                affiliation TEXT DEFAULT NULL,
                city TEXT NOT NULL,
                state TEXT NOT NULL,
                address TEXT,
                established_year INTEGER,
                ranking_nirf TEXT DEFAULT NULL,
                rating REAL DEFAULT 4.5,
                reviews_count INTEGER DEFAULT 0,
                tuition_range TEXT DEFAULT '₹50,000 - ₹2,50,000 / yr',
                student_count INTEGER DEFAULT 5000,
                description TEXT,
                banner_image TEXT DEFAULT 'assets/images/college_banner_default.svg',
                logo_image TEXT DEFAULT 'assets/images/college_logo_default.svg',
                website TEXT,
                email TEXT,
                phone TEXT,
                facilities TEXT,
                is_featured INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS courses (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                institution_id INTEGER NOT NULL,
                category_id INTEGER NOT NULL,
                name TEXT NOT NULL,
                slug TEXT NOT NULL,
                degree_level TEXT NOT NULL,
                duration TEXT NOT NULL,
                tuition_fee REAL DEFAULT 0.00,
                eligibility TEXT,
                seats INTEGER DEFAULT 60,
                syllabus_summary TEXT,
                career_prospects TEXT,
                avg_package TEXT DEFAULT '₹4.5 - ₹12.0 LPA',
                is_popular INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS resources (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                category_id INTEGER,
                course_id INTEGER DEFAULT NULL,
                resource_type TEXT NOT NULL,
                format TEXT DEFAULT 'PDF',
                file_size TEXT DEFAULT '2.4 MB',
                description TEXT,
                download_url TEXT DEFAULT '#',
                downloads_count INTEGER DEFAULT 0,
                is_featured INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS inquiries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                student_name TEXT NOT NULL,
                email TEXT NOT NULL,
                phone TEXT NOT NULL,
                city TEXT,
                institution_id INTEGER,
                course_id INTEGER,
                qualification TEXT,
                message TEXT,
                status TEXT DEFAULT 'Pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS reviews (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                institution_id INTEGER NOT NULL,
                student_name TEXT NOT NULL,
                course_name TEXT,
                rating INTEGER DEFAULT 5,
                review_title TEXT,
                review_content TEXT,
                batch_year TEXT,
                is_verified INTEGER DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS admin_users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL UNIQUE,
                password_hash TEXT NOT NULL,
                full_name TEXT NOT NULL,
                role TEXT DEFAULT 'admin',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            ";
            $this->pdo->exec($sqliteSchema);
        }
    }

    public function seedData(): void {
        require_once __DIR__ . '/seed.php';
        runDatabaseSeed($this->pdo, $this->driver);
        if (file_exists(__DIR__ . '/seed_gujarat.php')) {
            require_once __DIR__ . '/seed_gujarat.php';
            seedGujaratInstitutions($this->pdo);
        }
        if (file_exists(__DIR__ . '/setup_original_system.php')) {
            require_once __DIR__ . '/setup_original_system.php';
            initOriginalStudentEducationSystem($this->pdo);
        }
    }
}
