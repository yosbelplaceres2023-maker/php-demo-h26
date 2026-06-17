<?php

require_once __DIR__ . '/db/connex.php';

$pageTitle = 'Messages';
$error = null;
$messages = [];

try {
    $statement = $pdo->query('SELECT * FROM messages ORDER BY created_at DESC');
    $messages = $statement->fetchAll();
} catch (PDOException $e) {
    $error = 'Impossible de charger les messages. Importe le fichier cours_fullstack.sql.';
}

include __DIR__ . '/header.php';
?>

<section class="panel form-panel">
    <div class="toolbar">
        <h2>Nouveau message</h2>
        <a class="button secondary" href="client_index.php">Retour aux clients</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <p class="flash success">Message ajoute.</p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <p class="flash error">Le message doit contenir entre 1 et 500 caracteres.</p>
    <?php endif; ?>

    <form action="message_store.php" method="post" class="form-grid">
        <label class="full">
            Message
            <textarea name="contenu" rows="4" maxlength="500" placeholder="Ecrire un message..." required></textarea>
        </label>

        <div class="form-actions full">
            <button type="submit">Ajouter</button>
        </div>
    </form>
</section>

<section class="panel">
    <div class="toolbar">
        <h2>Liste des messages</h2>
        <span><?= count($messages) ?> message<?= count($messages) > 1 ? 's' : '' ?></span>
    </div>

    <?php if ($error !== null): ?>
        <p class="flash error"><?= htmlspecialchars($error) ?></p>
    <?php elseif (count($messages) === 0): ?>
        <p class="empty">Aucun message pour le moment.</p>
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

<?php include __DIR__ . '/footer.php'; ?>
