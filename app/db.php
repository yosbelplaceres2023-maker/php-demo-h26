<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$host = $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['DB_NAME'] ?? '';
$user = $_ENV['DB_USER'] ?? '';
$password = $_ENV['DB_PASS'] ?? '';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=$charset",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
