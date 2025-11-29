<?php

use Illuminate\Support\Facades\DB;
// fix-units.php
// Akses: https://sipeg.harikenangan.my.id/fix-units.php?key=S1p3g!@#321

$password = 'S1p3g!@#321';
if (!isset($_GET['key']) || $_GET['key'] !== $password) {
    die('Unauthorized');
}

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

echo "<pre>";
echo "🔍 DEBUGGING UNITS\n\n";

// Test 1: Raw PDO
echo "1️⃣ Raw PDO Query:\n";
$pdo = $app->make('db')->connection()->getPdo();
$stmt = $pdo->query("SELECT id, nama_unit FROM units ORDER BY nama_unit");
$rawResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "   Found: " . count($rawResults) . " rows\n";
foreach ($rawResults as $row) {
    echo "   • ID: {$row['id']} | Nama: {$row['nama_unit']}\n";
}
echo "\n";

// Test 2: DB Facade
echo "2️⃣ Laravel DB Facade:\n";
$dbResults = DB::select("SELECT id, nama_unit FROM units ORDER BY nama_unit");
echo "   Found: " . count($dbResults) . " rows\n";
foreach ($dbResults as $row) {
    echo "   • ID: {$row->id} | Nama: {$row->nama_unit}\n";
}
echo "\n";

// Test 3: Eloquent
echo "3️⃣ Eloquent Model:\n";
$eloquentResults = \App\Models\Unit::orderBy('nama_unit')->get();
echo "   Found: " . $eloquentResults->count() . " rows\n";
foreach ($eloquentResults as $unit) {
    echo "   • ID: {$unit->id} | Nama: {$unit->nama_unit}\n";
}
echo "\n";

// Test 4: Check encoding
echo "4️⃣ Database Encoding:\n";
$encoding = DB::select("SHOW VARIABLES LIKE 'character_set_database'");
echo "   Charset: " . ($encoding[0]->Value ?? 'unknown') . "\n";
$collation = DB::select("SHOW VARIABLES LIKE 'collation_database'");
echo "   Collation: " . ($collation[0]->Value ?? 'unknown') . "\n";
echo "\n";

// Test 5: Table encoding
echo "5️⃣ Table Encoding:\n";
$tableStatus = DB::select("SHOW TABLE STATUS WHERE Name = 'units'");
if (!empty($tableStatus)) {
    echo "   Collation: " . $tableStatus[0]->Collation . "\n";
}

echo "\n✅ Debugging selesai. Silakan screenshot hasil ini.\n";
echo "</pre>";
