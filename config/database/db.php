<?php
include_once '../env.php';
class Database
{
    private static $_instance = null;
    private $pdo;
    private function __construct()
    {
        $host = $_ENV['host'];
        $dbName = $_ENV['dbname'];
        $username = $_ENV['username'];
        $password = $_ENV['password'];

        $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false, //Pour la sécurité, bloque mieux injections sql
        ];

        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        }
        catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }
    public function getConnection()
    {
        return $this->pdo;
    }

    //fonction vide pour éviter le clonage de l'objet
    private function __clone()
    {

    }

    //fonction vide pour éviter la désérialisation de l'objet
    private function __wakeup()
    {

    }
}