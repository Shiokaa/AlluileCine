<?php

namespace App\Controllers;

use App\Models\User;
use Config\Database\Database;

class UserController {

    private $userModel;

    /** Constructeur de la class UserController
     */
    public function __construct() 
    {
        $db = Database::getInstance()->getConnection();
        $this->userModel = new User($db); 
    }

    /** Permet d'afficher la page de register
     */
    public function showRegisterForm()
    {
        include __DIR__ . "/../Views/register.php";
    }

    /** Récupère les données de l'utilisateur pour les envoyer au model
     */
    public function handleRegister()
    {

    }
}

?>