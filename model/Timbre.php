<?php
require_once('CRUD.php');

class Timbre extends CRUD {
    protected $table = 'timbre';
    protected $primaryKey = 'id';
    protected $fillable = ['nom', 'date_creation', 'tirage', 'dimensions', 'id_etat', 'id_pays_origine', 'id_categorie', 'id_couleur', 'certifie'];

    public function getAllTimbresWithDetails() {
        $sql = "SELECT timbre.id, timbre.nom, date_creation, tirage, dimensions, etat.etat, pays_origine.pays, categorie.categorie, couleur.couleur, image.file
                FROM timbre
                JOIN etat ON timbre.id_etat = etat.id
                JOIN pays_origine ON timbre.id_pays_origine = pays_origine.id
                JOIN categorie ON timbre.id_categorie = categorie.id
                JOIN couleur ON timbre.id_couleur = couleur.id
                JOIN image ON timbre.id = id_timbre";
    
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}

