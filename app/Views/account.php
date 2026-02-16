<?php include_once __DIR__ . "/partials/header.php" ?>

<div class="main-content">
    <div class="account-container">
        <div class="account-header">
            <div class="account-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="account-info">
                <h1>Mon Profil</h1>
                <p class="email"><?= $user['email']?></p>
            </div>
        </div>

        <div class="account-sections">
            <!-- Informations Personnelles Section -->
            <section class="account-section">
                <h2>Informations Personnelles</h2>
                <div class="account-details">
                    <div class="detail-group">
                        <span class="detail-label">Nom d'utilisateur</span>
                        <span class="detail-value"><?= strtoupper($user['fullname'])?></span>
                    </div>

                    <div class="detail-group full-width">
                        <span class="detail-label">Email</span>
                        <span class="detail-value"><?= $user['email']?></span>
                    </div>
                </div>
            </section>

            <!-- Dernières Réservations Section -->
            <section class="account-section">
                <h2>Mes Dernières Réservations</h2>
                <div class="reservations-preview">
                    <div class="reservation-card">
                        <div class="reservation-info">
                            <div class="movie-title">Inception</div>
                            <div class="reservation-date">24 Fév 2024 - 20:30</div>
                        </div>
                        <div class="reservation-status">
                            <span class="status confirmed">Confirmé</span>
                        </div>
                    </div>

                    <div class="reservation-card">
                        <div class="reservation-info">
                            <div class="movie-title">Dune: Part Two</div>
                            <div class="reservation-date">15 Mar 2024 - 18:00</div>
                        </div>
                        
                        <div class="reservation-status">
                            <span class="status confirmed">Confirmé</span>
                        </div>
                    </div>

                    <div style="margin-top: 1rem; text-align: center;">
                        <a href="/reservations" style="color: #e94560; font-size: 0.9rem; text-decoration: underline;">Voir tout l'historique</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
