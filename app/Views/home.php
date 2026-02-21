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
                <img src="<?= $movie['cover_image'] ?>" alt="<?= $movie['title'] ?>" class="movie-poster">
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

    <?php if (isset($totalPages) && $totalPages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn-page">&laquo; Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="btn-page <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn-page">Suivant &raquo;</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . "/partials/footer.php" ?>