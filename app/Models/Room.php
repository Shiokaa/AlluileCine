<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use Helpers\ResponseHandler;
use PDOException;

class Room {
    private PDO $pdo;

    /** Constructeur de la class Room
     */
    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }

    /** Récupère toutes les salles de cinéma
     *
     * @return array Retourne la réponse contenant les salles.
     */
    public function findAll(): array
    {
        // Définition de la requête d'extraction complète des salles
        $sql = "SELECT id, name, capacity FROM rooms";

        try {
            // Préparation de la requête sur le modèle
            $statement = $this->pdo->prepare($sql);
            
            // Appel et exécution sur la base de données
            $statement->execute();
            
            // Rapatriement local de l'ensemble des résultats
            $rooms = $statement->fetchAll();

            // Encapsulation et renvoi structuré des salles trouvées
            return ResponseHandler::format(true, 'Succès', $rooms);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }
}
