<?php include_once __DIR__ . '/partials/header.php'; ?>

<div class="container" style="min-height: calc(100vh - 200px); padding-top: 2rem;">
    <a href="/dashboard" class="btn-back"><i class="fas fa-arrow-left"></i> Retour au dashboard</a>
    
    <div class="add-session-layout">
        <div class="left-panel">
            <h2 class="form-title" style="text-align: left; margin-bottom: 1.5rem;">Détails du Film</h2>
            
            <div class="movie-summary">
                <img src="<?= htmlspecialchars($movie['cover_image']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="movie-summary-poster">
                <div class="movie-summary-details">
                    <h3><?= htmlspecialchars($movie['title']) ?></h3>
                    <div class="movie-summary-meta">
                        <i class="fas fa-clock"></i> <?= htmlspecialchars($movie['duration']) ?> min | <?= htmlspecialchars($movie['genre']) ?>
                    </div>
                    <p class="movie-summary-desc">
                        <?= htmlspecialchars(mb_substr($movie['description'], 0, 150)) ?>...
                    </p>
                </div>
            </div>

            <h3 style="color: white; border-bottom: 1px solid #333; padding-bottom: 0.5rem; margin-top: 2rem;">Séances Programmées</h3>
            <?php if (!empty($existingSessions)): ?>
                <ul class="sessions-list-container">
                    <?php foreach ($existingSessions as $es): ?>
                        <li class="session-list-item">
                            <span class="session-list-time">
                                <i class="fas fa-calendar-alt"></i> 
                                <?= date('d/m/Y H:i', strtotime($es['start_event'])) ?>
                            </span>
                            <span class="session-list-room">
                                <i class="fas fa-door-open"></i> <?= htmlspecialchars($es['room_name']) ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="no-sessions-text" style="margin-top: 1rem;">Aucune séance existante pour ce film.</p>
            <?php endif; ?>
        </div>
        
        <div class="right-panel">
            <h2 class="form-title">Ajouter une séance</h2>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['message']) ?>
                    <?php unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>

            <form action="/dashboard/movies/<?= $movie['id'] ?>/addSession" method="POST">
                <div class="form-group">
                    <label for="room_id">Salle</label>
                    <select name="room_id" id="room_id" class="form-control" required>
                        <option value="" disabled selected>-- Sélectionnez une salle --</option>
                        <?php if (!empty($rooms)): ?>
                            <?php foreach ($rooms as $room): ?>
                                <option value="<?= $room['id'] ?>">
                                    <?= htmlspecialchars($room['name']) ?> (Capacité : <?= $room['capacity'] ?> places)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="start_event">Date et heure de début</label>
                    <input type="datetime-local" id="start_event" name="start_event" class="form-control" required>
                </div>

                <button type="submit" class="btn-submit">Créer la séance</button>
            </form>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
