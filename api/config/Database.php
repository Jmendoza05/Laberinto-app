<?php

class Database {
private $dsn = 'pgsql:host=localhost;dbname=escape_laberinto';
private $username = 'postgres';
private $password = 'Juan12345';
private $conn = null;
public function getConnection() { 
try {
    if ($this->conn === null) {
        $this->conn = new PDO($this->dsn, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
return $this->conn;
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    die();
}
}
}
?>