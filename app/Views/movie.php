<?php include __DIR__ . '/partials/header.php'; ?>

<main class="main-content">
    <div class="movie-detail-card">
        <div class="movie-detail-poster">
            <img src="/assets/img/movies/<?= htmlspecialchars($movie['cover_image']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
        </div>
        <div class="movie-detail-info">
            <h1 class="movie-detail-title"><?= htmlspecialchars($movie['title']) ?></h1>
            
            <div class="movie-detail-meta">
                <span class="movie-genre"><?= htmlspecialchars($movie['genre']) ?></span>
                <span class="movie-duration">
                    <i class="fas fa-clock"></i> <?= htmlspecialchars($movie['duration']) ?> min
                </span>
                <span class="movie-release-date" style="color: #a0a0a0;">
                    <i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($movie['release_date']) ?>
                </span>
            </div>

            <div class="movie-description">
                <h2>Synopsis</h2>
                <p><?= nl2br(htmlspecialchars($movie['description'])) ?></p>
                
                <?php if (!empty($movie['director'])): ?>
                    <p><strong>Réalisateur :</strong> <?= htmlspecialchars($movie['director']) ?></p>
                <?php endif; ?>
                
                <?php if (!empty($movie['casting'])): ?>
                    <p><strong>Casting :</strong> <?= htmlspecialchars($movie['casting']) ?></p>
                <?php endif; ?>
            </div>

            <div class="movie-detail-actions">
                <a href="#" class="btn btn-book">Réserver une séance</a>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>