<?php
session_start();
$dbhost = 'localhost';
$dbname = 'gestionmemoires';
$username = 'root'; 
$password = ''; 

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:dbhost=$dbhost;dbname=$dbname", $username, $password, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ));
} catch (PDOException $e) {
    die("Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage());
}
?>
