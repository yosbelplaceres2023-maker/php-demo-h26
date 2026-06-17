<?php

require_once __DIR__ . '/db/connex.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'create';

    try {
        if ($action === 'delete') {
            $statement = $pdo->prepare('DELETE FROM cities WHERE id = :id');
            $statement->execute(['id' => (int) ($_POST['id'] ?? 0)]);
        } else {
            $name = trim($_POST['name'] ?? '');

            if ($name !== '') {
                $statement = $pdo->prepare('INSERT INTO cities (name) VALUES (:name)');
                $statement->execute(['name' => $name]);
            }
        }

        header('Location: city_index.php?success=1');
        exit;
    } catch (PDOException $e) {
        $error = 'Impossible de modifier cette ville.';
    }
}

$pageTitle = 'Liste des villes';
$cities = [];

try {
    $cities = $pdo->query(
        'SELECT cities.*, COUNT(clients.id) AS total_clients
         FROM cities
         LEFT JOIN clients ON clients.city_id = cities.id
         GROUP BY cities.id
         ORDER BY cities.name'
    )->fetchAll();
} catch (PDOException $e) {
    $error = 'Impossible de charger les villes. Importe le fichier cours_fullstack.sql.';
}

include __DIR__ . '/header.php';
?>

<section class="panel form-panel">
    <h2>Ajouter une ville</h2>

    <form action="city_index.php" method="post" class="inline-form">
        <input type="text" name="name" maxlength="120" placeholder="Nom de la ville" required>
        <button type="submit">Ajouter</button>
    </form>
</section>

<section class="panel">
    <div class="toolbar">
        <h2>Villes</h2>
        <a class="button secondary" href="client_index.php">Voir les clients</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <p class="flash success">Operation reussie.</p>
    <?php endif; ?>

    <?php if ($error !== null): ?>
        <p class="flash error"><?= htmlspecialchars($error) ?></p>
    <?php elseif (count($cities) === 0): ?>
        <p class="empty">Aucune ville pour le moment.</p>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ville</th>
                        <th>Clients</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cities as $city): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) $city['id']) ?></td>
                            <td><?= htmlspecialchars($city['name']) ?></td>
                            <td><?= htmlspecialchars((string) $city['total_clients']) ?></td>
                            <td class="actions">
                                <form action="city_index.php" method="post">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars((string) $city['id']) ?>">
                                    <button class="link danger" type="submit">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>
