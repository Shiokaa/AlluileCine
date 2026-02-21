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
                    <?php if (!empty($recentReservations)): ?>
                        <?php foreach ($recentReservations as $res): ?>
                            <div class="reservation-card">
                                <div class="reservation-info">
                                    <div class="movie-title"><?= htmlspecialchars($res['movie_title']) ?></div>
                                    <div class="reservation-date">
                                        <?= date('d M Y - H:i', strtotime($res['session_date'])) ?>
                                    </div>
                                    <div style="font-size: 0.85rem; color: #a0a0a0; margin-top: 5px;">
                                        <i class="fas fa-door-open"></i> <?= htmlspecialchars($res['room_name']) ?> | 
                                        <i class="fas fa-chair"></i> Siège <?= htmlspecialchars($res['seat_number']) ?>
                                    </div>
                                </div>
                                <div class="reservation-status">
                                    <span class="status confirmed">Confirmé</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #a0a0a0; padding: 1rem 0;">Aucune réservation pour le moment.</p>
                    <?php endif; ?>

                    <div style="margin-top: 1rem; text-align: center;">
                        <a href="/reservations" style="color: #e94560; font-size: 0.9rem; text-decoration: underline;">Voir tout l'historique</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
