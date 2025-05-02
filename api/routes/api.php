<?php

require_once('../controllers/GameController.php');
require_once('../controllers/RankingController.php');

$gameController = new GameController();
$rankingController = new RankingController();

// Rutas del juego
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] == '/api/new-maze') {
    $gameController->newMaze();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] == '/api/move') {
    $direction = json_decode(file_get_contents('php://input'), true)['direction'];
    $gameController->movePlayer($direction);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] == '/api/status') {
    $gameController->status();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] == '/api/reset') {
    $gameController->reset();
}

// Rutas de ranking y jugadores
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] == '/api/register') {
    $data = json_decode(file_get_contents('php://input'), true);
    $rankingController->register($data['name'], $data['email']);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] == '/api/ranking') {
    $rankingController->ranking();
}
?>
