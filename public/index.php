<?php

// Initialisation de la session
session_start();

// Génération d'un jeton CSRF unique pour sécuriser les formulaires, s'il n'existe pas déjà
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$sessionTimeout = 1800; // 30 minutes d'inactivité

// Gestion de l'expiration de session pour les utilisateurs inactifs n'ayant pas coché "Se souvenir de moi"
if (isset($_SESSION['userId']) && empty($_SESSION['remember_me'])) {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $sessionTimeout)) {
        session_unset();
        session_destroy();
        
        // Suppression du cookie de session côté client
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
        session_start();
        $_SESSION['error'] = "Votre session a expiré en raison d'une inactivité prolongée.";
        header('Location: /login');
        exit;
    }
    
    // Mise à jour du marqueur d'activité pour prolonger la session active
    $_SESSION['last_activity'] = time();
}

// Chargement de l'autoloader Composer et des configurations d'environnement
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/env.php";

// Initialisation du routeur contenant toutes les définitions de routes
$router = require_once __DIR__ . "/../routes/router.php";


// Instanciation du Dispatcher de Phroute pour traiter la requête courante
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());


// Essai d'exécution de la route correspondante et rendu, ou gestion des erreurs HTTP (404/405)
try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    echo "$response";
} catch (Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
    header('HTTP/1.0 404 Not Found');
    include __DIR__ . "/../app/Views/error404.php";
} catch (Phroute\Phroute\Exception\HttpMethodNotAllowedException $e) {
    header('HTTP/1.0 405 Method Not Allowed');
    include __DIR__ . "/../app/Views/error405.php";
}
?>