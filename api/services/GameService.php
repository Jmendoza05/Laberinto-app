<?php
class GameService {
    private $gameModel;
    private $helpers;    
    
    public function __construct(Game $gameModel) {
        require_once __DIR__ . '/../helpers/GameHelper.php';
        $this->gameModel = $gameModel;
    }
    public function newGame($userData) {
        $this->helpers = new GameHelper($userData['size']);

        $this->gameModel->size = $userData['size'] ?? '';
        $this->gameModel->idPlayer = $userData['id_player'] ?? '';
        $this->gameModel->status_game = $userData['status_game'] ?? 'playing';
        $this->gameModel->playerPosition = $this->helpers->placePlayer() ?? '';
        $this->gameModel->position_goals = $this->helpers->placeGoal() ?? '';
        $this->gameModel->player_position_initial = $this->gameModel->playerPosition ?? '';
        $this->gameModel->game = $this->helpers->convertFromFormatToSql($this->helpers->getMaze()) ?? '';

        $validationErrors = $this->gameModel->validate();
        
        if (!empty($validationErrors)) {
            return [
                'success' => false,
                'errors' => $validationErrors
            ];
        }
        
        
        if ($this->gameModel->newGame()) {
            return [
                'success' => true,
                'game' => [
                    'id' => $this->gameModel->idGame,
                    'size' => $this->gameModel->size,
                    'game' => $this->gameModel->game,
                    'playerPosition' => $this->gameModel->playerPosition,
                    'idPlayer' => $this->gameModel->idPlayer,
                    'status_game' => $this->gameModel->status_game,
                    'player_position_initial' => $this->gameModel->player_position_initial,
                    'position_goals' => $this->gameModel->position_goals
                ]
            ];
        }
        
        return [
            'success' => false,
            'errors' => ['No se pudo crear el juego']
        ];
    }
    public function statusGame($idPlayer) {
        require_once __DIR__ . '/../helpers/GameHelper.php';
        $this->gameModel->idPlayer = $idPlayer ?? '';
        $this->gameModel->status_game = 'playing';
        if ($this->gameModel->statusGame()) {
            return [
                    'id' => $this->gameModel->idGame,
                    'size' => $this->gameModel->size,
                    'game' => $this->gameModel->game,
                    'playerPosition' => $this->gameModel->playerPosition,
                    'idPlayer' => $this->gameModel->idPlayer,
                    'status_game' => $this->gameModel->status_game,
                    'player_position_initial' => $this->gameModel->player_position_initial,
                    'position_goals' => $this->gameModel->position_goals
            ];
        }
        
        return [
            'status'=> "error",
            'message'=> "Juego no encontrado"
        ];
    }
    public function movePlayer($data) {
        $id_game = $data['id_game'];
        $direction = $data['direction'];         
        $isGameExist = $this -> getGameById($id_game);
        $this->helpers = new GameHelper($isGameExist['size']);
        $resultMovePlayer = $this->helpers->moverPlayer($isGameExist['game'], $direction);
        if ($this->upDatePositionPlayer($isGameExist['id'], $this->helpers->convertFromFormatToSql($resultMovePlayer[0][0]),$resultMovePlayer[0][1])) {
            return [
                'success' => true
            ];
        }
        
        return [
            'success' => false,
            'errors' => ['No se pude mover el jugador']
        ];
    }
    public function getGameById($idGame) {
        if ($this->gameModel->getGameById($idGame)) {
            return [
                    'id' => $this->gameModel->idGame,
                    'size' => $this->gameModel->size,
                    'game' => $this->gameModel->game,
                    'playerPosition' => $this->gameModel->playerPosition,
                    'idPlayer' => $this->gameModel->idPlayer,
                    'status_game' => $this->gameModel->status_game,
                    'player_position_initial' => $this->gameModel->player_position_initial,
                    'position_goals' => $this->gameModel->position_goals
            ];
        }
        
        return null;
    }
    public function resetGame($data) {
        $id_game = $data['id_game'];         
        $isGameExist = $this -> getGameById($id_game);
        $this->helpers = new GameHelper($isGameExist['size']);
        $resultMovePlayer = $this->helpers->resetGame($isGameExist);
        $this->gameModel->idGame = $id_game ?? null;
        $this->gameModel->game = $resultMovePlayer['game'] ?? '';
        $this->gameModel->playerPosition = $resultMovePlayer['playerPosition'] ?? '';
        if ($this->gameModel->resetGame()) {
            return [
                'success' => true
            ];
        }
        
        return [
            'success' => false,
            'errors' => ['No se pude mover el jugador']
        ];
    }
    private function upDatePositionPlayer($idGame ,$game, $playerPosition) {
        $this->gameModel->idGame = $idGame ?? '';
        $this->gameModel->game = $game ?? '';
        $this->gameModel->playerPosition = $playerPosition ?? '';
        if ($this->gameModel->upDatePositionPlayer()) {
            return true;
        }
        
        return null;
    }
    
}
?>