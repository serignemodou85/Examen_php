<?php
require_once("./connexion.php");
require_once("./utilisateur.php");
require_once("./etudiant.php");

// Fonction pour ajouter un utilisateur dans la base de données
function ajouterUtilisateur($pdo, $prenom, $nom, $nomUtilisateur, $motDePasse, $typeUtilisateur) {
    $hashMotDePasse = password_hash($motDePasse, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Utilisateurs (Prenom, Nom, NomUtilisateur, MotDePasse, TypeUtilisateur) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$prenom, $nom, $nomUtilisateur, $hashMotDePasse, $typeUtilisateur]);
}

// Fonction pour modifier les informations d'un utilisateur dans la base de données
function modifierUtilisateur($pdo, $utilisateurID, $prenom, $nom, $nomUtilisateur, $motDePasse) {
    if (!empty($motDePasse)) {
        $hashMotDePasse = password_hash($motDePasse, PASSWORD_DEFAULT);
        $sql = "UPDATE Utilisateurs SET Prenom=?, Nom=?, NomUtilisateur=?, MotDePasse=? WHERE UtilisateurID=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prenom, $nom, $nomUtilisateur, $hashMotDePasse, $utilisateurID]);
    } else {
        $sql = "UPDATE Utilisateurs SET Prenom=?, Nom=?, NomUtilisateur=? WHERE UtilisateurID=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prenom, $nom, $nomUtilisateur, $utilisateurID]);
    }
}

// Fonction pour supprimer un utilisateur de la base de données
function supprimerUtilisateur($pdo, $utilisateurID) {
    $sql = "DELETE FROM Utilisateurs WHERE UtilisateurID=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$utilisateurID]);
}

// Fonction pour ajouter une mémoire dans la base de données
function ajouterMemoire($pdo, $titre, $auteur, $description, $themeID, $domaineID, $fichier) {
    // Vérifier l'existence du thème
    $sql = "SELECT COUNT(*) AS theme_count FROM Thèmes WHERE ThèmeID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$themeID]);
    $themeExists = $stmt->fetch(PDO::FETCH_ASSOC)['theme_count'];

    if ($themeExists) {
        // Insérer la mémoire si le thème existe
        $sql = "INSERT INTO Mémoires (Titre, Auteur, Description, ThèmeID, DomaineID, Fichier) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $auteur, $description, $themeID, $domaineID, $fichier]);
    } else {
        // Afficher un message d'erreur si le thème n'existe pas
        echo "Erreur : Le thème spécifié n'existe pas.";
    }
}

// Fonction pour lire les mémoires de la base de données
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

// Fonction pour modifier une mémoire dans la base de données
function modifierMemoire($pdo, $memoireID, $titre, $auteur, $description, $themeID, $domaineID, $fichier) {
    // Vérifier l'existence du thème
    $sql = "SELECT COUNT(*) AS theme_count FROM Thèmes WHERE ThèmeID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$themeID]);
    $themeExists = $stmt->fetch(PDO::FETCH_ASSOC)['theme_count'];

    if ($themeExists) {
        // Mettre à jour la mémoire si le thème existe
        $sql = "UPDATE Mémoires SET Titre=?, Auteur=?, Description=?, ThèmeID=?, DomaineID=?, Fichier=? WHERE MémoireID=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $auteur, $description, $themeID, $domaineID, $fichier, $memoireID]);
    } else {
        // Afficher un message d'erreur si le thème n'existe pas
        echo "Erreur : Le thème spécifié n'existe pas.";
    }
}

try {
    $pdo = new PDO("mysql:dbhost=$dbhost;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Gestion des actions en fonction des requêtes HTTP
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['ajouter_utilisateur'])) {
            $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
            $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
            $nomUtilisateur = isset($_POST['NomUtilisateur']) ? $_POST['NomUtilisateur'] : '';
            $motDePasse = isset($_POST['motDePasse']) ? $_POST['motDePasse'] : '';
            $typeUtilisateur = isset($_POST['typeUtilisateur']) ? $_POST['typeUtilisateur'] : '';
            ajouterUtilisateur($pdo, $prenom, $nom, $nomUtilisateur, $motDePasse, $typeUtilisateur);
        } elseif (isset($_POST['modifier_utilisateur'])) {
            $utilisateurID = isset($_POST['utilisateurID']) ? $_POST['utilisateurID'] : '';
            $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
            $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
            $nomUtilisateur = isset($_POST['NomUtilisateur']) ? $_POST['NomUtilisateur'] : '';
            $motDePasse = isset($_POST['motDePasse']) ? $_POST['motDePasse']: '';
            modifierUtilisateur($pdo, $utilisateurID, $prenom, $nom, $nomUtilisateur, $motDePasse);
        } elseif (isset($_POST['supprimer_utilisateur'])) {
            $utilisateurID = isset($_POST['utilisateurID']) ? $_POST['utilisateurID'] : '';
            supprimerUtilisateur($pdo, $utilisateurID);
        } elseif (isset($_POST['ajouter_memoire'])) {
            $titre = isset($_POST['titre']) ? $_POST['titre'] : '';
            $auteur = isset($_POST['auteur']) ? $_POST['auteur'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $themeID = isset($_POST['themeID']) ? $_POST['themeID'] : '';
            $domaineID = isset($_POST['domaineID']) ? $_POST['domaineID'] : '';
            $fichier = isset($_FILES['fichier']['name']) ? $_FILES['fichier']['name'] : '';
            ajouterMemoire($pdo, $titre, $auteur, $description, $themeID, $domaineID, $fichier);
        } elseif (isset($_POST['modifier_memoire'])) {
            $memoireID = isset($_POST['memoireID']) ? $_POST['memoireID'] : '';
            $titre = isset($_POST['titre']) ? $_POST['titre'] : '';
            $auteur = isset($_POST['auteur']) ? $_POST['auteur'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $themeID = isset($_POST['themeID']) ? $_POST['themeID'] : '';
            $domaineID = isset($_POST['domaineID']) ? $_POST['domaineID'] : '';
            $fichier = isset($_FILES['fichier']['name']) ? $_FILES['fichier']['name'] : '';
            modifierMemoire($pdo, $memoireID, $titre, $auteur, $description, $themeID, $domaineID, $fichier);        
        } elseif (isset($_POST['supprimer_memoire'])) {
            $memoireID = isset($_POST['memoireID']) ? $_POST['memoireID'] : '';
            supprimerMemoire($pdo, $memoireID);
        }
    }

    // Récupérer l'ID de l'utilisateur connecté (à remplacer par la méthode appropriée)
    $utilisateurID = 'utilisateurID'; 
    $memoires = lireMemoires($pdo, null, null);
    foreach ($memoires as $memoire) {
        echo $memoire['Titre'] . "<br>";
    }
} catch(PDOException $e) {
    die("Une erreur est survenue lors de la connexion à la base de données : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Administrateur</title>
    <link rel="stylesheet" href="../css/tableau_de_bord_Admin.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="#gestion_utilisateurs">Gestion des utilisateurs</a></li>
            <li><a href="#gestion_memoires">Gestion des mémoires</a></li> 
            <li><a href="déconnexion.php" id="deconnexion">Se déconnecter</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Tableau de bord Administrateur</h2>

        <section id="gestion_utilisateurs">
            <div id="utilisateurs">
                <?php 
                // Vérifier si l'administrateur a choisi d'afficher les utilisateurs
                $afficherUtilisateurs = isset($_POST['afficher_utilisateurs']) ? true : false;
                
                if ($afficherUtilisateurs) {
                    
                    require_once("liste_utilisateurs.php"); 
                }
                ?>
                <form method="post">
                    <?php if ($afficherUtilisateurs) { ?>
                        <!-- Bouton pour masquer les utilisateurs -->
                        <button type="submit" name="masquer_utilisateurs">Masquer Utilisateurs</button>
                    <?php } else { ?>
                        <!-- Bouton pour afficher les utilisateurs -->
                        <button type="submit" name="afficher_utilisateurs">Afficher Utilisateurs</button>
                    <?php } ?>
                </form>
            </div>
        </section>

        
        <section id="ajout_utilisateur">
            <form id="ajouterUtilisateurForm" method="post">
                <!-- Formulaire d'ajout d'utilisateur -->
                <label for="nom">Nom :</label><br>
                <input type="text" name="nom" id="nom" required /><br>
                
                <label for="prenom">Prénom :</label><br>
                <input type="text" name="prenom" id="prenom" required/><br>
                
                <label for="NomUtilisateur">NomUtilisateur :</label><br>
                <input type="text" name="NomUtilisateur" id="NomUtilisateur"/><br>
                
                <label for="motDePasse">Mot de passe :</label><br>
                <input type="password" name="motDePasse" id="motDePasse" required/><br>
                
                <label for="typeUtilisateur">Type d'utilisateur :</label>
                <select id="typeUtilisateur" name="typeUtilisateur" required>
                    <option value="admin">Administrateur</option><br>
                    <option value="utilisateur">Etudiant</option><br>
                </select>
                
                <button type="submit" name="ajouter_utilisateur">Ajouter Utilisateur</button><br>
            </form>
        
        </section>
        
        <section id="gestion_memoires">
            <div id="memoires">
                <!-- Liste des mémoires affichée dynamiquement via PHP -->
                <?php 
                // Vérifier si l'administrateur a choisi d'afficher les memoires
                $afficherMemoires = isset($_POST['afficher_memoires']) ? true : false;
                
                if ($afficherMemoires) {
                    
                    require_once("liste_memoires.php"); 
                }
                ?>
                <form method="post">
                    <?php if ($afficherUtilisateurs) { ?>
                        <!-- Bouton pour masquer les utilisateurs -->
                        <button type="submit" name="masquer_memoires">Masquer Memoires</button>
                    <?php } else { ?>
                        <!-- Bouton pour afficher les utilisateurs -->
                        <button type="submit" name="afficher_memoires">Afficher Memoires</button>
                    <?php } ?>
            </div>
        </section>

        <section id="ajout_memoire">
            <!-- Formulaire d'ajout de mémoire -->
            <form id="ajouterMemoireForm" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titre">Titre :</label>
                    <input type="text" id="titre" name="titre" required>
                </div>
                <div class="form-group">
                    <label for="auteur">Auteur :</label>
                    <input type="text" id="auteur" name="auteur" required>
                </div>
                <div class="form-group">
                    <label for="description">Description :</label><br/>
                    <textarea rows="4" cols="50" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="themeID">Thème :</label>
                    <input type="text" id="themeID" name="themeID" required>
                </div>
                <div class="form-group">
                    <label for="domaineID">Domaine :</label>
                    <input type="text" id="domaineID" name="domaineID" required>
                </div>
                <div class="form-group">
                    <label for="fichier">Fichier (PDF) :</label>
                    <input type="file" accept=".pdf" id="fichier" name="fichier" required><br /><br />
                </div>
                <button type="submit" name="ajouter_memoire">Ajouter la mémoire</button>
            </form>
        </section>
        
        <!-- Section pour modifier une mémoire -->
        <section id="modifier_memoire">
            <h3>Modification d'une mémoire</h3>
            <p>Veuillez sélectionner une mémoire à partir de la liste ci-dessous.</p>
            <select onchange="afficherInfosPourModif(this)" id="listeMemoiresSelect">
                <!-- Liste des mémoires affichées dans le select -->
            </select>  
            <hr />
            <div id="infosPourModif">
            </div>
            <button onclick="ouvrirModal('ajout')" >Ajouter une nouvelle mémoire</button>  
        </section> 
        
        <!-- Section pour supprimer une mémoire -->
        <section id="supprimer_memoire">
            <h3>Suppression d'une mémoire</h3>
            <p>Veuillez sélectionner une mémoire à partir de la liste ci-dessous.</p>
            <table>
                <tr>
                    <th>Titre</th>
                    <th>Date de publication</th>
                    <th>Action</th>
                </tr>
                <tbody id="listeMemoires">
                    <!-- Liste des mémoires avec boutons de suppression -->
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>