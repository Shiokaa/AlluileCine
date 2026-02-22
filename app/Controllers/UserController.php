<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Config\Database\Database;
use App\Middlewares\AuthMiddleware;

class UserController {

    private $userModel;
    private $reservationModel;
    private $authMiddleware;

    /** Constructeur de la class UserController
     * Initialise la connexion à la base de données, le modèle User ainsi que le middleware d'authentification
     */
    public function __construct() 
    {
        $db = Database::getInstance()->getConnection();
        $this->userModel = new User($db); 
        $this->reservationModel = new Reservation($db);
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
        // Validation stricte du jeton CSRF de sécurité
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Jeton CSRF invalide.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Vérification de la complétude stricte des champs du formulaire
        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Veuillez remplir tous les champs !";
            header('Location: /register');
            exit;
        }

        // Contrôle de robustesse minimale du mot de passe
        if (strlen($_POST['password']) < 8) {
            $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères";
            header('Location: /register');
            exit;
        }

        // Formatage des données utilisateurs avant insertion (concatenation et hashage)
        $fullname = $_POST['lastname'] . " " . $_POST['firstname'];
        $email = $_POST['email'];
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Exécution de l'insertion du nouvel utilisateur dans la base de données
        $response = $this->userModel->create($fullname, $email, $passwordHash);

        // Analyse de la réponse d'insertion et redirection de retour adéquate
        if ($response['status']) {
            header('Location: /login');
            exit;
        } else {
            // Traitement de l'erreur si l'email est déjà utilisé (Code MYSQL 1062)
            if ($response['message'] === "1062") {
                $_SESSION['error'] = "Email déjà utilisé";
            } else {
                $_SESSION['error'] = "Erreur serveur inattendu";
            }
            header('Location: /register');
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
        // Contrôle de validité du jeton CSRF de connexion
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Jeton CSRF invalide.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Validation de la présence des identifiants saisis
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Veuillez remplir tous les champs !";
            header('Location: /login');
            exit;
        }
        
        // Assignation des variables transmises
        $email = $_POST['email'];
        $passwordInput = $_POST['password'];

        // Récupération de l'utilisateur existant en base de données
        $response = $this->userModel->findByEmail($email);

        // Comparaison cryptographique du mot de passe avec le hash enregistré
        if ($response['status'] && password_verify($passwordInput, $response['data']['password_hash'])){
            $_SESSION['userId'] = $response['data']['id'];
            $_SESSION['userRole'] = $response['data']['role'];
            $_SESSION['last_activity'] = time();

            // Gestion de la persistance de connexion si l'option est cochée
            if (isset($_POST['remember_me'])) {
                $_SESSION['remember_me'] = true;
                $cookieParams = session_get_cookie_params();
                setcookie(
                    session_name(), 
                    session_id(), 
                    time() + 30 * 24 * 3600, 
                    $cookieParams['path'], 
                    $cookieParams['domain'], 
                    $cookieParams['secure'], 
                    $cookieParams['httponly']
                );
            }

            // Redirection système vers le hub après acceptation
            header('Location: /');
            exit;
        } else {
            // Rejet logique et notification de l'erreur d'identification
            $_SESSION['error'] = "Email inconnu ou mauvais mot de passe";
            header('Location: /login');
            exit;
        }
    }

    /** Déconnecte l'utilisateur en supprimant les variables de session et en détruisant la session
     */
    public function handleLogout()
    {
        // Vérification du statut de connexion courant
        $this->authMiddleware->requireAuth();

        // Vidage puis destruction complète de l'objet de session
        session_unset();
        session_destroy();
        
        // Interruption forcée du cookie de session prolongée
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Renvoi de l'invité sur la page de connexion
        header('Location: /login');
        exit;
    }

    public function showAccountPage()
    {
        // Vérification de la présence et de la légitimité de la session
        $this->authMiddleware->requireAuth();

        // Chargement intégral des métadonnées de l'utilisateur
        $response = $this->userModel->findById($_SESSION['userId']);
        $user = $response['data'];

        // Recherche et extraction des réservations existantes
        $resResponse = $this->reservationModel->findByUserId($_SESSION['userId']);
        $reservations = $resResponse['data'] ?? [];
        
        // Isolation exclusive des 3 entrées les plus récentes pour l'aperçu
        $recentReservations = array_slice($reservations, 0, 3);

        // Distribution des données calculées vers la modélisation de la vue
        include_once __DIR__ . "/../Views/account.php";
    }

    public function handleUserDelete(int $id)
    {
        // Protection du point d'accès via filtrage administrateur
        $this->authMiddleware->requireAdmin();

        // Validation de sécurité stricte du jeton
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Jeton CSRF invalide.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Retrait complet et définitif de l'utilisateur de la base
        $this->userModel->delete($id);

        // Recharge du tableau de bord affichant le nouvel état de la table
        header('Location: /dashboard');
        exit;
    }

    /** Gère la modification du profil (nom et email)
     */
    public function handleUpdateProfile()
    {
        $this->authMiddleware->requireAuth();

        // Validation du jeton CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Jeton CSRF invalide.";
            header('Location: /account');
            exit;
        }

        // Vérification des champs requis
        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email'])) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header('Location: /account');
            exit;
        }

        $fullname = $_POST['lastname'] . " " . $_POST['firstname'];
        $email = $_POST['email'];

        // Mise à jour en base de données
        $response = $this->userModel->updateProfile($_SESSION['userId'], $fullname, $email);

        if ($response['status']) {
            $_SESSION['message'] = "Profil mis à jour avec succès.";
        } else {
            if ($response['message'] === "23000") {
                $_SESSION['error'] = "Cet email est déjà utilisé par un autre compte.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour du profil.";
            }
        }

        header('Location: /account');
        exit;
    }

    /** Gère la modification du mot de passe
     */
    public function handleUpdatePassword()
    {
        $this->authMiddleware->requireAuth();

        // Validation du jeton CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Jeton CSRF invalide.";
            header('Location: /account');
            exit;
        }

        // Vérification des champs requis
        if (empty($_POST['current_password']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header('Location: /account');
            exit;
        }

        // Vérification que les deux nouveaux mots de passe correspondent
        if ($_POST['new_password'] !== $_POST['confirm_password']) {
            $_SESSION['error'] = "Les nouveaux mots de passe ne correspondent pas.";
            header('Location: /account');
            exit;
        }

        // Vérification de la longueur minimale
        if (strlen($_POST['new_password']) < 8) {
            $_SESSION['error'] = "Le nouveau mot de passe doit contenir au moins 8 caractères.";
            header('Location: /account');
            exit;
        }

        // Vérification du mot de passe actuel
        $userResponse = $this->userModel->findById($_SESSION['userId']);
        $user = $userResponse['data'];

        if (!password_verify($_POST['current_password'], $user['password_hash'])) {
            $_SESSION['error'] = "Le mot de passe actuel est incorrect.";
            header('Location: /account');
            exit;
        }

        // Hashage et mise à jour
        $newHash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $response = $this->userModel->updatePassword($_SESSION['userId'], $newHash);

        if ($response['status']) {
            $_SESSION['message'] = "Mot de passe mis à jour avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour du mot de passe.";
        }

        header('Location: /account');
        exit;
    }
}
