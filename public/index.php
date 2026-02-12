<?php

// Afficher les erreurs pour le debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation de la session
session_start();

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/env.php";

$router = require_once __DIR__ . "/../routes/router.php";


$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());


$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

echo "$response";
?>