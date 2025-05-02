<?php

class GameRoutes {
    private $controller;

    public function __construct() {
        try {
            require_once __DIR__ . '/../config/Database.php';
            require_once __DIR__ . '/../models/Game.php';
            require_once __DIR__ . '/../services/GameService.php';
            require_once __DIR__ . '/../controllers/GameController.php';
            require_once __DIR__ . '/../helpers/ResponseHandler.php';

            $database = new Database();
            $db = $database->getConnection();
            $gameModel = new Game($db);
            $gameService = new GameService($gameModel);
            $this->controller = new GameController($gameService);
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
        $idPlayer = isset($uri[3]) ? $uri[3] : null;
        
        
        try {
            switch ($method) {
                case 'POST':
                    if ($route == "new-maze") {
                        $this->controller->newGame();
                    }else if($route == "move") {
                        $this->controller->movePlayer();
                    }else if($route == "reset") {
                        $this->controller->resetGame();
                    }
                    break;

                case 'GET':
                        if ($route == "status") {
                            $this->controller->statusGame($idPlayer);
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