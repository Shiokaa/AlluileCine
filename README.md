# AlluileCine

# Configuration .env

```env
host = "localhost"
dbname = "AlluileCine"
username = "votre_utilisateur"
password = "votre_mot_de_passe"
```

# Lancement du projet

- Avoir composer installer ainsi que PHP

```bash
composer install
```

- Avoir le .env à la racine avec les variables écritent plus haut

```bash
php -S localhost:8080 -t public
```

# Etat du projet :

✅ Ce qui fonctionne

- Architecture MVC
- Routage via PHroute
- Register et Login
- Connexion à la BDD via pattern singleton
- Lancement du projet via l'index.php dans le dossier public
- Un ResponseHandler pour formatter les réponses facilement
- Initialisation de la session lorsque l'utilisateur se login, ainsi qu'une session qui permet d'enregistrer les erreurs etc lorsque l'utilisateur n'est pas connecté

⏳ A faire ensuite

- Mise en place du model pour les films
- Rajouter des commentaires pour affiner la doc
