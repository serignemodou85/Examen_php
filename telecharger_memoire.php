<?php
require_once("connexion.php");

// Vérifiez si l'identifiant du mémoire est présent dans la requête
if(isset($_GET['id'])) {
    try {
        $pdo = new PDO("mysql:dbhost=$dbhost;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Appel de la fonction pour télécharger le mémoire
        downloadMemoire($pdo, $_GET['id']);
    } catch(PDOException $e) {
        echo "Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage();
    }
} else {
    echo "Identifiant du mémoire non spécifié.";
}
?>
