<?php

namespace App\Controllers;

use App\Models\Movie;
use App\Models\Session;
use Config\Database\Database;

class MovieController {

    private $movieModel;
    private $sessionModel;
    private $authMiddleware;

    public function __construct(){
        $db = Database::getInstance()->getConnection();
        $this->movieModel = new Movie($db); 
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

}