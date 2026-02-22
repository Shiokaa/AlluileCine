<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use Helpers\ResponseHandler;
use PDOException;

class Movie {
    private PDO $pdo;

    /** Constructeur de la class Movie
     */
    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }

    /** Récupère tous les films de la base de données.
     *
     * @return array Retourne la réponse.
     */
    public function findAll($limit = null, $offset = null): array
    {
        // Définition initiale de la requête de base pour récupérer tous les films
        $sql = 'SELECT * FROM movies';
        
        // Ajout conditionnel de la pagination si les limites sont fournies
        if ($limit !== null && $offset !== null) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }

        try {
            // Préparation de l'expression SQL globale
            $statement = $this->pdo->prepare($sql);

            // Sécurisation stricte des marqueurs de pagination en entier
            if ($limit !== null && $offset !== null) {
                $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
                $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
            }

            // Déclenchement de la requête vers la BDD
            $statement->execute();

            // Collecte de la grappe de résultats
            $movies = $statement->fetchAll();

            // Formatage d'une réponse approuvée restituant la masse de données
            return ResponseHandler::format(true, 'Succès', $movies);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            // Retourne la réponse à false avec le message d'erreur
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }

    /** Compte le nombre total de films
     *
     * @return int Retourne le nombre.
     */
    public function countAll(): int
    {
        // Utilisation d'une agrégation stricte de dénombrement
        $sql = 'SELECT COUNT(*) FROM movies';
        try {
            // Exécution directe sans variables de substitution
            $statement = $this->pdo->query($sql);
            
            // Extraction directe de l'entier résultant
            return (int) $statement->fetchColumn();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    /** Récupère un film via son Id
     *
     * @param int $id Id du film.
     * @return array Retourne la réponse.
     */
    public function findById(int $id) : array
    {
        // Rédaction de la requête de recoupement de clé primaire
        $sql = 'SELECT * FROM movies WHERE id = ?';
        
        try {
            // Initialisation de la requête pré-compilée
            $statement = $this->pdo->prepare($sql);

            // Interrogation avec la valeur cible
            $statement->execute([$id]);

            // Retour sous la forme d'un tableau unique
            $movie = $statement->fetch();

            // Encapsulation dans le constructeur de réponse partagé
            return ResponseHandler::format(true, 'Succès', $movie);
        }catch(PDOException $e) {
            error_log($e->getMessage());
            // Retourne la réponse à false avec le message d'erreur
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }
    /** Supprime un film via son Id
     *
     * @param int $id Id du film à supprimer.
     * @return array Retourne la réponse.
     */
    public function delete(int $id): array
    {
        // Cadrer la séquence d'effacement autour de la spécificité ID
        $sql = "DELETE FROM movies WHERE id = ?";

        try {
            // Préparation structurelle avant injection de donnée
            $statement = $this->pdo->prepare($sql);

            // Validation finale et suppression matérielle en base
            $statement->execute([$id]);

            return ResponseHandler::format(true, 'Succès', $statement->fetch());

        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            // Retourne la réponse à false avec une message d'erreur
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }
    /** Crée un nouveau film dans la base de données
     *
     * @param string $title Titre.
     * @param string $description Description.
     * @param string $genre Genre.
     * @param string $director Réalisateur.
     * @param string $casting Casting.
     * @param string $duration Durée.
     * @param string $cover_image Image de couverture.
     * @param string $release_date Date de sortie.
     * @return array Retourne la réponse.
     */
    public function create(string $title,string $description,string $genre,string $director,string $casting,string $duration,string $cover_image,string $release_date): array {

        // Rédaction du pattern de sauvegarde massif (création d'entrée métier entière)
        $sql = 'INSERT INTO movies (title, description, genre, director, casting, duration, cover_image, release_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

        try {
            // Armement de la requête PDO contre les tentatives de failles
            $statement = $this->pdo->prepare($sql);

            // Ordre de placement des métadonnées vers MySql
            $statement->execute([$title, $description, $genre, $director, $casting, $duration, $cover_image, $release_date ]);

            // Capture systématique du nouvel index attribué par l'auto-increment
            $id = $this->pdo->lastInsertId();

            return ResponseHandler::format(true, 'Succès', $id);
        }catch (PDOException $e) {
            error_log($e->getMessage());
            // Retourne la réponse à false avec le code en erreur
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }

    }

}