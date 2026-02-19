<?php include_once __DIR__ . '/partials/header.php'; ?>
<link rel="stylesheet" href="/assets/css/dashboard.css">

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Dashboard</h1>
        <a href="/movies/add" class="btn-add-movie">
            <i class="fas fa-plus"></i> Ajouter un film
        </a>
    </div>

    <div class="dashboard-grid">
        <!-- Section Films -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2><i class="fas fa-film"></i> Films</h2>
            </div>
            
            <div class="movies-grid">
                <?php if (isset($movie) && is_array($movie)): ?>
                    <?php foreach ($movie as $m): ?>
                        <div class="movie-card">
                            <div class="movie-poster-container">
                                <?php 
                                    // Utilisation de la cover image comme sur la home page
                                    $poster = !empty($m['cover_image']) ? '/assets/img/movies/' . $m['cover_image'] : '/assets/img/default-movie.jpg'; 
                                ?>
                                <img src="<?= htmlspecialchars($poster) ?>" alt="<?= htmlspecialchars($m['title']) ?>" class="movie-poster">
                            </div>
                            <div class="movie-info">
                                <h3 class="movie-title"><?= htmlspecialchars($m['title']) ?></h3>
                                <div class="movie-actions">
                                    <!-- Bouton modifier séances (inactif pour l'instant) -->
                                    <button class="btn-action btn-sessions" type="button">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                    
                                    <!-- Bouton Delete Movie -->
                                    <a href="/delete/movie/<?= $m['id'] ?>" class="btn-action btn-delete-card" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun film trouvé.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Section Utilisateurs -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2><i class="fas fa-users"></i> Utilisateurs</h2>
            </div>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($user) && is_array($user)): ?>
                        <?php foreach ($user as $u): ?>
                            <tr>
                                <td>
                                    <div class="item-info">
                                        <span><?= htmlspecialchars($u['fullname']) ?></span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($u['email']) ?></td>
                                <td>
                                    <a href="/delete/user/<?= $u['id'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Aucun utilisateur trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
