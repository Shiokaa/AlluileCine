<?php include_once __DIR__ . "/partials/header.php" ?>

<?php
    $nameParts = explode(' ', $user['fullname'], 2);
    $lastName = $nameParts[0] ?? '';
    $firstName = $nameParts[1] ?? '';
?>

<div class="main-content">
    <div class="account-container">
        <div class="account-header">
            <div class="account-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="account-info">
                <h1>Mon Profil</h1>
                <p class="email"><?= htmlspecialchars($user['email'])?></p>
            </div>
        </div>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['message']) ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="account-sections">

            <section class="account-section">
                <h2>Informations Personnelles</h2>
                <form action="/account/update-profile" method="POST" class="account-edit-form">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <div class="account-form-grid">
                        <div class="form-group">
                            <label for="lastname">Nom</label>
                            <input type="text" name="lastname" id="lastname" value="<?= htmlspecialchars($lastName) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="firstname">Prénom</label>
                            <input type="text" name="firstname" id="firstname" value="<?= htmlspecialchars($firstName) ?>" required>
                        </div>
                        <div class="form-group full-width">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-account-save">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                </form>
            </section>

            <section class="account-section">
                <h2>Modifier le mot de passe</h2>
                <form action="/account/update-password" method="POST" class="account-edit-form">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <div class="account-form-grid">
                        <div class="form-group full-width">
                            <label for="current_password">Mot de passe actuel</label>
                            <input type="password" name="current_password" id="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Nouveau mot de passe</label>
                            <input type="password" name="new_password" id="new_password" required minlength="8">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirmer le mot de passe</label>
                            <input type="password" name="confirm_password" id="confirm_password" required minlength="8">
                        </div>
                    </div>
                    <button type="submit" class="btn-account-save">
                        <i class="fas fa-lock"></i> Modifier le mot de passe
                    </button>
                </form>
            </section>

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
                                    <div class="reservation-meta">
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
                        <p class="no-reservations">Aucune réservation pour le moment.</p>
                    <?php endif; ?>

                    <div class="view-all-container">
                        <a href="/reservations" class="view-all-link">Voir tout l'historique</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
