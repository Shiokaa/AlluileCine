<?php

namespace App\Controllers;

use App\Models\User;
use Config\Database\Database;
use App\Middlewares\AuthMiddleware;

class DashboardController {
    
    private $movieModel;
    private $userModel;
    private $authMiddleware;

    public function __construct(){
        $db = Database::getInstance()->getConnection();
        $this->movieModel = new Movie($db); 
        $this->userModel = new User($db); 
        $this->authMiddleware = new AuthMiddleware();
    }

    public function showDashboardPage()
    {
        
        $this->authMiddleware->requireAdmin();

        $responseMovie = $this->movieModel->findAll();
        $movie = $responseMovie['data'];

        $responseUser = $this->userModel->findAll();
        $user = $responseUser['data']; 

    include __DIR__ . "/../Views/Dashboard.php";
    }

    

    public function deleMovie() {} 

    public function addUser() {}


}