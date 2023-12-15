<?php
require_once('CRUD.php');

class Mise extends CRUD {

    protected $table = 'mise';
    protected $primaryKey = 'id';

    protected $fillable = ['prix_offert', 'date_heure', 'id_enchere', 'id_utilisateur'];

    public function getAllMisesWithDetails() {
        $sql = "SELECT mise.id, mise.prix_offert, mise.date_heure, enchere.id, utilisateur.username, utilisateur.id AS UserId
                FROM mise
                JOIN enchere ON mise.id_enchere = enchere.id
                JOIN utilisateur ON mise.id_utilisateur = utilisateur.id";

        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    
    }
    
}


?>