<?php
require_once('CRUD.php');

class Timbre extends CRUD {
    protected $table = 'timbre';
    protected $primaryKey = 'id';
    protected $fillable = ['nom', 'date_creation', 'tirage', 'dimensions', 'image_principale', 'image_secondaire', 'id_etat', 'id_pays_origine', 'id_categorie', 'id_enchere', 'id_couleur', 'certifie'];


    public function getImagePath($id) {
        $sql = "SELECT file FROM $this->table WHERE id = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? "uploads/" . $result['image_principale'] : null;
    }

}
