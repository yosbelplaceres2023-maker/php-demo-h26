<?php

$pageTitle = $pageTitle ?? 'Gestion des clients';
$currentPage = basename($_SERVER['PHP_SELF']);

function active_link(string $page, string $currentPage): string
{
    return $page === $currentPage ? ' class="active"' : '';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="site-header">
        <div>
            <p class="eyebrow">PHP / MySQL</p>
            <h1><?= htmlspecialchars($pageTitle) ?></h1>
        </div>

        <nav class="site-nav">
            <a href="client_index.php"<?= active_link('client_index.php', $currentPage) ?>>Clients</a>
            <a href="city_index.php"<?= active_link('city_index.php', $currentPage) ?>>Villes</a>
        </nav>
    </header>

    <main class="container">
