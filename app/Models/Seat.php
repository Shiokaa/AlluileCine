<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use Helpers\ResponseHandler;
use PDOException;

class Seat {
    private PDO $pdo;

    /** Constructeur de la class Seat
     */
    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }

    /** Permet de trouver un siège disponible et obtenir son Id
     *
     * @param int $sessionId Id de la séance.
     * @param int $roomId Id de la salle.
     * @return array Retourne la réponse contenant l'id du siège.
     */
    public function findAvailableSeatId(int $sessionId, int $roomId): array
    {
        try {
            // Requête isolant la jauge théorique maximale de la salle ciblée
            $capacityStmt = $this->pdo->prepare("SELECT capacity FROM rooms WHERE id = ?");
            $capacityStmt->execute([$roomId]);
            $capacityResult = $capacityStmt->fetch();
            if (!$capacityResult) {
                return ResponseHandler::format(false, "Salle introuvable.");
            }
            $capacity = (int)$capacityResult['capacity'];

            // Dénombrement exact des places déjà validées sur l'ensemble de la séance
            $countStmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM reservations WHERE session_id = ?");
            $countStmt->execute([$sessionId]);
            $countResult = $countStmt->fetch();
            $reservedCount = (int)$countResult['count'];

            // Interruption prématurée du flux d'achat si le seuil capacitaire est atteint
            if ($reservedCount >= $capacity) {
                return ResponseHandler::format(false, "Désolé, cette séance est complète.");
            }

            // Extraction ciblée de la liste des numéros matricules de sièges déjà pris
            $reservedSeatsStmt = $this->pdo->prepare("
                SELECT s.number 
                FROM reservations r
                JOIN seats s ON r.seat_id = s.id
                WHERE r.session_id = ?
            ");
            $reservedSeatsStmt->execute([$sessionId]);
            $reservedNumbers = $reservedSeatsStmt->fetchAll(\PDO::FETCH_COLUMN);

            // Balayage itératif permettant de repérer le premier siège rendu libre physiquement
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

            // Contrôle croisé validant que la base liste bien le siège concerné ou forçage de sa création
            $seatStmt = $this->pdo->prepare("SELECT id FROM seats WHERE room_id = ? AND number = ?");
            $seatStmt->execute([$roomId, $availableNumber]);
            $seatResult = $seatStmt->fetch();

            // Rapprochement avec le schéma relationnel de la collection
            if ($seatResult) {
                $seatId = $seatResult['id'];
            } else {
                $insertSeatStmt = $this->pdo->prepare("INSERT INTO seats (room_id, number) VALUES (?, ?)");
                $insertSeatStmt->execute([$roomId, $availableNumber]);
                $seatId = $this->pdo->lastInsertId();
            }

            return ResponseHandler::format(true, 'Siège disponible trouvé', $seatId);

        } catch (PDOException $e) {
            error_log($e->getMessage());
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }
}
