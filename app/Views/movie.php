<?php include __DIR__ . '/partials/header.php'; ?>

<main class="main-content">
    <div class="movie-detail-card">
        <div class="movie-detail-poster">
            <img src="<?= htmlspecialchars($movie['cover_image']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
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

            <div class="movie-start-time">
                <h3>Prochaines séances</h3>

                <!-- Date Carousel -->
                <div class="date-carousel">
                    <?php if (!empty($calendarDates)): ?>
                        <?php foreach ($calendarDates as $index => $day): ?>
                            <div class="date-card <?= $index === 0 ? 'active' : '' ?>" 
                                 onclick="filterSessions('<?= $day['date'] ?>', this)">
                                <span class="day-name"><?= $day['day_name'] ?></span>
                                <span class="day-number"><?= $day['day_num'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Sessions List -->
                <div class="sessions-container">
                    <?php if (!empty($calendarDates)): ?>
                        <?php foreach ($calendarDates as $day): 
                            $currentDate = $day['date'];
                            $hasSessions = isset($sessionsByDate[$currentDate]);
                        ?>
                            <div class="sessions-day-group" id="sessions-<?= $currentDate ?>" 
                                 style="display: <?= $day === $calendarDates[0] ? 'flex' : 'none' ?>;">
                                <?php if ($hasSessions): ?>
                                    <?php foreach ($sessionsByDate[$currentDate] as $session): ?>
                                        <div class="session-item" 
                                             data-session-id="<?= $session['id'] ?>"
                                             data-session-date="<?= $currentDate ?>"
                                             data-session-time="<?= date('H:i', strtotime($session['start_event'])) ?>"
                                             onclick="selectSession(this)">
                                            <i class="far fa-clock"></i> 
                                            <?= date('H:i', strtotime($session['start_event'])) ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p style="color: #a0a0a0; margin: 10px 0;">Aucune séance prévue pour ce jour.</p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="movie-detail-actions">
                <form action="/reservation" method="POST" id="booking-form">
                    <input type="hidden" name="session_id" id="session-id-input" value="">
                    <button type="submit" class="btn btn-book" id="btn-book">Réserver une séance</button>
                </form>
                <p id="booking-hint" class="booking-hint">Veuillez sélectionner un horaire ci-dessus.</p>
                <p id="booking-selection" class="booking-selection" style="display: none;"></p>
            </div>
        </div>
    </div>
</main>

<script src="/assets/js/movie.js"></script>
<?php include __DIR__ . '/partials/footer.php'; ?>