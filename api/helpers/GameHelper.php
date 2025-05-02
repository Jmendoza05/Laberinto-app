<?php
class GameHelper{
    private $size;
    private $maze;
    private $position_player;
    private $position_goal;

    public function __construct($size){
        $this->size = $size;
        $this->maze = $this->initializeMaze();
    }
    private function initializeMaze(){
        $maze = [];
        for ($i = 0; $i < $this->size; $i++) {
            for ($j = 0; $j < $this->size; $j++) {
                $maze[$i][$j] = 1;
            }
        }
        return $maze;
    }

    public function placeGoal(){
        do {
            $row = rand(0, $this->size - 1);
            $col = rand(0, $this->size - 1);
        } while ($this->maze[$row][$col] === 3);

        $this->maze[$row][$col] = 2;
        $this->position_goal = [$row,$col];
        return "(". $row.",".$col.")";
    }

    public function placePlayer(){
        do {
            $row = rand(0, $this->size - 1);
            $col = rand(0, $this->size - 1);
        } while ($this->maze[$row][$col] === 2);

        $this->maze[$row][$col] = 3;
        $this->position_player = [$row,$col];
        return "(" . $row . "," . $col . ")";
    }

    public function fillWalls(){
        $directions = [[-1, 0], [1, 0], [0, -1], [0, 1]];
        $this->markNearby($this->position_player, $directions);
        $this->markNearby($this->position_goal, $directions);
        for ($i = 0; $i < $this->size; $i++) {
            for ($j = 0; $j < $this->size; $j++) {
                if ($this->maze[$i][$j] !== 2 && $this->maze[$i][$j] !== 3) {
                    if (rand(0, 1) === 1) {
                        $this->maze[$i][$j] = 0;
                    }
                }
            }
        }
    }
    public function getMaze(){
        return $this->maze;
    }
    private function markNearby($position, $directions) {
        list($x, $y) = $position;
        foreach ($directions as $dir) {
            $newX = $x + $dir[0];
            $newY = $y + $dir[1];
            if ($newX >= 0 && $newX < $this->size && $newY >= 0 && $newY < $this->size) {
                $this->maze[$newX][$newY] = 0;
            }
        }
    }
    public function convertFromFormatToSql($game){
        $newGameFormat = '';
        foreach ($game as $fila) {
            $newGameFormat .= '{' . implode(',', $fila) . '},';
        }
        return '{' . rtrim($newGameFormat, ',') . '}';
    }
    public function convertFromSqlToFormat($game) {
        $game = json_encode($game);
        $game = trim($game, '{}');
        $filas = explode('},{', $game);
        $gameFormat = [];
        foreach ($filas as $fila) {
            $gameFormat[] = array_map('intval', explode(',', $fila));
        }
    
        return $gameFormat;
    }
    private function searchPositionPlayerInGame($game, $characterPlayer) {
        foreach ($game as $i => $fila) {
            foreach ($fila as $j => $elem) {
                if ($elem == $characterPlayer) {
                    return [$i, $j];
                }
            }
        }
        return null;
    }
    public function moverPlayer($game, $direction) {
        $gameConvert = $this->convertFromSqlToFormat($game);
        $newPositionPlayer = "";
        list($x, $y) = $this-> searchPositionPlayerInGame($gameConvert, 3);
        $valueReplaced = rand(0, 1);
        switch($direction) {
            case 'derecha':
                if ($y < count($gameConvert) - 1) {
                    $gameConvert[$x][$y] = $valueReplaced;
                    $gameConvert[$x][$y + 1] = 3;
                    $newPositionPlayer = "(".$x.",".($y + 1).")";
                }
                break;
            case 'izquierda':
                if ($y > 0) {
                    $gameConvert[$x][$y] = $valueReplaced;
                    $gameConvert[$x][$y - 1] = 3;
                    $newPositionPlayer = "(".$x.",".($y - 1).")";
                }
                break;
            case 'arriba':
                if ($x > 0) {
                    $gameConvert[$x][$y] = $valueReplaced;
                    $gameConvert[$x - 1][$y] = 3;
                    $newPositionPlayer = "(".($x - 1).",".$y.")";
                }
                break;
            case 'abajo':
                if ($x < count($gameConvert) - 1) {
                    $gameConvert[$x][$y] = $valueReplaced;
                    $gameConvert[$x + 1][$y] = 3;
                    $newPositionPlayer = "(".($x + 1).",".$y.")";
                }
                break;
            default:
                echo "Dirección inválida.";
                break;
        }
        return [[$gameConvert,$newPositionPlayer]];
    }
    public function resetGame($game){
        $game['game'] = $this->convertFromSqlToFormat($game['game']);
        list($x_current_position, $y_current_position) = $this-> searchPositionPlayerInGame($game['game'], 3);
        $position_inicial = $game['player_position_initial'];
        $position_inicial = trim($position_inicial, '()');
        list($x_initial_position, $y_initial_position) = explode(',', $position_inicial);
        $valueReplaced = rand(0, 1);
        $game['game'][$x_current_position][$y_current_position] = $valueReplaced;
        $game['game'][$x_initial_position][$y_initial_position] = 3;
        $game['game'] = $this->convertFromFormatToSql($game['game']);
        $game['playerPosition'] = $game['player_position_initial'];
        return $game;
    }
}
?>