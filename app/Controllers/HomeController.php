<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Movie;
use Config\Database\Database;

class HomeController {

    private $movieModel;

    /** Constructeur de la class HomeController
     * Initialise la connexion à la base de données et le modèle Movie
     */
    public function __construct() {
        $db = Database::getInstance()->getConnection();
        $this->movieModel = new Movie($db);
    }

    /** Permet d'afficher la page d'accueil avec la liste des films
     */
    public function showHomePage() {
        // Définition de la pagination pour limiter le nombre de films par page
        $limit = 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;

        // Requête à la base de données pour récupérer les films paginés
        $response = $this->movieModel->findAll($limit, $offset);
        $movies = $response['data'];
        
        // Calcul du nombre total de pages pour l'affichage de la navigation
        $totalMovies = $this->movieModel->countAll();
        $totalPages = ceil($totalMovies / $limit);

        // Transmission des données et rendu de la page d'accueil
        include_once __DIR__ . "/../Views/home.php";
    }

    /** Permet d'afficher la page de contact
     */
    public function showContactPage() {
        include_once __DIR__ . "/../Views/contact.php";
    }

    /** Permet d'afficher la page du guide d'utilisation
     */
    public function showGuidePage() {
        include_once __DIR__ . "/../Views/guide.php";
    }
}