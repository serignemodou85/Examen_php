<?php
require_once("./connexion.php");

try {
    $pdo = new PDO("mysql:dbhost=$dbhost;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM Mémoires");
    $memoires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($memoires as $memoire) {
        echo "<p>" . $memoire['Titre'] . "</p>";
        echo "<p>" . $memoire['Auteur'] . "</p>";
        echo "<p>" . $memoire['Description'] . "</p>";
        // Afficher d'autres informations nécessaires
    }
} catch(PDOException $e) {
    die("Une erreur est survenue lors de la récupération des mémoires : " . $e->getMessage());
}
?>
