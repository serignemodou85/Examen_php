<?php
session_start();
require_once("./connexion.php");
// Supprimer toutes les variables de session
$_SESSION = array();

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion
header("Location: ./index.php");
exit;
?>
