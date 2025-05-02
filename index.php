<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'autoload.php';
    $urlRequest = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $urlRequest = rtrim($urlRequest, '/');
    $urlRequest = str_replace('/Juegodellaberinto', '', $urlRequest);
    $urlRequest = explode('/', trim($urlRequest, '/'));

$urlRequest = isset($urlRequest[1]) ? $urlRequest[1] : '';

switch ($urlRequest) {
    case 'login':
            require_once 'api/routes/AuthRoutes.php';
            $router = new AuthRoutes();
            $router->handleRequest();
            break;
    case 'register':
            require_once 'api/routes/AuthRoutes.php';
            $router = new AuthRoutes();
            $router->handleRequest();
            break;
    case 'new-maze':
            require_once 'api/routes/GameRoutes.php';
            $router = new GameRoutes();
            $router->handleRequest();
            break;
    case 'status':
            require_once 'api/routes/GameRoutes.php';
            $router = new GameRoutes();
            $router->handleRequest();
            break;
    case 'move':
            require_once 'api/routes/GameRoutes.php';
            $router = new GameRoutes();
            $router->handleRequest();
            break;               
    case 'reset':
            require_once 'api/routes/GameRoutes.php';
            $router = new GameRoutes();
            $router->handleRequest();
            break;  
    default:
        http_response_code(404);
        echo $urlRequest[1];
        echo json_encode(['error' => 'Recurso no encontrado']);
        break;
}
?>