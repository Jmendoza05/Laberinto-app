<?php
class GameController {
    private $gameService;

    public function __construct(GameService $gameService) {
        $this->gameService = $gameService;
    }
    public function newGame() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (empty($data)) {
            ResponseHandler::sendError('Datos no proporcionados', 400);
        }
        
        $result = $this->gameService->newGame($data);
        
        if ($result['success']) {
            ResponseHandler::sendSuccess(
                $result['game'],
                'Juego nuevo creado exitosamente',
                201
            );
        } else {
            ResponseHandler::sendError(
                implode(', ', $result['errors']),
                400
            );
        }
    }
    public function statusGame($idPlayer) {
        $game = $this->gameService->statusGame($idPlayer);
        
        if ($game) {
            ResponseHandler::sendSuccess($game, 'Juego encontrado', 200);
        } else {
            ResponseHandler::sendError('Juego no encontrado', 404);
        }
    }
    public function movePlayer() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (empty($data)) {
            ResponseHandler::sendError('Datos no proporcionados', 400);
        }
        
        $result = $this->gameService->movePlayer($data);
        
        if ($result['success']) {
            ResponseHandler::sendSuccess(
                $result,
                'movimiento exitoso',
                201
            );
        } else {
            ResponseHandler::sendError(
                implode(', ', $result['errors']),
                400
            );
        }
    }
    public function resetGame() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (empty($data)) {
            ResponseHandler::sendError('Datos no proporcionados', 400);
        }
        
        $result = $this->gameService->resetGame($data);
        
        if ($result['success']) {
            ResponseHandler::sendSuccess(
                $result,
                'restablecimiento exitoso',
                201
            );
        } else {
            ResponseHandler::sendError(
                implode(', ', $result['errors']),
                400
            );
        }
    }
}