<?php

namespace App\Controllers;

use App\Models\Movie;
use App\Models\Session;
use Config\Database\Database;
use App\Middlewares\AuthMiddleware;
use App\Services\TmdbService;

class MovieController {

    private $movieModel;
    private $sessionModel;
    private $authMiddleware;
    private $tmdbService;

    public function __construct(){
        $db = Database::getInstance()->getConnection();
        $this->movieModel = new Movie($db); 
        $this->authMiddleware = new AuthMiddleware();
        $this->tmdbService = new TmdbService();
        $this->sessionModel = new Session($db);
    }

    public function showMoviePage(int $id)
    {
        $movieResponse = $this->movieModel->findById($id);
        if(empty($movieResponse['data'])) {
            header('HTTP/1.0 404 Not Found');
            exit;
        }
        
        $sessionResponse = $this->sessionModel->findStartEventByMovieId($id);
        $allSessions = $sessionResponse['data'] ?? [];
        
        // Grouper les séances par date (YYYY-MM-DD)
        $sessionsByDate = [];
        foreach ($allSessions as $session) {
            $date = date('Y-m-d', strtotime($session['start_event']));
            $sessionsByDate[$date][] = $session;
        }

        // Générer les 7 prochains jours pour le calendrier
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

        $movie = $movieResponse['data'];

        // On envoie la view
        require_once __DIR__ . "/../Views/movie.php";
    }

    public function handleMovieDelete(int $id)
    {
        $this->authMiddleware->requireAdmin();

        $this->movieModel->delete($id);

        header('Location: /dashboard');
        exit;
    }

    public function showAddMovieForm()
    {
        $this->authMiddleware->requireAdmin();
        // On envoie la view
        include __DIR__ . "/../Views/addMovie.php";
    }

    public function handleAddMovie()
    {
        // On vérifie si les données du formulaire sont bien remplies
        if (empty($_POST['title'])) {
            $_SESSION['error'] = "Veuillez remplir tous les champs !";
            header('Location: /dashboard/addMovie');
            exit;
        }

        $titre = $_POST['title'];
       
        $data = $this->tmdbService->getFullMovieDetails($titre); 

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
}