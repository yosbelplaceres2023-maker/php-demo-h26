<?php

require_once __DIR__ . '/db/connex.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: client_create.php');
    exit;
}

$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
$cityId = $_POST['city_id'] !== '' ? (int) $_POST['city_id'] : null;

if ($firstName === '' || $lastName === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: client_create.php?error=1');
    exit;
}

$statement = $pdo->prepare(
    'INSERT INTO clients (first_name, last_name, email, phone, address, city_id)
     VALUES (:first_name, :last_name, :email, :phone, :address, :city_id)'
);

$statement->execute([
    'first_name' => $firstName,
    'last_name' => $lastName,
    'email' => $email,
    'phone' => $phone,
    'address' => $address,
    'city_id' => $cityId,
]);

header('Location: client_index.php?success=created');
exit;
