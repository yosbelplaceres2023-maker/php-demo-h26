<?php

require_once __DIR__ . '/db/connex.php';

$pageTitle = 'Liste des clients';
$error = null;
$clients = [];

try {
    $statement = $pdo->query(
        'SELECT clients.*, cities.name AS city_name
         FROM clients
         LEFT JOIN cities ON cities.id = clients.city_id
         ORDER BY clients.id DESC'
    );
    $clients = $statement->fetchAll();
} catch (PDOException $e) {
    $error = 'Impossible de charger les clients. Importe le fichier cours_fullstack.sql.';
}

include __DIR__ . '/header.php';
?>

<section class="panel">
    <div class="toolbar">
        <h2>Clients</h2>
        <a class="button" href="client_create.php">Ajouter un client</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <p class="flash success">Operation reussie.</p>
    <?php endif; ?>

    <?php if ($error !== null): ?>
        <p class="flash error"><?= htmlspecialchars($error) ?></p>
    <?php elseif (count($clients) === 0): ?>
        <p class="empty">Aucun client pour le moment.</p>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Ville</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) $client['id']) ?></td>
                            <td>
                                <?= htmlspecialchars($client['first_name']) ?>
                                <?= htmlspecialchars($client['last_name']) ?>
                            </td>
                            <td><?= htmlspecialchars($client['email']) ?></td>
                            <td><?= htmlspecialchars($client['phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($client['city_name'] ?? 'Sans ville') ?></td>
                            <td class="actions">
                                <a href="client_show.php?id=<?= urlencode((string) $client['id']) ?>">Voir</a>
                                <a href="client_edit.php?id=<?= urlencode((string) $client['id']) ?>">Modifier</a>
                                <a class="danger" href="client_delete.php?id=<?= urlencode((string) $client['id']) ?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>
