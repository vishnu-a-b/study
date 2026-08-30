<?php
// Optional router for `php -S`, used only for local development.
// Without this, PHP's built-in server falls back to index.php for any
// unmatched path (e.g. a typo'd URL), which is harmless but confusing
// when testing. Run with:
//   php -S localhost:8000 -t public scripts/dev-router.php
declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = is_string($path) ? urldecode($path) : '/';
if (str_ends_with($path, '/')) {
    $path .= 'index.php';
}
$file = realpath(__DIR__ . '/../public' . $path);
$docroot = realpath(__DIR__ . '/../public');

if ($file !== false && str_starts_with($file, $docroot) && is_file($file)) {
    return false; // let the built-in server serve the real file as-is
}

http_response_code(404);
echo '404 Not Found';
return true;
