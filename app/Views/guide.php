<?php include_once __DIR__ . "/partials/header.php" ?>

<div class="guide-page">
    <h1 class="guide-title">Guide d'utilisation</h1>
    <p class="guide-subtitle">Tout ce qu'il faut savoir pour utiliser AlluileCiné</p>

    <section class="guide-section">
        <div class="guide-section-header">
            <i class="fa-solid fa-users"></i>
            <h2>Comptes de test</h2>
        </div>
        <div class="guide-card">
            <p class="guide-card-desc">Après avoir exécuté les seeds, deux comptes sont disponibles :</p>
            <div class="guide-accounts">
                <div class="guide-account">
                    <span class="account-badge badge-admin">Admin</span>
                    <div class="account-info">
                        <p><i class="fa-solid fa-envelope"></i> admin@alluilecine.fr</p>
                        <p><i class="fa-solid fa-key"></i> password123</p>
                    </div>
                </div>
                <div class="guide-account">
                    <span class="account-badge badge-user">User</span>
                    <div class="account-info">
                        <p><i class="fa-solid fa-envelope"></i> jean.dupont@email.com</p>
                        <p><i class="fa-solid fa-key"></i> password123</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="guide-section">
        <div class="guide-section-header">
            <i class="fa-solid fa-screwdriver-wrench"></i>
            <h2>Configurer les séances (Admin)</h2>
        </div>
        <div class="guide-card">
            <div class="guide-warning">
                <i class="fa-solid fa-triangle-exclamation"></i>
                Sans séances programmées, les utilisateurs ne pourront pas réserver de places.
            </div>
            <div class="guide-steps-compact">
                <div class="compact-step">
                    <span class="step-number-sm">1</span>
                    <p>Se connecter avec le compte <strong>admin</strong></p>
                </div>
                <div class="compact-step">
                    <span class="step-number-sm">2</span>
                    <p>Accéder au <strong>Dashboard</strong> via la barre de navigation</p>
                </div>
                <div class="compact-step">
                    <span class="step-number-sm">3</span>
                    <p>Cliquer sur l'icône <i class="fa-solid fa-calendar-plus"></i> d'un film pour ajouter une séance</p>
                </div>
                <div class="compact-step">
                    <span class="step-number-sm">4</span>
                    <p>Sélectionner une <strong>salle</strong> et une <strong>date/heure</strong>, puis valider</p>
                </div>
            </div>
        </div>
    </section>

    <section class="guide-section">
        <div class="guide-section-header">
            <i class="fa-solid fa-ticket"></i>
            <h2>Réserver une place (Utilisateur)</h2>
        </div>
        <div class="guide-card">
            <div class="guide-steps-compact">
                <div class="compact-step">
                    <span class="step-number-sm">1</span>
                    <p>Se connecter ou créer un compte via l'<strong>inscription</strong></p>
                </div>
                <div class="compact-step">
                    <span class="step-number-sm">2</span>
                    <p>Cliquer sur un film depuis la <strong>page d'accueil</strong></p>
                </div>
                <div class="compact-step">
                    <span class="step-number-sm">3</span>
                    <p>Sélectionner un <strong>jour</strong> dans le calendrier, puis un <strong>horaire</strong></p>
                </div>
                <div class="compact-step">
                    <span class="step-number-sm">4</span>
                    <p>Cliquer sur <strong>Réserver une séance</strong> — un siège est automatiquement attribué</p>
                </div>
                <div class="compact-step">
                    <span class="step-number-sm">5</span>
                    <p>Retrouver ses réservations dans <strong>Mes réservations</strong> ou <strong>Mon compte</strong></p>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once __DIR__ . "/partials/footer.php" ?>
