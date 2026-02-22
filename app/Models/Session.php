<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use Helpers\ResponseHandler;
use PDOException;

class Session {
    private PDO $pdo;

    /** Constructeur de la class Session
     * Initialise la connexion à la base de données
     */
    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }

    /** Récupère les horaires de séance par film
     *
     * @param int $movieId Id du film.
     * @return array Retourne les horaires.
     */
    public function findStartEventByMovieId(int $movieId): array
    {
        // Détermination de la récupération de la chronologie des séances d'un film
        $sql = "SELECT id, start_event FROM sessions WHERE movie_id = ? ORDER BY start_event ASC";

        try {
            // Paramétrage sécuritaire de la lecture temporelle
            $statement = $this->pdo->prepare($sql);

            $statement->execute([$movieId]);

            // Retour local des informations validées
            $startEvent = $statement->fetchAll();

            // Sortie formelle en tant qu'objet validé
            return ResponseHandler::format(true, 'Succès', $startEvent);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }
    
    /** Crée une nouvelle séance
     *
     * @param int $movieId Id du film.
     * @param int $roomId Id de la salle.
     * @param string $startEvent Date et heure de début.
     * @return array Retourne un message.
     */
    public function create(int $movieId, int $roomId, string $startEvent): array
    {
        // Formatage de la demande de création avec allocation de la salle et de l'heure
        $sql = "INSERT INTO sessions (movie_id, room_id, start_event) VALUES (?, ?, ?)";

        try {
            // Consolidation de l'instruction et vérification du typage
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$movieId, $roomId, $startEvent]);

            // Validation du résultat constructif
            return ResponseHandler::format(true, 'Séance créée avec succès !');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }

    /** Récupère les détails des séances d'un film
     *
     * @param int $movieId Id du film.
     * @return array Retourne les détails complets des séances.
     */
    public function getMovieSessionsDetails(int $movieId): array
    {
        // Rédaction de la requête de récupération complète par jointure sur la salle
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
            error_log($e->getMessage());
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }

    /** Vérifie si une séance existe à la même heure dans la même salle
     *
     * @param int $roomId Id de la salle.
     * @param string $startEvent Date et heure.
     * @return array Retourne la validité.
     */
    public function checkExists(int $roomId, string $startEvent): array
    {
        // Conception de la vérification de l'existence d'une séance jumelle
        $sql = "SELECT COUNT(*) as count FROM sessions WHERE room_id = ? AND start_event = ?";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$roomId, $startEvent]);
            $result = $statement->fetch();

            return ResponseHandler::format(true, 'Succès', $result['count'] > 0);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }
    
    /** Récupère la salle liée à une séance
     *
     * @param int $sessionId Id de la séance.
     * @return int|null Retourne l'id de la salle.
     */
    public function getRoomId(int $sessionId): ?int
    {
        // Requête de pointage de la salle concernée
        $sql = "SELECT room_id FROM sessions WHERE id = ?";
        try {
            // Execution du paramètre sur la ligne visée
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$sessionId]);
            
            // Retour direct avec typage strict
            $result = $statement->fetch();
            return $result ? (int)$result['room_id'] : null;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}