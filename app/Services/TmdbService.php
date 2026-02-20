<?php

namespace App\Services;

class TmdbService {
    private $apiKey;
    private $baseUrl;
    private $imageBaseUrl;

    public function __construct() {
        $this->apiKey = "cc694f5edc9311dd9f5a477f86bc8f8b";
        $this->baseUrl = "https://api.themoviedb.org/3";
        $this->imageBaseUrl = "https://image.tmdb.org/t/p/w500";
    }

    public function getFullMovieDetails($title) {
        $encodedTitle = urlencode($title);
        $searchUrl = "{$this->baseUrl}/search/movie?api_key={$this->apiKey}&query={$encodedTitle}&language=fr-FR";
        
        $searchData = $this->makeRequest($searchUrl);

        if (empty($searchData['results'])) {
            return null; // Film non trouvé
        }

        $movieId = $searchData['results'][0]['id'];

        $detailsUrl = "{$this->baseUrl}/movie/{$movieId}?api_key={$this->apiKey}&language=fr-FR&append_to_response=credits";
        
        $movie = $this->makeRequest($detailsUrl);

        if (!$movie) return null;

  
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


    private function makeRequest($url) {
       
        $response = @file_get_contents($url);
        return $response ? json_decode($response, true) : null;
    }

    private function extractGenres($genresArray) {
  
        $names = array_map(function($g) { return $g['name']; }, $genresArray);
        return implode(', ', $names);
    }

    private function extractDirector($crewArray) {
        foreach ($crewArray as $crewMember) {
    
            if ($crewMember['job'] === 'Director') {
                return $crewMember['name'];
            }
        }
        return 'Inconnu';
    }

    private function extractCasting($castArray, $limit = 5) {

        $topCast = array_slice($castArray, 0, $limit);
        $names = array_map(function($c) { return $c['name']; }, $topCast);
        return implode(', ', $names);
    }
}