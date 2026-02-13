<?php

namespace App\Controllers;

use App\Models\Movie;
use Config\Database\Database;

class HomeController {

    private $movieModel;

    /**
     * Constructeur de la class HomeController
     * Initialise la connexion à la base de données et le modèle Movie
     */
    public function __construct() {
        $db = Database::getInstance()->getConnection();
        $this->movieModel = new Movie($db);
    }

    /**
     * Affiche la page d'accueil avec la liste des films
     */
    public function showHomePage() {
        // Récupère tous les films depuis la base de données
        $response = $this->movieModel->findAll();
        
        // Extrait les données (la liste des films) de la réponse
        $movies = $response['data'];
        
        // Inclut la vue de la page d'accueil
        include_once __DIR__ . "/../Views/home.php";
    }
}

?>