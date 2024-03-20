<?php
require_once('./connexion.php');

class Utilisateur {
    private $utilisateurID;
    private $nom;
    private $prenom;
    private $typeUtilisateur;
    private $nomUtilisateur;
    private $motDePasse;
    
    public function __construct($utilisateurID, $nom, $prenom, $typeUtilisateur, $nomUtilisateur, $motDePasse) {
        $this->utilisateurID = $utilisateurID;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->typeUtilisateur = $typeUtilisateur;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->motDePasse = $motDePasse;
    }
    
    public function getId() {
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
    
    // Méthode pour vérifier si l'utilisateur est un administrateur
    public function Administrateur() {
        return $this->typeUtilisateur === 'Admin';
    }
    
    // Méthode pour vérifier si l'utilisateur est un étudiant
    public function Etudiant() {
        return $this->typeUtilisateur === 'Étudiant';
    }
}
?>
