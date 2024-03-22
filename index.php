<?php
require_once("connexion.php");

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nomUtilisateur = isset($_POST['NomUtilisateur']) ? $_POST['NomUtilisateur'] : '';
        $motDePasse = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';

        $sql = "SELECT UtilisateurID, NomUtilisateur, MotDePasse, TypeUtilisateur FROM utilisateurs WHERE NomUtilisateur = :nomUtilisateur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':nomUtilisateur' => $nomUtilisateur]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($motDePasse, $utilisateur['MotDePasse'])) {
            if ($utilisateur['TypeUtilisateur'] === 'Admin') {
                header("Location: tableau_de_bord_admin.php");
                exit();
            } elseif ($utilisateur['TypeUtilisateur'] === 'Étudiant') {
                header("Location: tableau_de_bord_utilisateur.php");
                exit();
            }
        } else {
            echo "Identifiant ou mot de passe incorrect.";
        }
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Authentification</title>
    <link rel="stylesheet" href="css/connexion.css">
</head>
<body>
    <div class="login-box">
        <h2>Identification</h2>
        <form method="POST" action="tableau_de_bord_Utilisateur.php">
            <div class="form-group">
                <label for="NomUtilisateur">Nom d'utilisateur:</label>
                <input type="text" id="NomUtilisateur" name="NomUtilisateur">
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Connexion</button>
            </div>
        </form>
    </div> 
</body>
</html>
