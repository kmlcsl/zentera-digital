<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Debug info - HAPUS SETELAH FIXED
if (isset($_GET['debug'])) {
    echo "=== DEBUG INFO ===\n";
    echo "PHP Version: " . PHP_VERSION . "\n";
    echo "Current Dir: " . __DIR__ . "\n";
    echo "App Path: " . __DIR__ . '/../app' . "\n";
    echo "Controller exists: " . (file_exists(__DIR__ . '/../app/Http/Controllers/Admin/AuthController.php') ? 'YES' : 'NO') . "\n";
    echo "Vendor autoload: " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'YES' : 'NO') . "\n";
    echo "Bootstrap app: " . (file_exists(__DIR__ . '/../bootstrap/app.php') ? 'YES' : 'NO') . "\n";

    if (file_exists(__DIR__ . '/../vendor/composer/autoload_classmap.php')) {
        $classmap = require __DIR__ . '/../vendor/composer/autoload_classmap.php';
        echo "AuthController in classmap: " . (isset($classmap['App\\Http\\Controllers\\Admin\\AuthController']) ? 'YES' : 'NO') . "\n";
    }

    echo "==================\n";
    exit;
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__ . '/../bootstrap/app.php')
    ->handleRequest(Request::capture());
