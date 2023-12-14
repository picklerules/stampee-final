<?php
require_once('CRUD.php');

class Timbre extends CRUD {
    protected $table = 'timbre';
    protected $primaryKey = 'id';
    protected $fillable = ['nom', 'date_creation', 'tirage', 'dimensions', 'id_etat', 'id_pays_origine', 'id_categorie', 'id_couleur', 'certifie', 'id_utilisateur'];

    public function getAllTimbresWithDetails() {
        $sql = "SELECT timbre.id, timbre.nom, date_creation, tirage, dimensions, etat.etat, pays_origine.pays, categorie.categorie, couleur.couleur, timbre.id_utilisateur, image.file, utilisateur.username, utilisateur.id AS UserId
                FROM timbre
                JOIN etat ON timbre.id_etat = etat.id
                JOIN pays_origine ON timbre.id_pays_origine = pays_origine.id
                JOIN categorie ON timbre.id_categorie = categorie.id
                JOIN couleur ON timbre.id_couleur = couleur.id
                JOIN utilisateur ON timbre.id_utilisateur = utilisateur.id
                JOIN image ON timbre.id = id_timbre AND image.image_principale = 1";
    
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTimbreDetailsById($id) {
        $sql = "SELECT timbre.id, timbre.nom, date_creation, tirage, dimensions, etat.etat, pays_origine.pays, categorie.categorie, couleur.couleur, image.file, utilisateur.username
                FROM timbre
                JOIN etat ON timbre.id_etat = etat.id
                JOIN pays_origine ON timbre.id_pays_origine = pays_origine.id
                JOIN categorie ON timbre.id_categorie = categorie.id
                JOIN couleur ON timbre.id_couleur = couleur.id
                JOIN image ON timbre.id = image.id_timbre
                JOIN utilisateur ON timbre.id_utilisateur = utilisateur.id
                WHERE timbre.id = :id";
    
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function getTimbresByUserId($userId) {
        $sql = "SELECT * FROM timbre WHERE id_utilisateur = :userId";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    

}

