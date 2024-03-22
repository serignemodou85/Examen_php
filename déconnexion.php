<?php
session_start();
require_once("connexion.php");

$_SESSION = array();

session_destroy();

header("Location: index.php");
exit;
?>
