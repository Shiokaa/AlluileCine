<?php

namespace App\Models;

use Helpers\ResponseHandler;
use PDOException;

class Movie {
    private $pdo;

    /** * Constructeur de la class Movie
     */
    public function __construct($db)
    {
        $this->pdo = $db;
    }

    /** * Récupère tous les films de la base de données.
    *
    * @return array Retourne la réponse.
    */
    public function findAll(): array
    {
        // Création de la query pour récupérer tous les films
        $sql = 'SELECT * FROM movies';

        try {
            // Prépare la requête
            $statement = $this->pdo->prepare($sql);

            // Exécute la requête
            $statement->execute();

            // Récupère tous les résultats
            $movies = $statement->fetchAll();

            // Retourne la réponse à true avec un message de succès
            return ResponseHandler::format('true', 'Succès', $movies);
        } catch (PDOException $e) {
            // Retourne la réponse à false avec le message d'erreur
            return ResponseHandler::format('false', $e->getMessage());
        }
    }

}

?>