<?php
require_once("./connexion.php");
require_once("./utilisateur.php");

$erreurMessage = '';

// Traitement de la connexion de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['NomUtilisateur']) && isset($_POST['mot_de_passe']) && !empty($_POST['NomUtilisateur']) && !empty($_POST['mot_de_passe'])) {
        $nomUtilisateur = $_POST['NomUtilisateur'];
        $motDePasse = $_POST['mot_de_passe'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE NomUtilisateur = ?");
            $stmt->execute([$nomUtilisateur]);
            $user = $stmt->fetch();
            // Si le nom d'utilisateur est trouvé dans la base, on vérifie le mot de passe
            if (!empty($user)) {
                if (password_verify($motDePasse, $user["MotDePasse"])) {
                    session_start();
                    $_SESSION['id'] = $user['UtilisateurID']; // Correction: UtilisateurID est le nom correct de la colonne
                    $_SESSION['type'] = $user['TypeUtilisateur']; // Correction: TypeUtilisateur est le nom correct de la colonne

                    // Utilisation des fonctions Administrateur() et Etudiant() pour déterminer le type d'utilisateur
                    if (Administrateur($pdo, $nomUtilisateur)) {
                        header('Location: tableau_de_bord_Admin.php');
                    } elseif (Etudiant($pdo, $nomUtilisateur)) { 
                        header('Location: tableau_de_bord_Utilisateur.php');
                    } else {
                        $erreurMessage = "Mauvaise combinaison nom d'utilisateur ou mot de passe.";
                    }
                } else {
                    $erreurMessage = "Le mot de passe est incorrect.";
                }
            } else { 
                $erreurMessage = "L'utilisateur n'existe pas.";
            }
        } catch(PDOException $e) {  
            echo "<div> Erreur PDO : " . $e->getMessage() . "</div>";
            die();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="../css/connexion.css">
</head>
<body>
    <div class="login-box">
        <h2>Identification</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="NomUtilisateur">Nom d'utilisateur:</label>
                <input type="text" id="NomUtilisateur" name="NomUtilisateur" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Se connecter">
            </div>
        </form>
    </div> 
</body>
</html>
