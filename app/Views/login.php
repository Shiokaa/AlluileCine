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

        <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem; flex-direction: row;">
            <input type="checkbox" name="remember_me" id="remember_me" style="width: auto; margin: 0;">
            <label for="remember_me" style="margin: 0; font-weight: normal;">Se souvenir de moi</label>
        </div>

        <button type="submit">Se connecter</button>
        <?php if (isset($_SESSION['error'])): ?>
            <p class="error-message"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php endif; ?>
    </form>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>