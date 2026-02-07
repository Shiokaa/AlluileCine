<?php

use Dotenv\Dotenv;

try {
    // Charge le fichier .env qui est la racine.
    $dotenv = Dotenv::createImmutable(__DIR__ . "/../");
    $dotenv->load();
}
catch (Exception $e) {
    echo "Erreur lors du chargement du fichier .env : " . $e->getMessage();
}
