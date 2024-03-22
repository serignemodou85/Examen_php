<?php
$dbhost = 'mysql-fallmo.alwaysdata.net';
$dbname = 'fallmo_gm';
$username = 'fallmo'; 
$password = 'passe123'; 

try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $username, $password, array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
    ));
} catch (PDOException $e) {
    die("Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage());
}
?>
