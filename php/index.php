<?php
// Inclusion des fichiers de connexion et des fonctions utilisateur
require_once("./connexion.php");
require_once("./utilisateur.php");

// Message d'erreur initialisé à vide
$erreurMessage = '';

// Traitement de la connexion de l'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification de la soumission du formulaire avec les champs requis remplis
    if(isset($_POST['NomUtilisateur']) && isset($_POST['mot_de_passe']) && !empty($_POST['NomUtilisateur']) && !empty($_POST['mot_de_passe'])) {
        $nomUtilisateur = $_POST['NomUtilisateur'];
        $motDePasse = $_POST['mot_de_passe'];

        try {
            // Requête pour récupérer l'utilisateur de la base de données
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE NomUtilisateur = ?");
            $stmt->execute([$nomUtilisateur]);
            $user = $stmt->fetch();
            
            // Si l'utilisateur est trouvé dans la base de données
            if (!empty($user)) {
                // Vérification du mot de passe
                if (password_verify($motDePasse, $user["MotDePasse"])) {
                    // Démarrage de la session et enregistrement des informations utilisateur
                    session_start();
                    $_SESSION['id'] = $user['UtilisateurID']; 
                    $_SESSION['type'] = $user['TypeUtilisateur']; 
                    
                    // Redirection vers le tableau de bord en fonction du type d'utilisateur
                    if ($user['TypeUtilisateur'] === 'administrateur') {
                        header('Location: tableau_de_bord_Admin.php');
                        exit(); // Assurez-vous de sortir du script après la redirection
                    } elseif ($user['TypeUtilisateur'] === 'etudiant') { 
                        header('Location: tableau_de_bord_Utilisateur.php');
                        exit(); // Assurez-vous de sortir du script après la redirection
                    } else {
                        $erreurMessage = "Type d'utilisateur non reconnu.";
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
    <title>Authentification</title>
    <link rel="stylesheet" href="../css/connexion.css">
</head>
<body>
    <div class="login-box">
        <h2>Identification</h2>
        <form method="POST" action="index.php">
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
