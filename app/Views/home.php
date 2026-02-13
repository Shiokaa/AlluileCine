<?php include_once __DIR__ . "/partials/header.php" ?>

<div class="hero">
    <h1>Bienvenue sur AlluileCiné</h1>
    <p>Réservez vos places pour les meilleurs films du moment en quelques clics.</p>
</div>

<div class="container">
    <h2 class="section-title">À l'affiche actuellement</h2>
    
    <div class="movies-grid">
        <?php if ($response['status']): ?>
        <?php foreach($movies as $movie): ?>
            <div class="movie-card">
                <img src="<?= "/assets/img/movies/". $movie['cover_image'] ?>" alt="<?= $movie['title'] ?>" class="movie-poster">
                <div class="movie-info">
                    <h3 class="movie-title"><?= $movie['title'] ?></h3>
                    <div class="movie-genre"><?= $movie['genre'] ?></div>
                    <div class="movie-duration">
                        <i class="fa-regular fa-clock"></i> <?= floor($movie['duration'] / 60) ?>h <?= str_pad($movie['duration'] % 60, 2, '0', STR_PAD_LEFT) ?>min
                    </div>
                    <div class="movie-actions">
                        <a href="/movies/<?= $movie['id'] ?>" class="btn-book">
                            <i class="fa-solid fa-ticket"></i> Réserver
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
                <p><?= $response['message'] ?></p>
        <?php endif; ?>
    </div>
</div>

<?php include_once __DIR__ . "/partials/footer.php" ?>