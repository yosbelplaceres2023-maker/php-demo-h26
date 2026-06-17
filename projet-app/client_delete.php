<?php

require_once __DIR__ . '/db/connex.php';

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $statement = $pdo->prepare('DELETE FROM clients WHERE id = :id');
    $statement->execute(['id' => $id]);

    header('Location: client_index.php?success=deleted');
    exit;
}

$statement = $pdo->prepare('SELECT id, first_name, last_name FROM clients WHERE id = :id');
$statement->execute(['id' => $id]);
$client = $statement->fetch();

if (!$client) {
    header('Location: client_index.php');
    exit;
}

$pageTitle = 'Supprimer un client';
include __DIR__ . '/header.php';
?>

<section class="panel">
    <h2>Supprimer le client</h2>
    <p>
        Voulez-vous supprimer
        <strong>
            <?= htmlspecialchars($client['first_name']) ?>
            <?= htmlspecialchars($client['last_name']) ?>
        </strong>
        ?
    </p>

    <form action="client_delete.php" method="post" class="form-actions">
        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $client['id']) ?>">
        <button class="danger" type="submit">Supprimer</button>
        <a class="button secondary" href="client_index.php">Annuler</a>
    </form>
</section>

<?php include __DIR__ . '/footer.php'; ?>
