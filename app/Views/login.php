<?php include __DIR__ . '/partials/header.php'; ?>

<div class="login-container">
    <h2>Connexion</h2>
    <form action="/login" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit">Se connecter</button>
        <?php if (isset($_SESSION['error'])): ?>
            <p class="error-message"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php endif; ?>
    </form>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>