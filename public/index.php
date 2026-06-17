<?php

session_start();
require_once __DIR__ . '/../app/db.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$flashSuccess = $_SESSION['flash_success'] ?? null;
$flashError = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_success'], $_SESSION['flash_error']);

$statement = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Application PHP + MySQL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="page">
        <section class="hero">
            <p class="eyebrow">NGINX / PHP / MySQL</p>
            <h1>Application full stack avec NGINX, PHP et MySQL</h1>
            <p class="subtitle">Ajoutez un message, puis voyez-le apparaître immédiatement dans la liste.</p>
        </section>

        <section class="panel">
            <?php if ($flashSuccess !== null): ?>
                <p class="flash flash-success"><?= htmlspecialchars($flashSuccess) ?></p>
            <?php endif; ?>

            <?php if ($flashError !== null): ?>
                <p class="flash flash-error"><?= htmlspecialchars($flashError) ?></p>
            <?php endif; ?>

            <form class="message-form" action="ajouter.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                <label for="contenu">Nouveau message</label>
                <div class="form-row">
                    <input type="text" id="contenu" name="contenu" placeholder="Écrire un message..." required>
                    <button type="submit">Ajouter</button>
                </div>
            </form>
        </section>

        <section class="panel">
            <div class="section-head">
                <h2>Messages</h2>
                <span><?= count($messages) ?> message<?= count($messages) > 1 ? 's' : '' ?></span>
            </div>

            <?php if (count($messages) === 0): ?>
                <p class="empty-state">Aucun message pour le moment.</p>
            <?php else: ?>
                <ul class="message-list">
                    <?php foreach ($messages as $message): ?>
                        <li class="message-item">
                            <div class="message-content"><?= htmlspecialchars($message['contenu']) ?></div>
                            <small><?= htmlspecialchars($message['created_at']) ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>