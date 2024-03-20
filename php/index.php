<?php
require_once("./connexion.php");
require_once("./utilisateur.php");

function redirect($location) {
    header("Location: $location");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des champs
    if(isset($_POST['NomUtilisateur'], $_POST['mot_de_passe'])) {
        $nomUtilisateur = $_POST['NomUtilisateur'];
        $motDePasse = $_POST['mot_de_passe'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE NomUtilisateur = ?");
            $stmt->execute([$nomUtilisateur]);
            $user = $stmt->fetch();

            if (!empty($user) && password_verify($motDePasse, $user["MotDePasse"])) {
                session_start();
                $_SESSION['id'] = $user['UtilisateurID']; 
                $_SESSION['type'] = $user['TypeUtilisateur']; 
            
                // Redirection en fonction du type d'utilisateur
                if ($user['TypeUtilisateur'] === 'admin') {
                    redirect('tableau_de_bord_Admin.php');
                } elseif ($user['TypeUtilisateur'] === 'etudiant') {
                    redirect('tableau_de_bord_Utilisateur.php');
                }
            } else {
                $erreur_message = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } catch (PDOException $e) { 
            die('Erreur : ' . $e->getMessage());
        }
    } else {
        $erreur_message = "Veuillez remplir tous les champs.";
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
        <?php if (isset($erreur_message)) { ?>
            <p class="error-message"><?php echo $erreur_message; ?></p>
        <?php } ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="NomUtilisateur">Nom d'utilisateur:</label>
                <input type="text" id="NomUtilisateur" name="NomUtilisateur" >
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" >
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Connexion</button>
            </div>
        </form>
    </div> 
</body>
</html>
