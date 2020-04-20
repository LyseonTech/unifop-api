<?php

require '../vendor/autoload.php';

if(file_exists(__DIR__.'/../.env')) {
    $dotenv = Dotenv\Dotenv::createMutable(__DIR__.'/../');
    $dotenv->load();
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $error[] = 'Invalid email';
}
if (strlen($_POST['name']) < 3) {
    $error[] = 'Invalid name';
}
if (strlen($_POST['identity']) < 3) {
    $error[] = 'Invalid identity';
}
if (strlen($_POST['message']) < 3) {
    $error[] = 'Invalid message';
}
$phone = $_POST['phone'];
preg_replace('/\D/', '', $phone);
if (!is_numeric($phone) || strlen($phone) < 11) {
    $error[] = 'Invalid phone';
}

header('Content-Type: application/json');
if ($error) {
    echo json_encode(['errors' => $error]);
    return ;
}

$dsn = getenv('DB_ADAPTER').':dbname='.getenv('DB_NAME').';host='.getenv('DB_HOST');
$dbh = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASSWD'));

$sql = 'INSERT INTO form_responses (name, email, phone, identity, message) VALUES (:name, :email, :phone, :identity, :message);';
$sth = $dbh->prepare($sql);

$sth->execute([
    ':name' => $_POST['name'],
    ':email' => $_POST['email'],
    ':phone' => $phone,
    ':identity' => $_POST['identity'],
    ':message' => $_POST['message'],
]);

echo json_encode('Success');