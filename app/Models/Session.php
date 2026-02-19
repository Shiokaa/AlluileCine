<?php

namespace App\Models;

use Helpers\ResponseHandler;
use PDOException;

class Session {
    private $pdo;

    public function __construct($db)
    {
        $this->pdo = $db;
    }

    public function findStartEventByMovieId(int $movieId)
    {
        $sql = "SELECT id, start_event FROM sessions WHERE movie_id = ? ORDER BY start_event ASC";

        try {
            // Prépare la requête
            $statement = $this->pdo->prepare($sql);

            $statement->execute([$movieId]);

            $startEvent = $statement->fetchAll();

            // Retourne la réponse à true avec une message de succès
            return ResponseHandler::format('true', 'Succès', $startEvent);
        } catch (PDOException $e) {
            return ResponseHandler::format('false', $e->getMessage());
        }
    }
}

?>