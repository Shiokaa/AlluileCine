<div class="register-container">
    <h2>Créer un compte</h2>
    <form action="/register" method="POST">
        <div class="form-group">
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" id="firstname" required>
        </div>

        <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit">S'inscrire</button>
        <?php if (isset($_SESSION['error'])): ?>
            <p><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>
    </form>
</div>