<?php
class AuthService {
    private $authModel;

    public function __construct(Auth $authModel) {
        $this->authModel = $authModel;
    }
    public function login($userData) { 

        $this->authModel->name = $userData['name'] ?? '';
        $this->authModel->email = $userData['email'] ?? '';
        
        $validationErrors = $this->authModel->validate();
        
        if (!empty($validationErrors)) {
            return [
                'success' => false,
                'errors' => $validationErrors
            ];
        }
        if ($this->authModel->login()) {
            return [
                'success' => true,
                'user' => [
                    'id' => $this->authModel->id,
                    'name' => $this->authModel->name,
                    'email' => $this->authModel->email
                ]
            ];
        }
        
        return [
            'success' => false,
            'errors' => ['No se encontro el usuario']
        ];
    }
    public function register($userData) { 

        $this->authModel->name = $userData['name'] ?? '';
        $this->authModel->email = $userData['email'] ?? '';

        $validationErrors = $this->authModel->validate();
        
        if (!empty($validationErrors)) {
            return [
                'success' => false,
                'errors' => $validationErrors
            ];
        }
        
        
        if ($this->authModel->register()) {
            return [
                'success' => true,
                'user' => [
                    'id' => $this->authModel->id,
                    'name' => $this->authModel->name,
                    'email' => $this->authModel->email
                ]
            ];
        }
        
        return [
            'success' => false,
            'errors' => ['No se pudo crear el usuario']
        ];
    }
}
?>