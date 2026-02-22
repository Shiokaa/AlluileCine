<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Models\Movie;
use Config\Database\Database;
use App\Middlewares\AuthMiddleware;

class DashboardController
{

    private $movieModel;
    private $userModel;
    private $authMiddleware;

    /** Constructeur de la class DashboardController
     * Initialise la connexion à la base de données, les modèles concernés et le middleware d'authentification
     */
    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $this->movieModel = new Movie($db);
        $this->userModel = new User($db);
        $this->authMiddleware = new AuthMiddleware();
    }

    /** Permet d'afficher le tableau de bord administrateur
     */
    public function showDashboard()
    {
        // Vérification de l'authentification et des droits d'accès administrateur
        $this->authMiddleware->requireAuth();
        $this->authMiddleware->requireAdmin();

        // Récupération de la liste complète des films
        $responseMovie = $this->movieModel->findAll();
        $movie = $responseMovie['data'];

        // Récupération de l'ensemble des utilisateurs enregistrés
        $responseUser = $this->userModel->findAll();
        $user = $responseUser['data'];

        // Transmission des données et affichage de la vue du tableau de bord
        include __DIR__ . "/../Views/dashboard.php";
    }
}