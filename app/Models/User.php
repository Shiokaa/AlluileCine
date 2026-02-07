<?php

namespace App\Models;

use Helpers\ResponseHandler;
use PDOException;

class User {

    private $pdo;

    /** * Constructeur de la class User
     */
    public function __construct($db)
    {
        $this->pdo = $db;
    }

    /** * Crée un nouvel utilisateur en base de données.
    *
    * @param string $fullname Nom complet de l'utilisateur.
    * @param string $email    Adresse email unique.
    * @param string $password Mot de passe déjà haché.
    * * @return array Retourne la réponse
    */
    public function create(string $fullname, string $email, string $passwordHash): array
    {
        // Création de la query pour insérer un utilisateur dans la base de donnée
        $sql = 'INSERT INTO users (fullname, email, password_hash) VALUES (?, ?, ?)';

        try {
            // Prépare la requête
            $statement = $this->pdo->prepare($sql);
            // Exécute la requête préparé via les données envoyées
            $statement->execute([$fullname, $email, $passwordHash]);
            // Récupère le dernier ID inséré
            $id = $this->pdo->lastInsertId();
            // Retourne la réponse à true avec une message de succès
            return ResponseHandler::format(true, 'Succès', $id);
        } catch (PDOException $e) {
            // Retourne la réponse à false avec le message d'erreur
            return ResponseHandler::format(false, 'Erreur : ' . $e->getMessage());
        }
    }
}