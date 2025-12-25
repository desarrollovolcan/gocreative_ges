<?php
require __DIR__ . '/app/bootstrap.php';

$routes = require __DIR__ . '/app/routes.php';
$route = $_GET['route'] ?? 'dashboard';

if (!isset($routes[$route])) {
    http_response_code(404);
    echo 'Ruta no encontrada';
    exit;
}

[$controllerName, $method] = $routes[$route];
$controller = new $controllerName($config, $db);
$controller->$method();
