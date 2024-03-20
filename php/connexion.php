<?php
session_start();
$dbhost = 'mysql-fallmo.alwaysdata.net';
$dbname = 'fallmo_gm';
$username = 'fallmo'; 
$password = 'passe123'; 

try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ));
} catch (PDOException $e) {
    die("Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage());
}
?>
