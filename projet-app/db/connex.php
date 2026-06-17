<?php

$envPaths = [
    __DIR__ . '/../.env',
    __DIR__ . '/../../.env',
];

foreach ($envPaths as $envPath) {
    if (!is_file($envPath)) {
        continue;
    }

    $envValues = parse_ini_file($envPath, false, INI_SCANNER_RAW);

    if (is_array($envValues)) {
        foreach ($envValues as $key => $value) {
            if (!isset($_ENV[$key])) {
                $_ENV[$key] = $value;
            }
        }
    }

    break;
}

function env_value(string $key, string $default = ''): string
{
    if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
        return $_ENV[$key];
    }

    $value = getenv($key);
    return $value === false || $value === '' ? $default : $value;
}

$host = env_value('DB_HOST', 'localhost');
$dbname = env_value('DB_NAME', 'cours_fullstack');
$user = env_value('DB_USER', 'root');
$password = env_value('DB_PASS', '');
$charset = env_value('DB_CHARSET', 'utf8mb4');

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=$charset",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    $connex = $pdo;
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
