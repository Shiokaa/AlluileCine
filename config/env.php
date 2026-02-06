<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

try {
    // Charger le fichier .env depuis le répertoire courant
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

// Récupérer les variables




}
catch (Exception $e) {
    echo "Erreur lors du chargement du fichier .env : " . $e->getMessage();
}