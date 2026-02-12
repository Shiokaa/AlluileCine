<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlluileCiné</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <header class="site-header">
        <div class="header-container">
            <a href="/" class="logo">🎬 AlluileCiné</a>
            <button class="burger-btn" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav class="main-nav">
                <ul>
                    <li><a href="/">Accueil</a></li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li><a href="/reservations">Mes réservations</a></li>
                        <li><a href="/account">Mon compte</a></li>
                        <li><a href="/logout" class="btn-logout">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="/login">Connexion</a></li>
                        <li><a href="/register" class="btn-register">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main-content">