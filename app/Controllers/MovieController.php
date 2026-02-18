<?php

namespace App\Controllers;

use App\Models\Movie;
use Config\Database\Database;

class MovieController {

    private $movieModel;
    private $authMiddleware;

    public function __construct(){
        $db = Database::getInstance()->getConnection();
        $this->movieModel = new Movie($db); 
    }

    public function showMoviePage(int $id)
    {
        $response = $this->movieModel->findById($id);
        if(empty($response['data'])) {
            header('HTTP/1.0 404 Not Found');
            exit;
        }

        $movie = $response['data'];

        // On envoie la view
    include __DIR__ . "/../Views/movie.php";
    }

}