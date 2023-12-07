<?php
require_once('CRUD.php');

class Timbre extends CRUD {
    protected $table = 'timbre';
    protected $primaryKey = 'id';
    protected $fillable = ['nom', 'date_creation', 'tirage', 'dimensions', 'image_principale', 'image_secondaire', 'id_etat', 'id_pays_origine', 'id_categorie', 'id_couleur', 'certifie'];

    public function getImagePath($id) {
        $sql = "SELECT file FROM $this->table WHERE id = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? "uploads/" . $result['image_principale'] : null;
    }

    public function getAllTimbresWithDetails() {
        $sql = "SELECT timbre.nom, date_creation, tirage, dimensions, image_principale, image_secondaire, etat.etat, pays_origine.pays, categorie.categorie, couleur.couleur
                FROM timbre
                JOIN etat ON timbre.id_etat = etat.id
                JOIN pays_origine ON timbre.id_pays_origine = pays_origine.id
                JOIN categorie ON timbre.id_categorie = categorie.id
                JOIN couleur ON timbre.id_couleur = couleur.id";

        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }



}
