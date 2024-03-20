<?php
// Inclusion des fichiers de connexion et des fonctions utilisateur
require_once("./connexion.php");
require_once("./utilisateur.php");

// Vérification de la soumission du formulaire avec les champs requis remplis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['NomUtilisateur']) && isset($_POST['mot_de_passe']) && !empty($_POST['NomUtilisateur']) && !empty($_POST['mot_de_passe'])) {
        $nomUtilisateur = $_POST['NomUtilisateur'];
        $motDePasse = $_POST['mot_de_passe'];

        try {
            // Requête pour récupérer l'utilisateur de la base de données
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE NomUtilisateur = ?");
            $stmt->execute([$nomUtilisateur]);
            $user = $stmt->fetch();

            // Vérification du mot de passe et redirection vers le tableau de bord correspondant
            if (!empty($user) && password_verify($motDePasse, $user["MotDePasse"])) {
                session_start();
                $_SESSION['id'] = $user['ID'];
                $_SESSION['type'] = $user['Type'];

                if ($user['Type'] === 'administrateur') {
                    header('Location: tableau_de_bord_Admin.php');
                    exit();
                } elseif ($user['Type'] === 'etudiant') {
                    header('Location: tableau_de_bord_Utilisateur.php');
                    exit();
                }
            } else {
                header('Location: ./index.php?erreur=1'); // Mot de passe incorrect
                exit();
            }
        } catch (PDOException $e) { 
            die('Erreur : ' . $e->getMessage());
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
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="NomUtilisateur">Nom d'utilisateur:</label>
                <input type="text" id="NomUtilisateur" name="NomUtilisateur" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <div class="form-group">
                <button type="submit">Connexion</button>
            </div>
        </form>
    </div> 
</body>
</html>
