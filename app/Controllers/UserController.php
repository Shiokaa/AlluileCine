<?php

namespace App\Controllers;

use App\Models\User;
use Config\Database\Database;
use Helpers\ResponseHandler;

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
        // On vérifie si les données du formulaire sont bien remplies
        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Veuillez remplir tous les champs !";
            header('Location: /register');
            exit;
        }

        $fullname = $_POST['lastname'] . " " . $_POST['firstname'];
        $email = $_POST['email'];
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $response = $this->userModel->create($fullname, $email, $passwordHash);

        if ($response['status']) {
            header('Location: /login'); // Rediriger vers la connexion en cas de succès
            exit;
        }
    } 
}

?>