<?php

require_once __DIR__ . '/db/connex.php';

$id = (int) ($_GET['id'] ?? 0);

$statement = $pdo->prepare('SELECT * FROM clients WHERE id = :id');
$statement->execute(['id' => $id]);
$client = $statement->fetch();

if (!$client) {
    header('Location: client_index.php');
    exit;
}

$cities = $pdo->query('SELECT id, name FROM cities ORDER BY name')->fetchAll();

$pageTitle = 'Modifier un client';
include __DIR__ . '/header.php';
?>

<section class="panel form-panel">
    <div class="toolbar">
        <h2>Modifier le client</h2>
        <a class="button secondary" href="client_index.php">Retour</a>
    </div>

    <form action="client_update.php" method="post" class="form-grid">
        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $client['id']) ?>">

        <label>
            Prenom
            <input type="text" name="first_name" maxlength="100" value="<?= htmlspecialchars($client['first_name']) ?>" required>
        </label>

        <label>
            Nom
            <input type="text" name="last_name" maxlength="100" value="<?= htmlspecialchars($client['last_name']) ?>" required>
        </label>

        <label>
            Email
            <input type="email" name="email" maxlength="150" value="<?= htmlspecialchars($client['email']) ?>" required>
        </label>

        <label>
            Telephone
            <input type="text" name="phone" maxlength="30" value="<?= htmlspecialchars($client['phone'] ?? '') ?>">
        </label>

        <label class="full">
            Adresse
            <input type="text" name="address" maxlength="255" value="<?= htmlspecialchars($client['address'] ?? '') ?>">
        </label>

        <label>
            Ville
            <select name="city_id">
                <option value="">Choisir une ville</option>
                <?php foreach ($cities as $city): ?>
                    <option value="<?= htmlspecialchars((string) $city['id']) ?>" <?= (int) $client['city_id'] === (int) $city['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($city['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <div class="form-actions full">
            <button type="submit">Mettre a jour</button>
        </div>
    </form>
</section>

<?php include __DIR__ . '/footer.php'; ?>
