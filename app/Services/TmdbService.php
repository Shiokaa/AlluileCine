<?php

namespace App\Services;

class TmdbService {
    private $apiKey;
    private $baseUrl;
    private $imageBaseUrl;

    /** Constructeur de la class TmdbService
     * Initialise les clés et les URL de base
     */
    public function __construct() {
        $this->apiKey = "cc694f5edc9311dd9f5a477f86bc8f8b";
        $this->baseUrl = "https://api.themoviedb.org/3";
        $this->imageBaseUrl = "https://image.tmdb.org/t/p/w500";
    }

    /** Récupère les détails complets d'un film depuis l'API
     *
     * @param string $title Titre du film à rechercher.
     * @return array|null Retourne les détails du film, ou null si introuvable.
     */
    public function getFullMovieDetails($title) {
        // Parcellisation et sécurisation de l'url de requête pour la recherche de film
        $encodedTitle = urlencode($title);
        $searchUrl = "{$this->baseUrl}/search/movie?api_key={$this->apiKey}&query={$encodedTitle}&language=fr-FR";
        
        // Exécution de l'appel HTTP et décodage des résultats de recherche globale
        $searchData = $this->makeRequest($searchUrl);

        if (empty($searchData['results'])) {
            return null; // Film non trouvé
        }

        // Extraction de l'ID natif unique pour ciblage précis
        $movieId = $searchData['results'][0]['id'];

        // Reconstruction d'une nouvelle URL pour requêter les crédits et détails pertinents
        $detailsUrl = "{$this->baseUrl}/movie/{$movieId}?api_key={$this->apiKey}&language=fr-FR&append_to_response=credits";
        
        // Déclenchement de la requête détaillée et contrôle de retour
        $movie = $this->makeRequest($detailsUrl);

        if (!$movie) return null;

        // Mise en forme et restitution du tableau d'informations exploitable par l'application locale
        return [
            'title'         => $movie['title'],
            'description'   => $movie['overview'],
            'release_date'  => $movie['release_date'],
            'duration'      => $movie['runtime'], // En minutes
            'cover_image'   => $movie['poster_path'] ? $this->imageBaseUrl . $movie['poster_path'] : null,
            'genres'        => $this->extractGenres($movie['genres'] ?? []),
            'director'      => $this->extractDirector($movie['credits']['crew'] ?? []),
            'casting'       => $this->extractCasting($movie['credits']['cast'] ?? [], 5) 
        ];
    }


    /** Lance une requête cURL
     *
     * @param string $url L'URL à visiter.
     * @return array|null Retourne les données décodées en JSON ou null
     */
    private function makeRequest($url) {
        // Initialisation de la librairie cURL pour l'interaction réseau
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Lancement de la transmission et capture du code HTTP de retour
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Libération correcte de la ressource système
        curl_close($ch);

        // Analyse du retour et blocage en cas d'erreur réseau ou timeout
        if ($response === false || $httpCode >= 400) {
            return null;
        }

        // Décodage au format JSON structuré pour exploitation au travers des tableaux PHP
        return json_decode($response, true);
    }

    /** Extrait les genres sous forme de texte
     *
     * @param array $genresArray Tableau des genres.
     * @return string Retourne les genres concaténés.
     */
    private function extractGenres($genresArray) {
        $names = array_map(function($g) { return $g['name']; }, $genresArray);
        return implode(', ', $names);
    }

    /** Extrait le réalisateur du film
     *
     * @param array $crewArray Tableau de l'équipe technique.
     * @return string Retourne le nom du réalisateur.
     */
    private function extractDirector($crewArray) {
        foreach ($crewArray as $crewMember) {
            if ($crewMember['job'] === 'Director') {
                return $crewMember['name'];
            }
        }
        return 'Inconnu';
    }

    /** Extrait les acteurs principaux
     *
     * @param array $castArray Tableau complet du casting.
     * @param int $limit Nombre d'acteurs à garder.
     * @return string Retourne les noms concaténés.
     */
    private function extractCasting($castArray, $limit = 5) {
        $topCast = array_slice($castArray, 0, $limit);
        $names = array_map(function($c) { return $c['name']; }, $topCast);
        return implode(', ', $names);
    }
}