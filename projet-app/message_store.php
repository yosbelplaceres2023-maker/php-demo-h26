<?php

require_once __DIR__ . '/db/connex.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: message_index.php');
    exit;
}

$contenu = trim($_POST['contenu'] ?? '');

if ($contenu === '' || strlen($contenu) > 500) {
    header('Location: message_index.php?error=1');
    exit;
}

$statement = $pdo->prepare('INSERT INTO messages (contenu) VALUES (:contenu)');
$statement->execute(['contenu' => $contenu]);

header('Location: message_index.php?success=created');
exit;
