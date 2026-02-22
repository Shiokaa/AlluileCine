<?php

namespace Config\Database;

use PDO;
use PDOException;

class Database
{
    private static $_instance = null;
    private $pdo;

    private function __construct()
    {
        // Récupération des identifiants et variables réseau depuis l'environnement
        $host = $_ENV['host'];
        $dbName = $_ENV['dbname'];
        $username = $_ENV['username'];
        $password = $_ENV['password'];

        // Formatage du DSN (Data Source Name) définissant le type de BDD et la cible de connexion
        $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";

        // Configuration stricte des options du flux PDO (gestion d'erreur, format et sécurité)
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false, //Pour la sécurité, bloque mieux injections sql
        ];

        // Tentative d'initialisation de l'instance PDO constituant le pont vers la base de données
        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        }
        catch (PDOException $e) {
            // Arrêt critique et retour textuel strict de l'erreur si la base est inatteignable
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        // Modèle de conception Singleton assurant une occurrence unique de l'objet Base de Données
        if (self::$_instance === null) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function getConnection()
    {
        // Rapatriement de l'objet PDO instancié pour exécuter des requêtes sur les modèles
        return $this->pdo;
    }

    // Blocage complet du clonage public pour conserver le principe d'instance unique (Singleton)
    private function __clone()
    {

    }

    // Interdiction pure de la désérialisation d'objet évitant toute corruption de l'instance partagée
    private function __wakeup()
    {
        throw new \Exception('Désérialisation interdite sur le Singleton Database.');
    }
}