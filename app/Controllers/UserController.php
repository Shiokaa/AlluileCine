<?php

namespace App\Controllers;

use App\Models\User;
use Config\Database\Database;
use App\Middlewares\AuthMiddleware;

class UserController {

    private $userModel;
    private $authMiddleware;

    /** Constructeur de la class UserController
     * Initialise la connexion à la base de données, le modèle User ainsi que le middleware d'authentification
     */
    public function __construct() 
    {
        $db = Database::getInstance()->getConnection();
        $this->userModel = new User($db); 
        $this->authMiddleware = new AuthMiddleware();
    }

    /** Permet d'afficher la page de register
     */
    public function showRegisterForm()
    {
        // Vérification avec la middleware que l'utilsateur soit pas connecté
        $this->authMiddleware->requireGuest();
        // On envoie la view
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

        // On vérifie que le mot de passe soit assez long
        if (strlen($_POST['password']) <= 6) {
            $_SESSION['error'] = "Mot de passe trop court (6 caractères minimum)";
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
        } else {
            // Si code 1062 alors email déjà utilisé sinon c'est une erreur serveur inconnu
            if ($response['message'] = "1062") {
                $_SESSION['error'] = "Email déjà utilisé"; // !!!!!!!!! Très dangereux à remplacer par un envoie d'email
            } else {
                $_SESSION['error'] = "Erreur serveur inattendu";
            }
            header('Location: /register'); // Rediriger vers l'inscription en cas d'erreur
            exit;
        }
    } 

    /** Permet d'afficher la page de login
     */
    public function showLoginForm()
    {
        // Vérification avec la middleware que l'utilsateur soit pas connecté
        $this->authMiddleware->requireGuest();
        // On envoie la view
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
            $_SESSION['userId'] = $response['data']['id'];
            $_SESSION['userRole'] = $response['data']['role'];
            header('Location: /');
            exit;
        } else {
            $_SESSION['error'] = "Email inconnu ou mauvais mot de passe";
            header('Location: /login');
            exit;
        }
    }

    /** Déconnecte l'utilisateur en supprimant les variables de session et en détruisant la session
     */
    public function handleLogout()
    {
        // Renvoie l'utilisateur vers le /login s'il essaye d'accéder à /logout sans être connecté
        $this->authMiddleware->requireAuth();

        // Supprime les variables de session
        session_unset();

        // Détruit la session
        session_destroy();
        
        //Renvoie vers la page /login et quitte la fonction
        header('Location: /login');
        exit;
    }

    public function showAccountPage()
    {
        $this->authMiddleware->requireAuth();

        $response = $this->userModel->findById($_SESSION['userId']);

        $user = $response['data'];

        include_once __DIR__ . "/../Views/account.php";
    }
}

?>
