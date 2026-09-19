# MALIMACK — InfinityFree

**La musique malienne, partout avec toi.**

Application de streaming musical PHP + MySQL/MariaDB, pensée pour un hébergement mutualisé comme InfinityFree.

## 1. Architecture

- PHP 8+
- MySQL/MariaDB
- PDO + requêtes préparées
- HTML5 / CSS3 / JavaScript vanilla
- Bootstrap 5 et Font Awesome via CDN
- Authentification PHP par sessions
- Administration protégée par rôle
- Upload MP3 + covers
- Lecteur audio HTML5/JavaScript
- Favoris, playlists, historique
- Compteur de lectures après environ 10 secondes d'écoute
- Téléchargement contrôlé par le champ `downloadable`

## 2. Installation locale

1. Placez le dossier `malimack` dans votre serveur PHP (XAMPP, WAMP, Laragon, etc.).
2. Créez une base MySQL.
3. Importez `database/malimack.sql` dans phpMyAdmin.
4. Ouvrez `config/database.php`.
5. Remplacez :
   - `NOM_BASE`
   - `UTILISATEUR`
   - `MOT_DE_PASSE`
   - et le host si votre hébergeur en fournit un différent.
6. Vérifiez que PHP peut écrire dans `uploads/music` et `uploads/covers`.
7. Ouvrez `index.php`.

## 3. Installation sur InfinityFree

1. Créez votre hébergement InfinityFree et votre base MySQL.
2. Dans le panneau MySQL, notez exactement :
   - MySQL Hostname
   - MySQL Database Name
   - MySQL Username
   - MySQL Password
3. Importez `database/malimack.sql` avec phpMyAdmin.
4. Ouvrez `config/database.php` et remplacez les valeurs d'exemple.
5. Envoyez **le contenu du dossier `malimack`** dans `htdocs`.
6. Conservez les dossiers `uploads/music` et `uploads/covers`.
7. Vérifiez que les fichiers `.htaccess` sont bien présents.
8. Visitez votre domaine.

> InfinityFree peut imposer des limites d'upload ou des paramètres PHP spécifiques. Si un MP3 de 15 Mo est refusé par l'hébergeur, réduisez la limite dans `admin/add-song.php` ou utilisez un fichier plus petit.

## 4. Créer le compte administrateur

1. Ouvrez `register.php`.
2. Créez votre compte avec votre email.
3. Dans phpMyAdmin, exécutez :

```sql
UPDATE users SET role='admin' WHERE email='VOTRE_EMAIL';
```

4. Connectez-vous ensuite sur `/admin/login.php`.

## 5. Ajouter la première musique

1. Connectez-vous comme administrateur.
2. Ouvrez `/admin/add-song.php`.
3. Sélectionnez un artiste.
4. Sélectionnez éventuellement un album.
5. Ajoutez une cover JPG/JPEG/PNG/WebP.
6. Ajoutez le MP3.
7. Cochez « Téléchargement autorisé » seulement si vous souhaitez autoriser le téléchargement.

## 6. Ajouter artistes et albums

- `/admin/artists.php` : créer un artiste et sa photo.
- `/admin/albums.php` : créer un album lié à un artiste.
- Puis `/admin/add-song.php` : associer les morceaux.

## 7. Sécurité

- Les mots de passe sont hachés avec `password_hash()`.
- La connexion utilise `password_verify()`.
- Les requêtes SQL utilisent PDO et des paramètres.
- Les sorties HTML passent par `htmlspecialchars()`.
- Les formulaires sensibles utilisent un token CSRF.
- Les uploads utilisent MIME + extension + taille + nom aléatoire.
- Les dossiers d'uploads refusent l'exécution des fichiers PHP via `.htaccess`.
- Les identifiants MySQL restent côté PHP.

## 8. Déploiement / domaine

Dans le panneau de votre hébergeur, pointez votre domaine ou sous-domaine vers le dossier `htdocs` selon les instructions fournies par InfinityFree.

## 9. Vérification rapide après déploiement

- `index.php` s'affiche.
- `register.php` crée un compte.
- `login.php` connecte l'utilisateur.
- `/admin/login.php` refuse les comptes non-admin.
- Les artistes/albums peuvent être créés.
- Une musique peut être uploadée.
- Le lecteur lance le MP3.
- Le compteur augmente après une vraie écoute.
- Les covers sont visibles.
- Les pages artiste/album fonctionnent.
- Les fichiers statiques CSS/JS se chargent.

## 10. Important sur les droits musicaux

N'envoyez et ne diffusez que des enregistrements pour lesquels vous disposez des droits ou autorisations nécessaires. Le code n'accorde aucun droit d'exploitation sur une musique.

## 11. Dépannage

### Erreur de connexion MySQL
Revérifiez `config/database.php`, surtout le hostname fourni par InfinityFree.

### Erreur 404
Vérifiez que les fichiers sont directement dans `htdocs` et que les liens relatifs n'ont pas été modifiés.

### Erreur 500
Vérifiez les journaux PHP disponibles dans votre hébergement et la version PHP configurée.

### Upload refusé
Vérifiez les limites PHP de l'hébergeur et la taille du fichier.

### Le MP3 ne se lit pas
Vérifiez que le fichier est réellement un MP3 valide et que le chemin enregistré en base commence par `uploads/music/`.
