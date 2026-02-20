<?php include_once __DIR__ . '/partials/header.php'; ?>

<div class="register-container" style="max-width: 600px;">
    <h2>Ajouter un nouveau film</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: #ff4d4d; text-align: center; margin-bottom: 1rem;"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <p style="color: #4dff4d; text-align: center; margin-bottom: 1rem;"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
    <?php endif; ?>

    <form action="/dashboard/addMovie" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Titre du film</label>
            <input type="text" id="title" name="title" required placeholder="Ex: Inception">
        </div>

        <div class="form-group">
            <label for="description">Description (Synopsis)</label>
            <textarea id="description" name="description" required placeholder="Résumez l'histoire du film..."></textarea>
        </div>

        <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" required placeholder="Ex: Science-fiction">
            </div>
            <div>
                <label for="director">Réalisateur</label>
                <input type="text" id="director" name="director" required placeholder="Ex: Christopher Nolan">
            </div>
        </div>

        <div class="form-group">
            <label for="casting">Casting (Acteurs principaux)</label>
            <input type="text" id="casting" name="casting" placeholder="Ex: Leonardo DiCaprio, Joseph Gordon-Levitt...">
        </div>

        <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <label for="duration">Durée (en minutes)</label>
                <input type="number" id="duration" name="duration" required min="1" placeholder="Ex: 148">
            </div>
            <div>
                <label for="release_date">Date de sortie</label>
                <input type="date" id="release_date" name="release_date" required>
            </div>
        </div>

        <div class="form-group">
            <label for="cover_image">Affiche du film</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" required style="padding: 0.5rem; background-color: #0f3460;">
        </div>

        <button type="submit" style="background: linear-gradient(135deg, #e94560 0%, #0f3460 100%); color: white; border: none; padding: 1rem; font-weight: bold; border-radius: 8px; cursor: pointer; margin-top: 1rem; width: 100%;">Ajouter le film</button>
        
        <div style="text-align: center; margin-top: 1rem;">
            <a href="/dashboard" style="color: #a0a0a0; font-size: 0.9rem;">Retour au dashboard</a>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
