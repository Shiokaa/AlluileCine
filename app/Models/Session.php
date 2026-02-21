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
            return ResponseHandler::format(true, 'Succès', $startEvent);
        } catch (PDOException $e) {
            return ResponseHandler::format(false, $e->getMessage());
        }
    }
    
    public function create(int $movieId, int $roomId, string $startEvent)
    {
        $sql = "INSERT INTO sessions (movie_id, room_id, start_event) VALUES (?, ?, ?)";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$movieId, $roomId, $startEvent]);

            return ResponseHandler::format(true, 'Séance créée avec succès !');
        } catch (PDOException $e) {
            return ResponseHandler::format(false, $e->getMessage());
        }
    }

    public function getMovieSessionsDetails(int $movieId)
    {
        $sql = "SELECT s.id, s.start_event, r.name as room_name 
                FROM sessions s 
                LEFT JOIN rooms r ON s.room_id = r.id 
                WHERE s.movie_id = ? 
                ORDER BY s.start_event ASC";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$movieId]);
            $sessions = $statement->fetchAll();

            return ResponseHandler::format(true, 'Succès', $sessions);
        } catch (PDOException $e) {
            return ResponseHandler::format(false, $e->getMessage());
        }
    }

    public function checkExists(int $roomId, string $startEvent)
    {
        $sql = "SELECT COUNT(*) as count FROM sessions WHERE room_id = ? AND start_event = ?";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$roomId, $startEvent]);
            $result = $statement->fetch();

            return ResponseHandler::format(true, 'Succès', $result['count'] > 0);
        } catch (PDOException $e) {
            return ResponseHandler::format(false, $e->getMessage());
        }
    }
}

?>