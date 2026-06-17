<?php

require_once __DIR__ . '/db/connex.php';

$pageTitle = 'Ajouter un client';
$cities = [];

try {
    $cities = $pdo->query('SELECT id, name FROM cities ORDER BY name')->fetchAll();
} catch (PDOException $e) {
    $cities = [];
}

include __DIR__ . '/header.php';
?>

<section class="panel form-panel">
    <div class="toolbar">
        <h2>Nouveau client</h2>
        <a class="button secondary" href="client_index.php">Retour</a>
    </div>

    <form action="client_store.php" method="post" class="form-grid">
        <label>
            Prenom
            <input type="text" name="first_name" maxlength="100" required>
        </label>

        <label>
            Nom
            <input type="text" name="last_name" maxlength="100" required>
        </label>

        <label>
            Email
            <input type="email" name="email" maxlength="150" required>
        </label>

        <label>
            Telephone
            <input type="text" name="phone" maxlength="30">
        </label>

        <label class="full">
            Adresse
            <input type="text" name="address" maxlength="255">
        </label>

        <label>
            Ville
            <select name="city_id">
                <option value="">Choisir une ville</option>
                <?php foreach ($cities as $city): ?>
                    <option value="<?= htmlspecialchars((string) $city['id']) ?>">
                        <?= htmlspecialchars($city['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <div class="form-actions full">
            <button type="submit">Enregistrer</button>
        </div>
    </form>
</section>

<?php include __DIR__ . '/footer.php'; ?>
