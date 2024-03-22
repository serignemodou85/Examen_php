<?php
require_once("connexion.php");

try {
    $stmt = $pdo->query("SELECT * FROM mémoires");
    $memoires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($memoires as $memoire) {
        echo "<p>" . $memoire['Titre'] . "</p>";
        echo "<p>" . $memoire['Auteur'] . "</p>";
        echo "<p>" . $memoire['Description'] . "</p>";
    }
} catch(PDOException $e) {
    die("Une erreur est survenue lors de la récupération des mémoires : " . $e->getMessage());
}
?>
