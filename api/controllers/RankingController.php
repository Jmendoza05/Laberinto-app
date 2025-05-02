<?php

class RankingController {
    public function register($name, $email) {
        global $pdo;

        // Registro de un nuevo jugador
        $stmt = $pdo->prepare("INSERT INTO players (name, email, score) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, 0]);

        echo json_encode(['message' => 'Jugador registrado']);
    }

    public function ranking() {
        global $pdo;

        // Obtener el ranking de jugadores
        $stmt = $pdo->query("SELECT name, score FROM players ORDER BY score DESC");
        $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['ranking' => $players]);
    }
}
?>
