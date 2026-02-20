<?php

namespace App\Controllers;

use App\Models\Movie;
use Config\Database\Database;
use App\Middlewares\AuthMiddleware;

class MovieController {

    private $movieModel;
    private $authMiddleware;

    public function __construct(){
        $db = Database::getInstance()->getConnection();
        $this->movieModel = new Movie($db); 
        $this->authMiddleware = new AuthMiddleware();
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
}