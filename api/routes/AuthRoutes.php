<?php

class AuthRoutes {
    private $controller;

    public function __construct() {
        try {
            require_once __DIR__ . '/../config/Database.php';
            require_once __DIR__ . '/../models/Auth.php';
            require_once __DIR__ . '/../services/AuthService.php';
            require_once __DIR__ . '/../controllers/AuthController.php';
            require_once __DIR__ . '/../helpers/ResponseHandler.php';

            $database = new Database();
            $db = $database->getConnection();
            $authModel = new Auth($db);
            $authService = new AuthService($authModel);
            $this->controller = new AuthController($authService);
        } catch (Exception $e) {

            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'error' => 'Error al inicializar rutas: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            exit;
        }
    }

    public function handleRequest() {

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', trim($uri, '/'));
        
        $route = isset($uri[2]) ? $uri[2] : null;
        
        
        try {
            switch ($method) {
                case 'POST':
                    if ($route == "login") {

                        $this->controller->login();
                    } else if ($route == "register") {
                        
                        $this->controller->register();
                    }
                    break;
                    
                default:
                    ResponseHandler::sendError('Método no soportado', 405);
                    break;
            }
        } catch (Exception $e) {
            ResponseHandler::sendError($e->getMessage(), 500);
        }
    }
}
?>