<?php
// Router for PHP's built-in server (local development only), run from demo/project:
//   php -S 127.0.0.1:8090 -t public ../router.php
// Existing files (Studio's JavaScript, CSS, images) are served directly; everything else goes to Pimcore.
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$public = __DIR__ . '/project/public';
if ($path !== '/' && is_file($public . $path)) {
    return false;
}
$_SERVER['SCRIPT_FILENAME'] = $public . '/index.php';
$_SERVER['SCRIPT_NAME'] = '/index.php';
require $public . '/index.php';
