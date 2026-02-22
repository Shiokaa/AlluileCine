<?php

use Dotenv\Dotenv;

// Essai de chargement des variables d'environnement depuis le fichier de configuration .env à la racine
try {
    $dotenv = Dotenv::createImmutable(__DIR__ . "/../");
    $dotenv->load();
}
catch (Exception $e) {
    // Interception et affichage formel de l'erreur en cas de fichier introuvable ou illisible
    echo "Erreur lors du chargement du fichier .env : " . $e->getMessage();
}
