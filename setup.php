<?php
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/database/Database.php';
require_once __DIR__ . '/includes/functions.php';

$db = Database::getInstance();
$config = require __DIR__ . '/config/database.php';
$msg = null;
$msgType = 'info';

// Handle connection test / migration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'test_mysql') {
        $host = trim($_POST['host'] ?? '127.0.0.1');
        $port = (int)($_POST['port'] ?? 3306);
        $user = trim($_POST['username'] ?? 'root');
        $pass = trim($_POST['password'] ?? '');
        $database = trim($_POST['database'] ?? 'student_education_db');

        try {
            $dsn = "mysql:host={$host};port={$port};charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
            // Create database
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$database}`");

            // Execute schema
            $schemaFile = __DIR__ . '/database/schema.sql';
            if (file_exists($schemaFile)) {
                $sql = file_get_contents($schemaFile);
                $pdo->exec($sql);
            }

            // Seed rich data
            require_once __DIR__ . '/database/seed.php';
            runDatabaseSeed($pdo, 'MySQL');

            // Save updated config
            $configFileContent = "<?php
/**
 * Database Configuration
 * Student Education System
 */

return [
    'driver' => 'mysql',
    'mysql' => [
        'host' => '{$host}',
        'port' => {$port},
        'database' => '{$database}',
        'username' => '{$user}',
        'password' => '{$pass}',
        'charset' => 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ],
    'sqlite' => [
        'file' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'education.sqlite'
    ]
];
";
            file_put_contents(__DIR__ . '/config/database.php', $configFileContent);

            $msg = "Success! Connected to MySQL, created database '{$database}', and imported all seed data successfully! The application is now running on MySQL.";
            $msgType = 'success';
        } catch (Exception $e) {
            $msg = "MySQL Connection Failed: " . $e->getMessage();
            $msgType = 'error';
        }
    } elseif ($action === 'reseed') {
        try {
            $db->seedData();
            $msg = "Database re-seeded successfully!";
            $msgType = 'success';
        } catch (Exception $e) {
            $msg = "Seeding error: " . $e->getMessage();
            $msgType = 'error';
        }
    } elseif ($action === 'switch_sqlite') {
        $configFileContent = "<?php
return [
    'driver' => 'sqlite',
    'mysql' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'student_education_db',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ],
    'sqlite' => [
        'file' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'education.sqlite'
    ]
];
";
        file_put_contents(__DIR__ . '/config/database.php', $configFileContent);
        $msg = "Switched to SQLite mode.";
        $msgType = 'success';
    }
}

// Re-read DB instance
$db = Database::getInstance();
$pageTitle = "Database Configuration & Setup Wizard - " . APP_NAME;
$activePage = 'setup';

require_once __DIR__ . '/includes/header.php';

// Fetch table metrics
$instCount = (int)($db->fetch("SELECT COUNT(*) as c FROM institutions")['c'] ?? 0);
$coursesCount = (int)($db->fetch("SELECT COUNT(*) as c FROM courses")['c'] ?? 0);
$resourcesCount = (int)($db->fetch("SELECT COUNT(*) as c FROM resources")['c'] ?? 0);
$inquiriesCount = (int)($db->fetch("SELECT COUNT(*) as c FROM inquiries")['c'] ?? 0);
?>

<main class="section">
    <div class="container" style="max-width:900px;">
        <div style="margin-bottom: 32px;">
            <span class="section-tag"><i class="fas fa-database"></i> Environment &amp; Storage</span>
            <h1 class="section-title">Database Setup &amp; Migration Console</h1>
            <p class="section-subtitle">
                Inspect your live database status, configure MySQL credentials, or run sample data migrations.
            </p>
        </div>

        <?php if ($msg): ?>
            <div class="toast toast-<?= $msgType ?>" style="position:static; margin-bottom:24px; min-width:auto;">
                <i class="fas fa-<?= $msgType === 'success' ? 'check-circle' : 'exclamation-triangle' ?>"></i>
                <span><?= sanitize($msg) ?></span>
            </div>
        <?php endif; ?>

        <!-- Active Engine Status Card -->
        <div style="background:#fff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:32px; box-shadow:var(--shadow-sm); margin-bottom:32px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <div>
                    <span style="font-size:0.85rem; font-weight:700; color:#64748b; text-transform:uppercase;">Active Storage Engine</span>
                    <h2 style="font-size:1.6rem; font-weight:800; color:#0f172a;"><?= sanitize($db->getDriver()) ?></h2>
                </div>
                <div class="db-status-pill" style="padding:10px 20px; font-size:0.95rem;">
                    <span class="status-dot"></span>
                    <span><?= sanitize($db->getStatusMessage()) ?></span>
                </div>
            </div>

            <!-- Stats in DB -->
            <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:16px; background:#f8fafc; padding:20px; border-radius:var(--radius-md); border:1px solid #e2e8f0; margin-bottom:24px;">
                <div style="text-align:center;">
                    <div style="font-size:1.6rem; font-weight:800; color:var(--primary);"><?= $instCount ?></div>
                    <div style="font-size:0.85rem; color:#64748b;">Institutions</div>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:1.6rem; font-weight:800; color:#0284c7;"><?= $coursesCount ?></div>
                    <div style="font-size:0.85rem; color:#64748b;">Courses</div>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:1.6rem; font-weight:800; color:#d97706;"><?= $resourcesCount ?></div>
                    <div style="font-size:0.85rem; color:#64748b;">Resources</div>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:1.6rem; font-weight:800; color:#059669;"><?= $inquiriesCount ?></div>
                    <div style="font-size:0.85rem; color:#64748b;">Inquiries</div>
                </div>
            </div>

            <div style="display:flex; gap:12px;">
                <form method="POST" action="setup.php" style="display:inline;">
                    <input type="hidden" name="action" value="reseed">
                    <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Re-seed realistic sample data?');">
                        <i class="fas fa-sync-alt"></i> Re-Seed Sample Data
                    </button>
                </form>

                <?php if (strpos($db->getDriver(), 'SQLite') === false): ?>
                    <form method="POST" action="setup.php" style="display:inline;">
                        <input type="hidden" name="action" value="switch_sqlite">
                        <button type="submit" class="btn btn-outline btn-sm">
                            <i class="fas fa-file-code"></i> Switch to SQLite
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Connect to MySQL Form -->
        <div style="background:#fff; border:1px solid var(--border-color); border-radius:var(--radius-lg); padding:32px; box-shadow:var(--shadow-sm);">
            <div style="margin-bottom:24px;">
                <h3 style="font-size:1.4rem; font-weight:800; color:#0f172a;">Connect to MySQL Server</h3>
                <p style="font-size:0.92rem; color:#64748b;">
                    Enter your MySQL / MariaDB connection parameters below. The wizard will automatically create the database <code>student_education_db</code>, execute <code>database/schema.sql</code>, and import all seed records.
                </p>
            </div>

            <form method="POST" action="setup.php">
                <input type="hidden" name="action" value="test_mysql">

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">MySQL Host</label>
                        <input type="text" name="host" class="form-control" value="127.0.0.1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Port</label>
                        <input type="number" name="port" class="form-control" value="3306" required>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="root" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave empty for default XAMPP, or enter root password">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Database Name</label>
                    <input type="text" name="database" class="form-control" value="student_education_db" required>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                    <i class="fas fa-bolt"></i> Connect &amp; Migrate to MySQL
                </button>
            </form>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
