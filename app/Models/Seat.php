<?php

namespace App\Models;

use Helpers\ResponseHandler;
use PDOException;

class Seat {
    private $pdo;

    public function __construct($db)
    {
        $this->pdo = $db;
    }

    /**
     * Finds the first available seat in the room for a given session.
     * Checks room capacity against the number of existing reservations.
     * If capacity is not reached, finds the next available seat number,
     * ensures it exists in the `seats` table, and returns its ID.
     */
    public function findAvailableSeatId(int $sessionId, int $roomId)
    {
        try {
            // 1. Get Room capacity
            $capacityStmt = $this->pdo->prepare("SELECT capacity FROM rooms WHERE id = ?");
            $capacityStmt->execute([$roomId]);
            $capacityResult = $capacityStmt->fetch();
            if (!$capacityResult) {
                return ResponseHandler::format(false, "Salle introuvable.");
            }
            $capacity = (int)$capacityResult['capacity'];

            // 2. Count existing reservations for this session
            $countStmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM reservations WHERE session_id = ?");
            $countStmt->execute([$sessionId]);
            $countResult = $countStmt->fetch();
            $reservedCount = (int)$countResult['count'];

            // 3. Check if room is full
            if ($reservedCount >= $capacity) {
                return ResponseHandler::format(false, "Désolé, cette séance est complète.");
            }

            // 4. Find the first seat number (1 to capacity) that is NOT reserved
            $reservedSeatsStmt = $this->pdo->prepare("
                SELECT s.number 
                FROM reservations r
                JOIN seats s ON r.seat_id = s.id
                WHERE r.session_id = ?
            ");
            $reservedSeatsStmt->execute([$sessionId]);
            $reservedNumbers = $reservedSeatsStmt->fetchAll(\PDO::FETCH_COLUMN);

            $availableNumber = null;
            for ($i = 1; $i <= $capacity; $i++) {
                if (!in_array($i, $reservedNumbers)) {
                    $availableNumber = $i;
                    break;
                }
            }

            if ($availableNumber === null) {
                return ResponseHandler::format(false, "Désolé, cette séance est complète.");
            }

            // 5. Ensure this seat number exists in the seats table for this room, if not create it
            $seatStmt = $this->pdo->prepare("SELECT id FROM seats WHERE room_id = ? AND number = ?");
            $seatStmt->execute([$roomId, $availableNumber]);
            $seatResult = $seatStmt->fetch();

            if ($seatResult) {
                $seatId = $seatResult['id'];
            } else {
                $insertSeatStmt = $this->pdo->prepare("INSERT INTO seats (room_id, number) VALUES (?, ?)");
                $insertSeatStmt->execute([$roomId, $availableNumber]);
                $seatId = $this->pdo->lastInsertId();
            }

            return ResponseHandler::format(true, 'Siège disponible trouvé', $seatId);

        } catch (PDOException $e) {
            return ResponseHandler::format(false, "Erreur lors de la recherche du siège : " . $e->getMessage());
        }
    }
}
