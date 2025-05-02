<?php

class Auth {
    private $conn;
    private $table = 'jugadores';

     public $id;
     public $name;
     public $email;

     public function __construct($db) {
        $this->conn = $db;
    }
    public function login() {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(':email', $this->email);
        
        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $user['id'];
            $this-> name = $user['name'];
            $this-> email = $user['email'];
            return true;
        }
        
        return false;
    }
    public function register() {
        $queryIsCreated = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmtIsCreated = $this->conn->prepare($queryIsCreated);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmtIsCreated->bindParam(':email', $this->email);
        $stmtIsCreated->execute();
        $user = $stmtIsCreated->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $query = "INSERT INTO " . $this->table . " (name, email) VALUES (:name, :email)";
            $stmt = $this->conn->prepare($query);

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);

            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }
        }
        
        return false;
    }

    public function validate() {
        $errors = [];
        
        if (empty($this->name)) {
            $errors[] = "El nombre es obligatorio";
        }
        
        if (empty($this->email)) {
            $errors[] = "El email es obligatorio";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Formato de email inválido";
        }
        
        return $errors;
    }
}