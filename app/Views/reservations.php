<?php include_once __DIR__ . '/partials/header.php'; ?>
<link rel="stylesheet" href="/assets/css/reservations.css">

<div class="reservations-container">
    <div class="reservations-header">
        <h1 class="reservations-title">Mes Réservations</h1>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" style="background: rgba(229, 9, 20, 0.2); border: 1px solid #e50914; padding: 1rem; border-radius: 6px; color: white; margin-bottom: 2rem;">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success" style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; padding: 1rem; border-radius: 6px; color: white; margin-bottom: 2rem;">
            <?= htmlspecialchars($_SESSION['message']) ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($reservations)): ?>
        <div class="empty-state">
            <i class="fas fa-ticket-alt"></i>
            <h3>Aucune réservation trouvée</h3>
            <p>Vous n'avez pas encore réservé de séance pour le moment.</p>
            <a href="/" class="btn-browse">Parcourir les films</a>
        </div>
    <?php else: ?>
        <div class="ticket-grid">
            <?php foreach ($reservations as $ticket): 
                $sessionDate = strtotime($ticket['session_date']);
                $dateFormatted = date('d/m/Y', $sessionDate);
                $timeFormatted = date('H:i', $sessionDate);
                $poster = !empty($ticket['cover_image']) ? $ticket['cover_image'] : '/assets/img/default-movie.jpg';
            ?>
                <div class="ticket-card">
                    <div class="ticket-poster">
                        <img src="<?= htmlspecialchars($poster) ?>" alt="<?= htmlspecialchars($ticket['movie_title']) ?>">
                    </div>
                    
                    <div class="ticket-content">
                        <h3 class="ticket-title"><?= htmlspecialchars($ticket['movie_title']) ?></h3>
                        
                        <div class="ticket-detail">
                            <i class="fas fa-calendar-day"></i>
                            <span><?= $dateFormatted ?> à <?= $timeFormatted ?></span>
                        </div>
                        
                        <div class="ticket-detail">
                            <i class="fas fa-clock"></i>
                            <span><?= htmlspecialchars($ticket['duration']) ?> min</span>
                        </div>

                        <div class="ticket-seats-row">
                            <div class="ticket-badge">
                                <i class="fas fa-door-open"></i> <?= htmlspecialchars($ticket['room_name']) ?>
                            </div>
                            <div class="ticket-badge">
                                <i class="fas fa-chair"></i> Siège <?= htmlspecialchars($ticket['seat_number']) ?>
                            </div>
                        </div>
                        
                        <div style="margin-top: auto; padding-top: 1rem; font-size: 0.8rem; color: #666;">
                            Réservé le <?= date('d/m/Y', strtotime($ticket['reserved_at'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
