<?php
// Router principal
session_start();

// Charger les configurations
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/helpers.php';

// Autoloader simple
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/models/' . $class . '.php',
        __DIR__ . '/controllers/' . $class . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Récupérer l'URL
$request = $_SERVER['REQUEST_URI'];
$basePath = dirname($_SERVER['SCRIPT_NAME']);
if ($basePath !== '/') {
    $request = str_replace($basePath, '', $request);
}
$request = strtok($request, '?');
$method = $_SERVER['REQUEST_METHOD'];

// Table de routage
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

// Matcher les routes
foreach ($routes as $route => $handler) {
    list($routeMethod, $pattern) = explode(' ', $route, 2);
    
    if ($routeMethod !== $method) {
        continue;
    }
    
    // Route exacte
    if ($pattern === $request) {
        $controller = new $handler[0]();
        $controller->{$handler[1]}();
        exit;
    }
    
    // Route avec regex
    if (preg_match('#^' . $pattern . '$#', $request, $matches)) {
        array_shift($matches); // Enlever le match complet
        $controller = new $handler[0]();
        call_user_func_array([$controller, $handler[1]], $matches);
        exit;
    }
}

// 404
http_response_code(404);
echo "404 - Page non trouvée";