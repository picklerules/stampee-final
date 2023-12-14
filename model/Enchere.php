<?php
require_once('CRUD.php');

class Enchere extends CRUD {

    protected $table = 'enchere';
    protected $primaryKey = 'id';

    protected $fillable = ['prix_min', 'date_debut', 'date_fin', 'coup_de_coeur', 'id_utilisateur', 'active', 'id_timbre'];


    public function getEnchereWithDetails(){

        $sql = "SELECT enchere.*, timbre.*, etat.etat, pays_origine.pays, categorie.categorie, couleur.couleur, image.file
                FROM enchere
                JOIN timbre ON enchere.id_timbre = timbre.id
                JOIN etat ON timbre.id_etat = etat.id
                JOIN pays_origine ON timbre.id_pays_origine = pays_origine.id
                JOIN categorie ON timbre.id_categorie = categorie.id
                JOIN couleur ON timbre.id_couleur = couleur.id
                JOIN image ON timbre.id = image.id_timbre";

        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>