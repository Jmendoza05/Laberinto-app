<?php
class AuthController {
    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login() {
        $body = json_decode(file_get_contents("php://input"), true);
        if (empty($body)) {
            ResponseHandler::sendError('Datos no proporcionados', 400);
        }
        $user = $this->authService->login($body);
        if ($user['success']) {
            ResponseHandler::sendSuccess(
                $user['user'],
                'Logueado exitosamente',
                200
            );
        } else {
            ResponseHandler::sendError('Usuario no encontrado', 404);
        }
    }
    
    public function register() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (empty($data)) {
            ResponseHandler::sendError('Datos no proporcionados', 400);
        }
        
        $result = $this->authService->register($data);
        
        if ($result['success']) {
            ResponseHandler::sendSuccess(
                $result['user'],
                'Usuario creado con éxito',
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