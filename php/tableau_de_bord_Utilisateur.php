<?php
require_once("./connexion.php");
require_once("utilisateur.php");

function getMemoires($pdo) {
    $sql = "SELECT * FROM Mémoires";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchMemoiresByTheme($pdo, $themeID) {
    $sql = "SELECT * FROM Mémoires WHERE ThèmeID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$themeID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function lireMemoires($pdo, $themeID, $domaineID) {
    if ($themeID && $domaineID) {
        $sql = "SELECT * FROM Mémoires WHERE ThèmeID=? AND DomaineID=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$themeID, $domaineID]);
    } elseif ($themeID) {
        $sql = "SELECT * FROM Mémoires WHERE ThèmeID=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$themeID]);
    } elseif ($domaineID) {
        $sql = "SELECT * FROM Mémoires WHERE DomaineID=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$domaineID]);
    } else {
        $sql = "SELECT * FROM Mémoires";
        $stmt = $pdo->query($sql);
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function downloadMemoire($pdo, $memoireID) {
    $sql = "SELECT Fichier, NomFichier FROM Mémoires WHERE MémoireID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$memoireID]);
    $memoire = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($memoire) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $memoire['NomFichier'] . '"');
        echo $memoire['Fichier'];
        exit;
    } else {
        echo "Mémoire non trouvé.";
        exit;
    }
}
try {
    $pdo = new PDO("mysql:dbhost=$dbhost;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['theme']) && isset($_POST['domaine'])) {
            $theme = $_POST['theme'];
            $domaine = $_POST['domaine'];
            $memoires = searchMemoiresByTheme($pdo, $theme);
        }
    } else {
        $memoires = getMemoires($pdo);
    }
} catch(PDOException $e) {
    die("Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Utilisateur</title>
    <link rel="stylesheet" href="../css/tableau_de_Bord_Utilisateur.css">
</head>
<body>
    <div class="container">
        <h2>Tableau de bord Utilisateur</h2>
        
        <h3>Consulter les mémoires disponibles</h3>
        <div id="mémoires">
            <?php
            foreach ($memoires as $memoire) {
                echo "<p>" . $memoire['Titre'] . " - <a href='telecharger_memoire.php?id=" . $memoire['MemoireID'] . "'>Télécharger</a></p>";
            }
            ?>
        </div>
        
        <h3>Rechercher des mémoires par thèmes et domaines</h3>
        <form method="post">
            <div class="form-group">
                <label for="theme">Thème :</label>
                <input type="text" id="theme" name="theme">
            </div>
            <div class="form-group">
                <label for="domaine">Domaine :</label>
                <input type="text" id="domaine" name="domaine">
            </div>
            <button type="submit">Rechercher</button>
        </form>
        
        <div id="resultatRecherche">
            <?php  
            if (isset($_POST["theme"]) || isset($_POST["domaine"])) {   
                $resultats = array();
                
                if(isset($_POST["theme"])){  
                    $motif = $_POST["theme"];  
                    
                    foreach($memoires as $memoire){  
                        if(strpos($memoire['Theme'],$motif) !== false){ 
                            $resultats[] = $memoire;  
                        }
                    }
                }
                if(isset($_POST["domaine"])){  
                    $motif = $_POST["domaine"];  
                    
                    foreach($memoires as $memoire){ 
                        if(strpos($memoire['Domaine'],$motif) !== false){ 
                            $resultats[] = $memoire;  
                        }
                    }
                }
                
                if(count($resultats) > 0) {  
                    echo "<h3>Résultats de la recherche :</h3>";
                    foreach ($resultats as $memoire) {
                        echo "<p>" . $memoire['Titre'] . " - <a href='telecharger_memoire.php?id=" . $memoire['MemoireID'] . "'>Télécharger</a></p>";
                    }
                } else {  
                    echo "<p>Aucun résultat trouvé.</p>";
                }
            }
            ?>
        </div>
            //se deconnecter
            <a href='deconnexion.php'>Se déconnecter</a>
</body>
</html>
