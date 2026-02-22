<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use Helpers\ResponseHandler;
use PDOException;

class Reservation {
    private PDO $pdo;

    /** Constructeur de la class Reservation
     * Initialise la connexion à la base de données
     */
    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }

    /** Crée une nouvelle réservation
     *
     * @param int $userId Id de l'utilisateur.
     * @param int $sessionId Id de la séance.
     * @param int $seatId Id du siège.
     * @return array Retourne la réponse formatée.
     */
    public function create(int $userId, int $sessionId, int $seatId): array
    {
        // Élaboration de la requête SQL d'insertion de la réservation
        $sql = "INSERT INTO reservations (user_id, session_id, seat_id) VALUES (?, ?, ?)";

        try {
            // Préparation de l'expression SQL via PDO
            $statement = $this->pdo->prepare($sql);
            
            // Exécution et sauvegarde des clés associées
            $statement->execute([$userId, $sessionId, $seatId]);

            // Renvoi de la confirmation d'enregistrement positif
            return ResponseHandler::format(true, 'Réservation confirmée avec succès !');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            // Transfert de l'erreur interceptée
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }

    /** Récupère les réservations d'un utilisateur
     *
     * @param int $userId Id de l'utilisateur.
     * @return array Retourne les réservations formatées.
     */
    public function findByUserId(int $userId): array
    {
        // Spécification de la requête de jointure ciblée sur un seul utilisateur
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
            error_log($e->getMessage());
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }
}
