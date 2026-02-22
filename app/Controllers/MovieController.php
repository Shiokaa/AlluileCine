<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Movie;
use App\Models\Room;
use App\Models\Session;
use Config\Database\Database;
use App\Middlewares\AuthMiddleware;
use App\Services\TmdbService;

class MovieController {

    private $movieModel;
    private $sessionModel;
    private $roomModel;
    private $authMiddleware;
    private $tmdbService;

    /** Constructeur de la class MovieController
     * Initialise la connexion à la base de données, les modèles concernés, le service TMDB et la middleware.
     */
    public function __construct(){
        $db = Database::getInstance()->getConnection();
        $this->movieModel = new Movie($db); 
        $this->authMiddleware = new AuthMiddleware();
        $this->tmdbService = new TmdbService();
        $this->sessionModel = new Session($db);
        $this->roomModel = new Room($db);
    }

    /** Permet d'afficher la page d'un film complet
     *
     * @param int $id Id du film.
     */
    public function showMoviePage(int $id)
    {
        // Récupération des détails du film et vérification de son existence (Erreur 404 si null)
        $movieResponse = $this->movieModel->findById($id);
        if(empty($movieResponse['data'])) {
            header('HTTP/1.0 404 Not Found');
            exit;
        }
        
        // Récupération de toutes les séances programmées pour ce film précis
        $sessionResponse = $this->sessionModel->findStartEventByMovieId($id);
        $allSessions = $sessionResponse['data'] ?? [];
        
        // Tri et regroupement des séances selon leur date de diffusion au format 'Y-m-d'
        $sessionsByDate = [];
        foreach ($allSessions as $session) {
            $date = date('Y-m-d', strtotime($session['start_event']));
            $sessionsByDate[$date][] = $session;
        }

        // Génération de la boucle calendaire permettant d'afficher les 7 prochains jours
        $calendarDates = [];
        $daysMap = [
            'Mon' => 'Lun',
            'Tue' => 'Mar',
            'Wed' => 'Mer',
            'Thu' => 'Jeu',
            'Fri' => 'Ven',
            'Sat' => 'Sam',
            'Sun' => 'Dim',
        ];

        for ($i = 0; $i < 7; $i++) {
            $timestamp = strtotime("+$i days");
            $date = date('Y-m-d', $timestamp);
            $dayNameEn = date('D', $timestamp);
            
            $calendarDates[] = [
                'date' => $date,
                'day_name' => $daysMap[$dayNameEn],
                'day_num' => date('d', $timestamp),
                'has_session' => isset($sessionsByDate[$date])
            ];
        }

        // Préparation des données finales et appel de la vue du détail du film
        $movie = $movieResponse['data'];
        require_once __DIR__ . "/../Views/movie.php";
    }

    /** Permet de gérer la suppression d'un film
     *
     * @param int $id Id du film à supprimer.
     */
    public function handleMovieDelete(int $id)
    {
        // Vérification des privilèges administrateur
        $this->authMiddleware->requireAdmin();

        // Contrôle de sécurité interne via la vérification du jeton CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Jeton CSRF invalide.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Exécution de la requête de suppression du film en base de données
        $this->movieModel->delete($id);

        // Redirection post-action vers l'interface récapitulative du tableau de bord
        header('Location: /dashboard');
        exit;
    }

    /** Permet d'afficher le formulaire d'ajout d'un film
     */
    public function showAddMovieForm()
    {
        // On vérifie que l'utilisateur est admin
        $this->authMiddleware->requireAdmin();
        // On envoie la view
        include __DIR__ . "/../Views/addMovie.php";
    }

    /** Permet d'ajouter un nouveau film
     */
    public function handleAddMovie()
    {
        // Vérification des privilèges administrateur
        $this->authMiddleware->requireAdmin();

        // Validation primaire du jeton CSRF pour contrer les failles associées
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Jeton CSRF invalide.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Vérification des champs requis du formulaire
        if (empty($_POST['title'])) {
            $_SESSION['error'] = "Veuillez remplir tous les champs !";
            header('Location: /dashboard/addMovie');
            exit;
        }

        $titre = $_POST['title'];
       
        // Appel à l'API publique TMDB pour glaner les informations complémentaires du film
        $data = $this->tmdbService->getFullMovieDetails($titre); 

        // Traitement de l'insertion en base en cas de réponse valide de l'API
        if ($data) {
            $response = $this->movieModel->create(
                $data['title'],         
                $data['description'],    
                $data['genres'],         
                $data['director'],       
                $data['casting'],        
                (string)$data['duration'], 
                $data['cover_image'],    
                $data['release_date']    
            );
        } else {
            $_SESSION['error'] = "Film inexistant";
            header('Location: /dashboard/addMovie');
            exit;
        }

        // Traitement du résultat de création et redirection adéquate
        if ($response['status']) {
            header('Location: /dashboard');
            exit;
        } else {
            $_SESSION['error'] = "Erreur serveur inattendu";
            $_SESSION['message'] = $response['message'];
            header('Location: /dashboard'); 
            exit;
        }
    } 

    /** Permet d'afficher le formulaire d'ajout d'une séance
     *
     * @param int $id Id du film.
     */
    public function showAddSessionForm(int $id)
    {
        // Vérification des privilèges administrateur
        $this->authMiddleware->requireAdmin();

        // Vérification de la validité du film ciblé
        $movieResponse = $this->movieModel->findById($id);
        $movie = $movieResponse['data'] ?? null;

        if (!$movie) {
            header('Location: /dashboard');
            exit;
        }

        // Récupération de l'ensemble des salles pour le formulaire de création
        $roomResponse = $this->roomModel->findAll();
        $rooms = $roomResponse['data'] ?? [];

        // Récupération des séances existantes pour ce même film afin de les lister
        $existingSessionsResponse = $this->sessionModel->getMovieSessionsDetails($id);
        $existingSessions = $existingSessionsResponse['data'] ?? [];

        include __DIR__ . "/../Views/addSession.php";
    }

    /** Permet d'ajouter une séance
     *
     * @param int $id Id du film.
     */
    public function handleAddSession(int $id)
    {
        // Vérification des privilèges administrateur
        $this->authMiddleware->requireAdmin();

        // Validation du jeton CSRF obligatoire pour interagir sur une ressource
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Jeton CSRF invalide.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Vérification et sécurité des champs de données postées
        if (empty($_POST['room_id']) || empty($_POST['start_event'])) {
            $_SESSION['error'] = "Veuillez remplir tous les champs !";
            header("Location: /dashboard/movies/$id/addSession");
            exit;
        }

        $roomId = (int)$_POST['room_id'];
        $startEvent = str_replace('T', ' ', $_POST['start_event']);

        // Contrôle de non-superposition (une seule séance par salle et par même horaire)
        $checkResponse = $this->sessionModel->checkExists($roomId, $startEvent);
        if ($checkResponse['status'] === true && $checkResponse['data'] === true) {
            $_SESSION['error'] = "Une séance est déjà programmée dans cette salle à cette heure.";
            header("Location: /dashboard/movies/$id/addSession");
            exit;
        }

        // Insertion en base de la nouvelle séance homologuée
        $response = $this->sessionModel->create($id, $roomId, $startEvent);

        // Feedback utilisateur et redirection de retour au hub
        if ($response['status'] === true) {
            $_SESSION['message'] = "Séance ajoutée avec succès.";
            header('Location: /dashboard');
            exit;
        } else {
            $_SESSION['error'] = "Erreur lors de l'ajout de la séance.";
            header("Location: /dashboard/movies/$id/addSession");
            exit;
        }
    }
}