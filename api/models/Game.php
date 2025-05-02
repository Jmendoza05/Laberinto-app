<?php

class Game {
    private $conn;
    private $table = 'laberintos';

    public $idGame;
    public $size;
    public $idPlayer;
    public $status_game;
    public $playerPosition;
    public $position_goals;
    public $player_position_initial;
    public $game;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function newGame() {
        $queryIsCreated = "SELECT * FROM " . $this->table . " WHERE id_player = :id_player AND status_game = :status_Game";
        $stmtIsCreated = $this->conn->prepare($queryIsCreated);

        $this->idPlayer = htmlspecialchars(strip_tags($this->idPlayer));
        $this->status_game = htmlspecialchars(strip_tags($this->status_game));
        $stmtIsCreated->bindParam(':id_player', $this->idPlayer);
        $stmtIsCreated->bindParam(':status_Game', $this->status_game);
        $stmtIsCreated->execute();
        $isGame = $stmtIsCreated->fetch(PDO::FETCH_ASSOC);

        if (!$isGame) {
            $query = "INSERT INTO " . $this->table . " (size,maze,player_position,id_player,status_game,player_position_initial,position_goals) VALUES (:size,:maze,:player_position,:id_player,:status_game,:player_position_initial,:position_goals)";
            $stmt = $this->conn->prepare($query);
            $this->size = htmlspecialchars(strip_tags($this->size));
            $this->game = htmlspecialchars(strip_tags($this->game));
            $this->playerPosition = htmlspecialchars(strip_tags($this->playerPosition));
            $this->idPlayer = htmlspecialchars(strip_tags($this->idPlayer));
            $this->status_game = htmlspecialchars(strip_tags($this->status_game));
            $this->player_position_initial = htmlspecialchars(strip_tags($this->player_position_initial));
            $this->position_goals = htmlspecialchars(strip_tags($this->position_goals));
            
            $stmt->bindParam(':size', $this->size);
            $stmt->bindParam(':maze', $this->game);
            $stmt->bindParam(':player_position', $this->playerPosition);
            $stmt->bindParam(':id_player', $this->idPlayer);
            $stmt->bindParam(':status_game', $this->status_game);
            $stmt->bindParam(':player_position_initial', $this->player_position_initial);
            $stmt->bindParam(':position_goals', $this->position_goals);

            if ($stmt->execute()) {
                $this->idGame = $this->conn->lastInsertId();
                return true;
            }
        }
        return false;
    }
    public function statusGame() {
        $queryIsCreated = "SELECT * FROM " . $this->table . " WHERE id_player = :id_player AND status_game = :status_Game";
        $stmtIsCreated = $this->conn->prepare($queryIsCreated);
        
        $this->idPlayer = htmlspecialchars(strip_tags($this->idPlayer));
        $this->status_game = htmlspecialchars(strip_tags($this->status_game));
        $stmtIsCreated->bindParam(':id_player', $this->idPlayer);
        $stmtIsCreated->bindParam(':status_Game', $this->status_game);
        $stmtIsCreated->execute();
        $isGame = $stmtIsCreated->fetch(PDO::FETCH_ASSOC);

        if ($isGame) {      
            $this->idGame = $isGame['id'];
            $this->size = $isGame['size'];
            $this->game = $isGame['maze'];
            $this->playerPosition = $isGame['player_position'];
            $this->idPlayer = $isGame['id_player'];
            $this->status_game = $isGame['status_game'];
            $this->player_position_initial = $isGame['player_position_initial'];
            $this->position_goals = $isGame['position_goals'];            
            return true;
        }
        
        return false;
    }
    public function getGameById($id_game) {
        $queryIsCreated = "SELECT * FROM " . $this->table . " WHERE id = :idGame";
        $stmtIsCreated = $this->conn->prepare($queryIsCreated);

        $stmtIsCreated->bindParam(':idGame', $id_game);
        $stmtIsCreated->execute();
        $isGame = $stmtIsCreated->fetch(PDO::FETCH_ASSOC);

        if ($isGame) {      
            $this->idGame = $isGame['id'];
            $this->size = $isGame['size'];
            $this->game = $isGame['maze'];
            $this->playerPosition = $isGame['player_position'];
            $this->idPlayer = $isGame['id_player'];
            $this->status_game = $isGame['status_game'];
            $this->player_position_initial = $isGame['player_position_initial'];
            $this->position_goals = $isGame['position_goals'];            
            return true;
        }
        
        return false;
    }
    public function upDatePositionPlayer() {
        $queryIsCreated = "UPDATE " . $this->table . " SET maze = :newMaze, player_position = :new_player_position WHERE id = :id_game";
        $stmtIsCreated = $this->conn->prepare($queryIsCreated);
        
        $stmtIsCreated->bindParam(':id_game', $this->idGame);
        $stmtIsCreated->bindParam(':newMaze', $this->game);
        $stmtIsCreated->bindParam(':new_player_position', $this->playerPosition);

        if ($stmtIsCreated->execute()) {            
            return true;
        }
        
        return false;
    }
    public function resetGame() {
        $queryIsCreated = "UPDATE " . $this->table . " SET maze = :newMaze, player_position = :new_player_position WHERE id = :id_game";
        $stmtIsCreated = $this->conn->prepare($queryIsCreated);
        
        $stmtIsCreated->bindParam(':id_game', $this->idGame);
        $stmtIsCreated->bindParam(':newMaze', $this->game);
        $stmtIsCreated->bindParam(':new_player_position', $this->playerPosition);
        $stmtIsCreated->bindParam(':id_game', $this->idGame);

        if ($stmtIsCreated->execute()) {            
            return true;
        }
        
        return false;
    }
    
    public function validate() {
        $errors = [];
        
        if (empty($this->size)) {
            $errors[] = "El tano del juego es obligatorio";
        }
        
        return $errors;
    }
}