<?php
require_once('utilisateur.php');

class Etudiant extends Utilisateur {
    private $utilisateurID;
    private $prenom;
    private $nom;
    private $typeUtilisateur = "Étudiant"; 
    private $nomUtilisateur;
    private $motDePasse;

    public function __construct($utilisateurID, $prenom, $nom, $nomUtilisateur, $motDePasse = "Étudiant") {
        parent::__construct(); // Appel du constructeur de la classe parente
        $this->utilisateurID = $utilisateurID;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->motDePasse = $motDePasse;
    }

    // GETTERS AND SETTERS
    // Getters
    public function getUtilisateurID() {
        return $this->utilisateurID;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getTypeUtilisateur() {
        return $this->typeUtilisateur;
    }

    public function getNomUtilisateur() {
        return $this->nomUtilisateur;
    }

    public function getMotDePasse() {
        return $this->motDePasse;
    }

    // Setters
    public function setUtilisateurID($utilisateurID) {
        $this->utilisateurID = $utilisateurID;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setNomUtilisateur($nomUtilisateur) {
        $this->nomUtilisateur = $nomUtilisateur;
    }

    public function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
    }
}

class Admin extends Utilisateur {
    private $utilisateurID;
    private $prenom;
    private $nom;
    private $typeUtilisateur = "Administrateur"; // Définition du type d'utilisateur
    private $nomUtilisateur;
    private $motDePasse;

    public function __construct($utilisateurID, $prenom, $nom, $nomUtilisateur, $motDePasse = "Administrateur") {
        parent::__construct(); // Appel du constructeur de la classe parente
        $this->utilisateurID = $utilisateurID;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->motDePasse = $motDePasse;
    }

    // GETTERS AND SETTERS
    // Getters
    public function getUtilisateurID() {
        return $this->utilisateurID;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getTypeUtilisateur() {
        return $this->typeUtilisateur;
    }

    public function getNomUtilisateur() {
        return $this->nomUtilisateur;
    }

    public function getMotDePasse() {
        return $this->motDePasse;
    }

    // Setters
    public function setUtilisateurID($utilisateurID) {
        $this->utilisateurID = $utilisateurID;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setNomUtilisateur($nomUtilisateur) {
        $this->nomUtilisateur = $nomUtilisateur;
    }

    public function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
    }
}
?>
