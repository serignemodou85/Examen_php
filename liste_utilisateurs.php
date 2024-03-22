<?php
require_once("connexion.php");

try {
    $sql = "SELECT UtilisateurID, NomUtilisateur FROM utilisateurs";
    $stmt = $pdo->query($sql);
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($utilisateurs) {
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
