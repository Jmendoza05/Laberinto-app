<?php
/**
 * Clase para manejar respuestas HTTP en formato JSON
 * 
 * @author Claude
 */
class ResponseHandler {
    /**
     * Envía una respuesta JSON con código HTTP
     * 
     * @param mixed $data Los datos a enviar en formato JSON
     * @param int $statusCode Código de estado HTTP
     * @return void
     */
    public static function sendResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
    
    /**
     * Envía una respuesta de error en formato JSON
     * 
     * @param string $message Mensaje de error
     * @param int $statusCode Código de estado HTTP
     * @return void
     */
    public static function sendError($message, $statusCode = 500) {
        http_response_code($statusCode);
        echo json_encode(['error' => $message]);
        exit;
    }
    
    /**
     * Envía una respuesta de éxito en formato JSON
     * 
     * @param mixed $data Los datos a enviar
     * @param string $message Mensaje de éxito
     * @param int $statusCode Código de estado HTTP
     * @return void
     */
    public static function sendSuccess($data, $message = '', $statusCode = 200) {
        $response = [
            'status' => 'success',
            'data' => $data
        ];
        
        if (!empty($message)) {
            $response['message'] = $message;
        }
        
        http_response_code($statusCode);
        echo json_encode($response);
        exit;
    }
}
?>