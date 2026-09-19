# MALIMACK — GitHub + Vercel

Plateforme musicale PHP/MySQL — « La musique malienne, partout avec toi. »

## Vercel
This project is prepared for Vercel using `Dockerfile.vercel` and FrankenPHP.

Set these Environment Variables in Vercel:

```text
DB_HOST
DB_NAME
DB_USER
DB_PASSWORD
DB_PORT=3306
```

Never commit the real MySQL password to GitHub.

## Database
Import `database/malimack.sql` into your MySQL/MariaDB database.

## Media
`uploads/` remains in the project for InfinityFree compatibility. For a Vercel production deployment, use persistent/external storage for MP3s and covers instead of relying on the deployment filesystem.

## Admin

```text
/admin/login.php
```

## GitHub
Upload the contents of this project to the root of your GitHub repository.
