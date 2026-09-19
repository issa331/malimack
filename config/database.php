<?php
declare(strict_types=1);

/*
 * MALIMACK — Database configuration
 * Vercel/GitHub: credentials come from environment variables.
 */

$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: '';
$username = getenv('DB_USER') ?: '';
$password = getenv('DB_PASSWORD') ?: '';
$port = getenv('DB_PORT') ?: '3306';

if ($dbname === '' || $username === '') {
    http_response_code(500);
    exit('Configuration MySQL manquante. Configurez DB_NAME et DB_USER.');
}

$dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Connexion à la base de données impossible.');
}
?>
