<?php
// final-fix.php
// Akses: https://sipeg.harikenangan.my.id/final-fix.php?key=S1p3g!@#321
// HAPUS FILE INI setelah selesai!

$password = 'S1p3g!@#321';
if (!isset($_GET['key']) || $_GET['key'] !== $password) {
    die('❌ Unauthorized. Use: ?key=S1p3g!@#321');
}

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>SIPEG Final Fix</title>
    <style>
        body {
            background: #1e1e1e;
            color: #00ff00;
            font-family: 'Courier New', monospace;
            padding: 20px;
            line-height: 1.6;
        }
        .success { color: #00ff00; }
        .error { color: #ff0000; }
        .warning { color: #ffaa00; }
        .info { color: #00aaff; }
        hr { border: 1px solid #444; margin: 20px 0; }
    </style>
</head>
<body>";

echo "<h2>🔧 SIPEG FINAL FIX SCRIPT</h2>";
echo "<hr>";

require __DIR__ . '/vendor/autoload.php';

try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    // STEP 1: Clear ALL Cache
    echo "<h3>STEP 1: Clearing All Cache</h3>";

    $cacheCommands = [
        'config:clear' => 'Config Cache',
        'cache:clear' => 'Application Cache',
        'view:clear' => 'View Cache',
        'route:clear' => 'Route Cache',
    ];

    foreach ($cacheCommands as $command => $label) {
        try {
            $kernel->call($command);
            echo "<span class='success'>✅ {$label} cleared</span><br>";
        } catch (Exception $e) {
            echo "<span class='error'>❌ {$label} failed: {$e->getMessage()}</span><br>";
        }
    }

    // Manual cache deletion
    $cacheFiles = glob(__DIR__ . '/bootstrap/cache/*.php');
    $deleted = 0;
    foreach ($cacheFiles as $file) {
        if (basename($file) !== '.gitignore' && @unlink($file)) {
            $deleted++;
        }
    }
    echo "<span class='success'>✅ Deleted {$deleted} bootstrap cache files</span><br>";

    echo "<hr>";

    // STEP 2: Test Database Connection
    echo "<h3>STEP 2: Testing Database Connection</h3>";

    $pdo = DB::connection()->getPdo();
    $dbInfo = $pdo->getAttribute(PDO::ATTR_SERVER_INFO);
    echo "<span class='success'>✅ Connected to: {$dbInfo}</span><br>";

    $dbName = DB::connection()->getDatabaseName();
    echo "<span class='info'>📊 Database: {$dbName}</span><br>";

    echo "<hr>";

    // STEP 3: Check Table Encoding
    echo "<h3>STEP 3: Checking Table Encoding</h3>";

    $tableStatus = DB::select("SHOW TABLE STATUS WHERE Name = 'units'");
    if (!empty($tableStatus)) {
        $collation = $tableStatus[0]->Collation;
        echo "<span class='info'>🔤 Table Collation: {$collation}</span><br>";

        if (!str_contains($collation, 'utf8mb4')) {
            echo "<span class='warning'>⚠️  Warning: Table not using utf8mb4</span><br>";
            echo "<span class='warning'>   Attempting to fix...</span><br>";

            try {
                DB::statement("ALTER TABLE units CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                echo "<span class='success'>✅ Table encoding fixed!</span><br>";
            } catch (Exception $e) {
                echo "<span class='error'>❌ Could not fix: {$e->getMessage()}</span><br>";
            }
        }
    }

    echo "<hr>";

    // STEP 4: Test Raw Query
    echo "<h3>STEP 4: Testing Raw PDO Query</h3>";

    $rawStmt = $pdo->prepare("SELECT id, nama_unit FROM units ORDER BY nama_unit");
    $rawStmt->execute();
    $rawResults = $rawStmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<span class='success'>✅ Found {$rawResults->count()} units via PDO</span><br>";
    echo "<div style='background:#2a2a2a;padding:10px;margin:10px 0;'>";
    foreach (array_slice($rawResults, 0, 3) as $row) {
        $id = htmlspecialchars($row['id']);
        $nama = htmlspecialchars($row['nama_unit']);
        echo "   • ID: {$id} | Nama: {$nama}<br>";
    }
    echo "</div>";

    echo "<hr>";

    // STEP 5: Test DB Facade
    echo "<h3>STEP 5: Testing Laravel DB Facade</h3>";

    $dbResults = DB::table('units')
        ->select('id', 'nama_unit')
        ->whereNotNull('nama_unit')
        ->where('nama_unit', '!=', '')
        ->orderBy('nama_unit')
        ->get();

    echo "<span class='success'>✅ Found " . $dbResults->count() . " units via DB Facade</span><br>";
    echo "<div style='background:#2a2a2a;padding:10px;margin:10px 0;'>";
    foreach ($dbResults->take(3) as $row) {
        $id = htmlspecialchars($row->id);
        $nama = htmlspecialchars($row->nama_unit);
        echo "   • ID: {$id} | Nama: {$nama}<br>";
    }
    echo "</div>";

    echo "<hr>";

    // STEP 6: Test Eloquent Model
    echo "<h3>STEP 6: Testing Eloquent Model</h3>";

    $eloquentResults = \App\Models\Unit::whereNotNull('nama_unit')
        ->where('nama_unit', '!=', '')
        ->orderBy('nama_unit')
        ->get();

    echo "<span class='success'>✅ Found " . $eloquentResults->count() . " units via Eloquent</span><br>";
    echo "<div style='background:#2a2a2a;padding:10px;margin:10px 0;'>";
    foreach ($eloquentResults->take(3) as $unit) {
        $id = htmlspecialchars($unit->id);
        $nama = htmlspecialchars($unit->nama_unit);
        echo "   • ID: {$id} | Nama: {$nama}<br>";
    }
    echo "</div>";

    echo "<hr>";

    // STEP 7: Rebuild Cache
    echo "<h3>STEP 7: Rebuilding Optimized Cache</h3>";

    try {
        $kernel->call('config:cache');
        echo "<span class='success'>✅ Config cache rebuilt</span><br>";
    } catch (Exception $e) {
        echo "<span class='warning'>⚠️  Config cache: {$e->getMessage()}</span><br>";
    }

    try {
        $kernel->call('route:cache');
        echo "<span class='success'>✅ Route cache rebuilt</span><br>";
    } catch (Exception $e) {
        echo "<span class='warning'>⚠️  Route cache: {$e->getMessage()}</span><br>";
    }

    echo "<hr>";
    echo "<h2 class='success'>✨ ALL DONE!</h2>";
    echo "<p class='warning'>⚠️  IMPORTANT:</p>";
    echo "<ol>";
    echo "<li>Test halaman login sekarang: <a href='/login' style='color:#00aaff;'>/login</a></li>";
    echo "<li><strong style='color:#ff0000;'>DELETE file final-fix.php ini segera!</strong></li>";
    echo "<li>Jika masih ada masalah, screenshot hasil ini dan kirim ke developer</li>";
    echo "</ol>";
} catch (Exception $e) {
    echo "<h3 class='error'>❌ FATAL ERROR</h3>";
    echo "<pre class='error'>";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "</pre>";
}

echo "</body></html>";
