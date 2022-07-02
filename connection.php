<?php
$server = 'localhost';
$user = 'root';
$password = '';
$db = 'register';

try {
    $connection = new PDO("mysql:host=$server;dbname=$db", $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Couldn't connect to database";
}
