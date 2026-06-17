<?php

require_once __DIR__ . '/db/connex.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: client_index.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
$cityId = $_POST['city_id'] !== '' ? (int) $_POST['city_id'] : null;

if ($id <= 0 || $firstName === '' || $lastName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: client_index.php');
    exit;
}

$statement = $pdo->prepare(
    'UPDATE clients
     SET first_name = :first_name,
         last_name = :last_name,
         email = :email,
         phone = :phone,
         address = :address,
         city_id = :city_id
     WHERE id = :id'
);

$statement->execute([
    'id' => $id,
    'first_name' => $firstName,
    'last_name' => $lastName,
    'email' => $email,
    'phone' => $phone,
    'address' => $address,
    'city_id' => $cityId,
]);

header('Location: client_index.php?success=updated');
exit;
