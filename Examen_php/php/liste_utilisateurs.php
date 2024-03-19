<?php
require_once("./connexion.php");

// Récupérer la liste des utilisateurs depuis la base de données
try {
    $sql = "SELECT UtilisateurID, NomUtilisateur FROM Utilisateurs";
    $stmt = $pdo->query($sql);
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($utilisateurs) {
        // Afficher la liste des utilisateurs
        foreach ($utilisateurs as $utilisateur) {
            echo "<p>{$utilisateur['NomUtilisateur']}</p>";
        }
    } else {
        echo "Aucun utilisateur trouvé.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
