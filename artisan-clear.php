<?php
echo "<pre>";
echo shell_exec('php artisan config:clear');
echo shell_exec('php artisan cache:clear');
echo shell_exec('php artisan route:clear');
echo shell_exec('php artisan view:clear');
echo shell_exec('php artisan optimize:clear');
echo "</pre>";
