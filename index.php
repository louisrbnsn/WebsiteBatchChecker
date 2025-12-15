<?php
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/helpers.php';

spl_autoload_register(function ($class) {
    foreach (['/models/', '/controllers/'] as $dir) {
        $path = __DIR__ . $dir . $class . '.php';
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

$request = $_SERVER['REQUEST_URI'];
$basePath = dirname($_SERVER['SCRIPT_NAME']);
if ($basePath !== '/') {
    $request = str_replace($basePath, '', $request);
}
$request = strtok($request, '?');
$method = $_SERVER['REQUEST_METHOD'];

$routes = [
    'GET /' => ['BatchController', 'index'],
    'GET /batches' => ['BatchController', 'index'],
    'GET /batches/create' => ['BatchController', 'create'],
    'POST /batches/create' => ['BatchController', 'store'],
    'GET /batches/(\d+)' => ['BatchController', 'show'],
    'GET /batches/delete/(\d+)' => ['BatchController', 'delete'],
    'GET /batches/checkall/(\d+)' => ['WebsiteController', 'checkAll'],
    'GET /websites/create/(\d+)' => ['WebsiteController', 'create'],
    'POST /websites/create/(\d+)' => ['WebsiteController', 'store'],
    'GET /websites/edit/(\d+)' => ['WebsiteController', 'edit'],
    'POST /websites/edit/(\d+)' => ['WebsiteController', 'update'],
    'GET /websites/delete/(\d+)' => ['WebsiteController', 'delete'],
    'GET /websites/check/(\d+)' => ['WebsiteController', 'checkOne'],
];

foreach ($routes as $route => $handler) {
    list($routeMethod, $pattern) = explode(' ', $route, 2);
    if ($routeMethod !== $method) continue;
    
    $hasRegex = strpos($pattern, '(') !== false;
    
    if (!$hasRegex && $pattern === $request) {
        $controller = new $handler[0]();
        $controller->{$handler[1]}();
        exit;
    }
    
    if ($hasRegex && preg_match('#^' . $pattern . '$#', $request, $matches)) {
        array_shift($matches);
        $controller = new $handler[0]();
        call_user_func_array([$controller, $handler[1]], $matches);
        exit;
    }
}

http_response_code(404);
echo "404 - Page non trouvée";