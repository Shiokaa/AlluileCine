<?php include_once __DIR__ . '/partials/header.php'; ?>

<div class="register-container add-movie-container">
    <h2>Ajouter un Nouveau Film</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="form-error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <p class="form-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
    <?php endif; ?>

    <form action="/dashboard/addMovie" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="form-group">
            <label for="title">Titre du film</label>
            <input type="text" id="title" name="title" required placeholder="Ex: Inception">
        </div>

        <button type="submit" class="btn-gradient-submit">Ajouter le film</button>
        
        <div class="form-footer-container">
            <a href="/dashboard" class="form-footer-link">Retour au dashboard</a>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
