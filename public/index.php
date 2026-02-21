<?php

// Afficher les erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation de la session
session_start();

$sessionTimeout = 1800; // 30 minutes d'inactivité

if (isset($_SESSION['userId']) && empty($_SESSION['remember_me'])) {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $sessionTimeout)) {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['error'] = "Votre session a expiré en raison d'une inactivité prolongée.";
        header('Location: /login');
        exit;
    }
    $_SESSION['last_activity'] = time();
}

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/env.php";

$router = require_once __DIR__ . "/../routes/router.php";


$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());


$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

echo "$response";
?>