<?php

namespace App\Middlewares;

class AuthMiddleware {

    /**
     * Protège les pages privées : redirige vers /login si l'utilisateur n'est pas connecté.
     */
    public function requireAuth() 
    {
        if (!isset($_SESSION['userId'])) {
            $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page.";
            header('Location: /login');
            exit;
        }
    }

    /**
     * Protège les pages publiques (login/register) : redirige vers / si l'utilisateur est déjà connecté.
     */
    public function requireGuest()
    {
        if (isset($_SESSION['userId'])) {
            header('Location: /');
            exit;
        }
    }
}

?>