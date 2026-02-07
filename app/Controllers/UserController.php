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

        // On récupère les données de l'utilisateur via la variable global POST
        $fullname = $_POST['lastname'] . " " . $_POST['firstname'];
        $email = $_POST['email'];
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // On envoie les données de l'utilisateur au model
        $response = $this->userModel->create($fullname, $email, $passwordHash);

        if ($response['status']) {
            header('Location: /login'); // Rediriger vers la connexion en cas de succès
            exit;
        }
    } 

    /** Permet d'afficher la page de login
     */
    public function showLoginForm()
    {
        include __DIR__ . "/../Views/login.php";
    }

    /** Récupère les données de l'utilisateur pour les envoyer au model
     */
    public function handleLogin()
    {
        // On vérifie si les données du formulaire sont bien remplies
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Veuillez remplir tous les champs !";
            header('Location: /register');
            exit;
        }
        
        // On récupère les données de l'utilisateur via la variable global POST
        $email = $_POST['email'];
        $passwordInput = $_POST['password'];

        // On envoie les données de l'utilisateur au model et on récupère la réponse
        $response = $this->userModel->findByEmail($email);

        // On vérifie le status de la réponse et la validité du mot de passe envoyé par l'utilisateur
        if ($response['status'] && password_verify($passwordInput, $response['data']['password_hash'])){
            // Utilisateur connecté ajout de l'utilisateur à la session à faire plus tard pour l'instant redirection vers /
            header('Location: /');
            exit;
        } else {
            $_SESSION['error'] = "Email inconnu ou mauvais mot de passe";
            header('Location: /login');
            exit;
        }
    }
}

?>