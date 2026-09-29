<?php
declare(strict_types=1);

/**
 * Dev router for `php -S localhost:8000 router.php`
 * Serves static files from public/ and routes everything else to the front controller.
 * In production, point the webserver document root at public/ instead.
 */

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$file = __DIR__ . '/public' . $path;

if ($path !== '/' && is_file($file)) {
    return false; // let the built-in server deliver the static asset
}

require __DIR__ . '/public/index.php';
