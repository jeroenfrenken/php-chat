<?php

$databaseConfig = require_once __DIR__ . '/config/Database.php';
$sqlCreateUser = file_get_contents(__DIR__ . '/sql/create-user-table.sql');
$sqlCreateChat = file_get_contents(__DIR__ . '/sql/create-chat-table.sql');
$sqlCreateMessage = file_get_contents(__DIR__ . '/sql/create-message-table.sql');

if (!file_exists($databaseConfig['url'])) {
    $databaseFile = fopen($databaseConfig['url'], "w") or die("Could not create {$databaseConfig['url']}\r\n");
    fclose($databaseFile);
    echo "Created Database file {$databaseConfig['url']}\r\n";
} else {
    echo "Database already created. Remove {$databaseConfig['url']} first to start the setup\r\n";
    exit;
}

$pdo = new PDO("sqlite:{$databaseConfig['url']}");

$query = $pdo->prepare($sqlCreateUser);
$res = $query->execute();

echo "Create user table: {$res}\r\n";

$query = $pdo->prepare($sqlCreateChat);
$res = $query->execute();

echo "Create chat table: {$res}\r\n";

$query = $pdo->prepare($sqlCreateMessage);
$res = $query->execute();

echo "Create message table: {$res}\r\n";
