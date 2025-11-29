<?php
// post-deploy.php
// Akses via: https://sipeg.harikenangan.my.id/post-deploy.php?key=SECRET_KEY

if ($_GET['key'] !== 'S1p3g!@#321Deploy') {
    die('Unauthorized');
}

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "Clearing caches...\n";
$kernel->call('config:clear');
$kernel->call('cache:clear');
$kernel->call('view:clear');
$kernel->call('route:clear');
$kernel->call('optimize');

echo "Done!\n";
