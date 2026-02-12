<?php include_once __DIR__ . "/partials/header.php" ?>

<?php
// Données factices pour l'affichage (à remplacer plus tard par la base de données)
$movies = [
    [
        'title' => 'Inception',
        'genre' => 'Science-fiction',
        'duration' => '2h 28min',
        'image' => 'https://image.tmdb.org/t/p/w500/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg'
    ],
    [
        'title' => 'The Dark Knight',
        'genre' => 'Action, Crime',
        'duration' => '2h 32min',
        'image' => 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg'
    ],
    [
        'title' => 'Interstellar',
        'genre' => 'Aventure, Drame',
        'duration' => '2h 49min',
        'image' => 'https://image.tmdb.org/t/p/w500/gEU2QniL6E8ahMcafHC7347wAr4.jpg'
    ],
    [
        'title' => 'Avatar : La Voie de l\'eau',
        'genre' => 'Science-fiction, Action',
        'duration' => '3h 12min',
        'image' => 'https://image.tmdb.org/t/p/w500/t6HIqrRAclMCA60NsSmeqe9RmNV.jpg'
    ],
    [
        'title' => 'Top Gun: Maverick',
        'genre' => 'Action, Drame',
        'duration' => '2h 11min',
        'image' => 'https://image.tmdb.org/t/p/w500/62HCnUTziyWcpDaBO2i1DX17ljH.jpg'
    ],
     [
        'title' => 'Dune',
        'genre' => 'Science-fiction',
        'duration' => '2h 35min',
        'image' => 'https://image.tmdb.org/t/p/w500/d5NXSklXo0qyLXUdbVRvdEVnOTq.jpg'
    ]
];
?>

<div class="hero">
    <h1>Bienvenue sur AlluileCiné</h1>
    <p>Réservez vos places pour les meilleurs films du moment en quelques clics.</p>
</div>

<div class="container">
    <h2 class="section-title">À l'affiche actuellement</h2>
    
    <div class="movies-grid">
        <?php foreach($movies as $movie): ?>
            <div class="movie-card">
                <img src="<?= $movie['image'] ?>" alt="<?= $movie['title'] ?>" class="movie-poster">
                <div class="movie-info">
                    <h3 class="movie-title"><?= $movie['title'] ?></h3>
                    <div class="movie-genre"><?= $movie['genre'] ?></div>
                    <div class="movie-duration">
                        <i class="fa-regular fa-clock"></i> <?= $movie['duration'] ?>
                    </div>
                    <div class="movie-actions">
                        <a href="#" class="btn-book">
                            <i class="fa-solid fa-ticket"></i> Réserver
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include_once __DIR__ . "/partials/footer.php" ?>