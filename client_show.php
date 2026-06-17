<?php

require_once __DIR__ . '/db/connex.php';

$id = (int) ($_GET['id'] ?? 0);

$statement = $pdo->prepare(
    'SELECT clients.*, cities.name AS city_name
     FROM clients
     LEFT JOIN cities ON cities.id = clients.city_id
     WHERE clients.id = :id'
);
$statement->execute(['id' => $id]);
$client = $statement->fetch();

if (!$client) {
    header('Location: client_index.php');
    exit;
}

$pageTitle = 'Detail du client';
include __DIR__ . '/header.php';
?>

<section class="panel">
    <div class="toolbar">
        <h2>
            <?= htmlspecialchars($client['first_name']) ?>
            <?= htmlspecialchars($client['last_name']) ?>
        </h2>
        <a class="button secondary" href="client_index.php">Retour</a>
    </div>

    <dl class="details">
        <dt>Email</dt>
        <dd><?= htmlspecialchars($client['email']) ?></dd>

        <dt>Telephone</dt>
        <dd><?= htmlspecialchars($client['phone'] ?: '-') ?></dd>

        <dt>Adresse</dt>
        <dd><?= htmlspecialchars($client['address'] ?: '-') ?></dd>

        <dt>Ville</dt>
        <dd><?= htmlspecialchars($client['city_name'] ?: '-') ?></dd>

        <dt>Date de creation</dt>
        <dd><?= htmlspecialchars($client['created_at']) ?></dd>
    </dl>

    <div class="form-actions">
        <a class="button" href="client_edit.php?id=<?= urlencode((string) $client['id']) ?>">Modifier</a>
        <a class="button danger" href="client_delete.php?id=<?= urlencode((string) $client['id']) ?>">Supprimer</a>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
