<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use Helpers\ResponseHandler;
use PDOException;

class User
{

    private PDO $pdo;

    /** * Constructeur de la class User
     */
    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }

    /** * Crée un nouvel utilisateur en base de données.
     *
     * @param string $fullname Nom complet de l'utilisateur.
     * @param string $email    Adresse email unique.
     * @param string $password Mot de passe déjà haché.
     * * @return array Retourne la réponse.
     */
    public function create(string $fullname, string $email, string $passwordHash): array
    {
        // Élaboration de la requête SQL d'insertion avec paramètres de masquage
        $sql = 'INSERT INTO users (fullname, email, password_hash) VALUES (?, ?, ?)';

        try {
            // Instanciation de la requête préparée via PDO
            $statement = $this->pdo->prepare($sql);

            // Exécution sécurisée de la requête en liant les données de l'utilisateur
            $statement->execute([$fullname, $email, $passwordHash]);

            // Récupération de l'identifiant unique nouvellement généré par la DB
            $id = $this->pdo->lastInsertId();

            // Formatage d'un statut positif renvoyant l'ID validé
            return ResponseHandler::format(true, 'Succès', $id);

        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            // Retour du code d'erreur PDO pour permettre au contrôleur de distinguer les cas (ex: 1062 = doublon)
            return ResponseHandler::format(false, (string) $e->getCode());
        }
    }

    /** * Récupère un utilisateur via son addresse mail
     *
     * @param string $email Adresse mail de l'utilisateur.
     * * @return array Retourne la réponse.
     */
    public function findByEmail(string $email): array
    {
        // Définition de la requête de sélection ciblant l'email
        $sql = "SELECT * FROM users WHERE email = ?";

        try {
            // Préparation de la requête limitant les injections SQL
            $statement = $this->pdo->prepare($sql);

            // Exécution et attribution de la variable email
            $statement->execute([$email]);

            // Retour formaté avec les données extraites
            return ResponseHandler::format(true, 'Succès', $statement->fetch());
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            // Retourne la réponse à false avec une message d'erreur
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }

    /** * Récupère un utilisateur via son Id
     *
     * @param int $id Id de l'utilisateur.
     * * @return array Retourne la réponse.
     */
    public function findById(int $id): array
    {
        // Élaboration de la sélection ciblant la clé primaire
        $sql = "SELECT * FROM users WHERE id = ?";

        try {
            // Préparation de la structure de requête en amont
            $statement = $this->pdo->prepare($sql);

            // Exécution dynamique avec l'identifiant requis
            $statement->execute([$id]);

            // Restitution de l'occurrence trouvée encapsulée dans une réponse standard
            return ResponseHandler::format(true, 'Succès', $statement->fetch());
        }
        catch (PDOException $e) {
            // Retourne la réponse à false avec une message d'erreur
            return ResponseHandler::format(false, 'Erreur : ' . $e->getMessage());
        }
    }
    public function findAll(): array
    {
        // Définition de la sélection sans filtre
        $sql = "SELECT * FROM users";

        try {
            // Lancement du préparateur de requête lié à l'instance PDO
            $statement = $this->pdo->prepare($sql);

            // Exécution sèche (sans paramètre)
            $statement->execute();

            // Rapatriement de l'ensemble des enregistrements sous format tabulaire
            return ResponseHandler::format(true, 'Succès', $statement->fetchAll());
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            // Retourne la réponse à false avec une message d'erreur
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }
    }
    public function delete(int $id): array
    {
        // Spécification de la commande de suppression via identifiant
        $sql = "DELETE FROM users WHERE id = ?";

        try {
            // Envoi de l'instruction au gestionnaire de base de données
            $statement = $this->pdo->prepare($sql);

            // Effacement effectif de la ligne ciblée
            $statement->execute([$id]);

            // Renvoi du statut final (fetch vide ou non après exécution)
            return ResponseHandler::format(true, 'Succès', $statement->fetch());

        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            // Retourne la réponse à false avec une message d'erreur
            return ResponseHandler::format(false, "Une erreur est survenue lors du traitement de votre demande.");
        }


    }
}
