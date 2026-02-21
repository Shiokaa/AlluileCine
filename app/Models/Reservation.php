<?php

namespace App\Models;

use Helpers\ResponseHandler;
use PDOException;
use PDO;

class Reservation {
    private $pdo;

    public function __construct($db)
    {
        $this->pdo = $db;
    }

    public function create(int $userId, int $sessionId, int $seatId)
    {
        $sql = "INSERT INTO reservations (user_id, session_id, seat_id) VALUES (?, ?, ?)";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$userId, $sessionId, $seatId]);

            return ResponseHandler::format(true, 'Réservation confirmée avec succès !');
        } catch (PDOException $e) {
            return ResponseHandler::format(false, "Erreur lors de la réservation : " . $e->getMessage());
        }
    }

    public function findByUserId(int $userId)
    {
        $sql = "
            SELECT 
                r.id as reservation_id,
                r.created_at as reserved_at,
                s.start_event as session_date,
                m.title as movie_title,
                m.cover_image,
                m.duration,
                rm.name as room_name,
                st.number as seat_number
            FROM reservations r
            JOIN sessions s ON r.session_id = s.id
            JOIN movies m ON s.movie_id = m.id
            JOIN seats st ON r.seat_id = st.id
            JOIN rooms rm ON st.room_id = rm.id
            WHERE r.user_id = ?
            ORDER BY s.start_event DESC
        ";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$userId]);
            $reservations = $statement->fetchAll(PDO::FETCH_ASSOC);

            return ResponseHandler::format(true, 'Succès', $reservations);
        } catch (PDOException $e) {
            return ResponseHandler::format(false, $e->getMessage());
        }
    }
}
