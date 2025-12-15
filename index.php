<?php
// Router principal
session_start();

// Charger Database en premier (OBLIGATOIRE)
require_once __DIR__ . '/config/database.php';

// Autoloader simple pour le reste
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

// Router avec IF
if ($request === '/' || $request === '/batches' || $request === '') {
    $controller = new BatchController();
    $controller->index();
    
} elseif ($request === '/batches/create') {
    $controller = new BatchController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->store();
    } else {
        $controller->create();
    }
    
} elseif (preg_match('/^\/batches\/(\d+)$/', $request, $matches)) {
    $controller = new BatchController();
    $controller->show($matches[1]);
    
} elseif (preg_match('/^\/batches\/delete\/(\d+)$/', $request, $matches)) {
    $controller = new BatchController();
    $controller->delete($matches[1]);
    
} elseif (preg_match('/^\/websites\/create\/(\d+)$/', $request, $matches)) {
    $controller = new WebsiteController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->store($matches[1]);
    } else {
        $controller->create($matches[1]);
    }
    
} elseif (preg_match('/^\/websites\/edit\/(\d+)$/', $request, $matches)) {
    $controller = new WebsiteController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->update($matches[1]);
    } else {
        $controller->edit($matches[1]);
    }
    
} elseif (preg_match('/^\/websites\/delete\/(\d+)$/', $request, $matches)) {
    $controller = new WebsiteController();
    $controller->delete($matches[1]);
    
} elseif (preg_match('/^\/websites\/check\/(\d+)$/', $request, $matches)) {
    $controller = new WebsiteController();
    $controller->checkOne($matches[1]);
    
} elseif (preg_match('/^\/batches\/checkall\/(\d+)$/', $request, $matches)) {
    $controller = new WebsiteController();
    $controller->checkAll($matches[1]);
    
} else {
    http_response_code(404);
    echo "404 - Page non trouvée";
}