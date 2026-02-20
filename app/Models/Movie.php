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

    public function findById(int $id) : array
    {
        $sql = 'SELECT * FROM movies WHERE id = ?';
        
        try {
            
            $statement = $this->pdo->prepare($sql);

            $statement->execute([$id]);

            $movie = $statement->fetch();

            return ResponseHandler::format('true', 'Succès', $movie);
        }catch(PDOException $e) {
            // Retourne la réponse à false avec le message d'erreur
            return ResponseHandler::format('false', $e->getMessage());
        }
    }
    public function delete(int $id): array
    {
        $sql = "DELETE FROM movies WHERE id = ?";

        try {

            $statement = $this->pdo->prepare($sql);

            $statement->execute([$id]);

            return ResponseHandler::format(true, 'Succès', $statement->fetch());

        }
        catch (PDOException $e) {
            // Retourne la réponse à false avec une message d'erreur
            return ResponseHandler::format(false, 'Erreur : ' . $e->getMessage());
        }
    }
    public function create(string $title,string $description,string $genre,string $director,string $casting,string $duration,string $cover_image,string $release_date) {

        $sql = 'INSERT INTO users (title, description, genre, director, genre, director, casting, duration, cover_image, release_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        try {
            // Prépare la requête
            $statement = $this->pdo->prepare($sql);

            // Exécute la requête préparé via les données envoyées
            $statement->execute([$title, $description, $genre, $director, $casting, $duration, $cover_image, $release_date ]);

            // Récupère le dernier ID inséré
            $id = $this->pdo->lastInsertId();

            // Retourne la réponse à true avec une message de succès
            return ResponseHandler::format(true, 'Succès', $id);
        }catch (PDOException $e) {
            
            // Retourne la réponse à false avec le code en erreur
            return ResponseHandler::format(false, 'Erreur : ' . $e->getCode());
        }

    }

}

?>