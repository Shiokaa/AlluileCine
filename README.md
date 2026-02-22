# 🎬 AlluileCiné

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![CSS](https://img.shields.io/badge/CSS3-Vanilla-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-Vanilla-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Composer](https://img.shields.io/badge/Composer-2.x-885630?style=for-the-badge&logo=composer&logoColor=white)
![TMDB](https://img.shields.io/badge/TMDB-API-01B4E4?style=for-the-badge&logo=themoviedatabase&logoColor=white)

Application web de réservation de places de cinéma développée en PHP avec une architecture **MVC** sans framework.

## ✨ Fonctionnalités

### Utilisateur
- **Inscription / Connexion** avec hashage `bcrypt` et protection CSRF
- **Se souvenir de moi** — session persistante via cookie (30 jours)
- **Expiration de session** automatique après 30 minutes d'inactivité
- **Page Compte** — profil avec les 3 dernières réservations
- **Modification du profil** — mise à jour du nom, prénom et email
- **Modification du mot de passe** — avec vérification de l'ancien mot de passe et confirmation
- **Réservation** — sélection de séance via calendrier interactif (7 jours) avec attribution automatique de siège
- **Historique** complet des réservations
- **Page Contact** — liens vers les réseaux sociaux des membres de l'équipe (GitHub, LinkedIn, Portfolio, Email)
- **Guide d'utilisation** — page dédiée décrivant le fonctionnement de l'application (comptes de test, gestion des séances, réservation)

### Administrateur
- **Dashboard** — gestion des films et des utilisateurs
- **Ajout de films** — recherche automatique via l'API TMDB (synopsis, casting, réalisateur, affiche, durée, genres)
- **Ajout de séances** — programmation par film avec choix de salle, vérification des conflits horaires
- **Suppression** de films et d'utilisateurs

## 🛠️ Stack technique

| Couche | Technologie |
|---|---|
| Langage | PHP 8+ (`strict_types`) |
| Architecture | MVC custom |
| Routing | [Phroute](https://github.com/mrjgreen/phroute) |
| Base de données | MySQL via PDO (Singleton) |
| Variables d'env | [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) |
| Autoloading | Composer PSR-4 |
| API externe | [TMDB](https://www.themoviedb.org/) |
| Front | HTML, CSS vanilla, JavaScript vanilla, Font Awesome |

## 📁 Structure du projet

```
AlluileCine/
├── app/
│   ├── Controllers/       # Contrôleurs (User, Movie, Reservation, Dashboard, Home)
│   ├── Middlewares/        # AuthMiddleware (requireAuth, requireGuest, requireAdmin)
│   ├── Models/             # Modèles PDO (User, Movie, Session, Reservation, Room, Seat)
│   ├── Services/           # TmdbService (API TMDB)
│   └── Views/              # Templates PHP + partials (header/footer)
├── config/
│   ├── Database/           # Singleton PDO + migrations + seeds
│   └── env.php             # Chargement du .env
├── helpers/
│   └── ResponseHandler.php # Formatage standardisé des réponses
├── public/
│   ├── index.php           # Point d'entrée (session, CSRF, routing)
│   └── assets/             # CSS + JS
├── routes/
│   └── router.php          # Définition de toutes les routes
├── .env                    # Variables d'environnement (non versionné)
└── composer.json
```

## 🚀 Installation

### Prérequis

- **PHP** 8.0+
- **Composer**
- **MySQL**

### Étapes

1. **Cloner le repo**

```bash
git clone https://github.com/Shiokaa/AlluileCine.git
cd AlluileCine
```

2. **Installer les dépendances**

```bash
composer install
```

3. **Configurer l'environnement**

Créer un fichier `.env` à la racine :

```env
host = "votre_host"
dbname = "AlluileCine"
username = "votre_username"
password = "votre_password"
```

> 💡 La clé API TMDB est directement intégrée dans `app/Services/TmdbService.php` pour faciliter les tests. Aucune configuration supplémentaire n'est nécessaire.

4. **Initialiser la base de données**

Exécuter les fichiers SQL dans l'ordre :

```bash
mysql -u root < config/Database/migrations/migrations.sql
mysql -u root < config/Database/seeds/seeds.sql
```

5. **Lancer le serveur**

```bash
php -S localhost:8080 -t public
```

L'application est accessible sur [http://localhost:8080](http://localhost:8080)

### Comptes de test (seeds)

| Rôle | Email | Mot de passe |
|---|---|---|
| Admin | `admin@alluilecine.fr` | `password123` |
| User | `jean.dupont@email.com` | `password123` |

## � Guide d'utilisation

### 1. Configurer les séances (Admin)

Avant de pouvoir réserver des places, un **administrateur** doit d'abord programmer des séances pour les films :

1. Se connecter avec le compte **admin** (`admin@alluilecine.fr`)
2. Accéder au **Dashboard** via la barre de navigation
3. Cliquer sur l'icône 📅 d'un film pour accéder au formulaire d'ajout de séance
4. Sélectionner une **salle** et une **date/heure**, puis valider

> ⚠️ Sans séances programmées, les utilisateurs ne pourront pas réserver de places sur les films.

### 2. Réserver une place (Utilisateur)

Une fois les séances créées par l'admin :

1. Se connecter avec un compte **utilisateur** (ou en créer un via l'inscription)
2. Cliquer sur un film depuis la **page d'accueil**
3. Sélectionner un **jour** dans le calendrier, puis un **horaire** parmi les séances disponibles
4. Cliquer sur **Réserver une séance** — un siège est automatiquement attribué
5. Retrouver ses réservations dans **Mes réservations** ou **Mon compte**

## �🔒 Sécurité

- **CSRF** — Jeton unique par session sur tous les formulaires
- **Mot de passe** — Hashé avec `password_hash()` / `bcrypt`
- **SQL Injection** — Requêtes préparées PDO avec `EMULATE_PREPARES = false`
- **XSS** — `htmlspecialchars()` sur toutes les sorties utilisateur
- **Session** — Expiration automatique, suppression du cookie côté client au logout
- **Singleton** — Clonage et désérialisation bloqués sur la connexion BDD

## 👥 Equipe

- [Amaru Tom](https://github.com/Shiokaa)
- [Champieux Timothé](https://github.com/timotheChampieux)

## 📝 Licence

Projet réalisé en groupe de 2 dans le cadre de la formation **B2 Informatique — Ynov**.
