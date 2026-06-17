<?php

session_start();
require_once __DIR__ . '/../app/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$csrfToken = $_POST['csrf_token'] ?? '';
if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
    $_SESSION['flash_error'] = 'La requête est invalide.';
    header('Location: index.php');
    exit;
}

$contenu = trim($_POST['contenu'] ?? '');

if ($contenu === '' || strlen($contenu) > 500) {
    $_SESSION['flash_error'] = 'Le message doit contenir entre 1 et 500 caractères.';
    header('Location: index.php');
    exit;
}

    $statement = $pdo->prepare(
        "INSERT INTO messages (contenu) VALUES (:contenu)"
    );

    $statement->execute([
        'contenu' => $contenu
    ]);

$_SESSION['flash_success'] = 'Message ajouté.';
header('Location: index.php');
exit;