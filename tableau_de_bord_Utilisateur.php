<?php
require_once("connexion.php");

function getMemoires($pdo) {
    $sql = "SELECT MémoireID, Titre FROM mémoires";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchMemoiresByTheme($pdo, $themeID) {
    $sql = "SELECT MémoireID, Titre FROM mémoires WHERE ThèmeID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$themeID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchMemoiresByDomaine($pdo, $domaineID) {
    $sql = "SELECT MémoireID, Titre FROM mémoires WHERE DomaineID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$domaineID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

try {
    $memoires = getMemoires($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['theme']) && !empty($_POST['theme'])) {
            $themeID = $_POST['theme'];
            $memoires = searchMemoiresByTheme($pdo, $themeID);
        }

        if (isset($_POST['domaine']) && !empty($_POST['domaine'])) {
            $domaineID = $_POST['domaine'];
            $memoires = searchMemoiresByDomaine($pdo, $domaineID);
        }
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
    <link rel="stylesheet" href="css/tableau_de_Bord_Utilisateur.css">
</head>
<body>
<div class="container">
    <h2>Tableau de bord Utilisateur</h2>
    
    <h3>Consulter les mémoires disponibles</h3>
    <div id="memoires">
        <?php foreach ($memoires as $memoire) : ?>
            <p><?= $memoire['Titre'] ?> - <a href='telecharger_memoire.php?id=<?= $memoire['MémoireID'] ?>'>Télécharger</a></p>
        <?php endforeach; ?>
    </div>
    
    <h3>Rechercher des mémoires par thème et domaine</h3>
    <form method="post">
        <div class="form-group">
            <label for="theme">Thème :</label>
            <input type="text" id="theme" name="theme">
        </div>
        <div class="form-group">
            <label for="domaine">Domaine :</label>
            <input type="text" id="domaine" name="domaine">
        </div>
        <button type="submit" name="search_memoire">Rechercher</button>
    </form>
    
    <div id="resultatRecherche">
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <?php if (!empty($memoires)) : ?>
                <h3>Résultats de la recherche :</h3>
                <?php foreach ($memoires as $memoire) : ?>
                    <p><?= $memoire['Titre'] ?> - <a href='telecharger_memoire.php?id=<?= $memoire['MémoireID'] ?>'>Télécharger</a></p>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun résultat trouvé.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    <a href='déconnexion.php'>Se déconnecter</a>
</div>
</body>
</html>
