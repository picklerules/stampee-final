<?php
require_once('CRUD.php');

class Mise extends CRUD {

    protected $table = 'mise';
    protected $primaryKey = 'id';

    protected $fillable = ['prix_offert', 'date_heure', 'id_enchere', 'id_utilisateur'];

    public function getAllMisesWithDetails($id_utilisateur) {

        $sql = "SELECT mise.id AS miseId, mise.prix_offert, mise.date_heure, enchere.id AS enchereId, utilisateur.username, utilisateur.id AS userId, timbre.id AS timbreId, timbre.nom, image.file
                FROM mise
                JOIN enchere ON mise.id_enchere = enchere.id
                JOIN timbre ON enchere.id_timbre = timbre.id
                JOIN image ON timbre.id = image.id_timbre
                JOIN utilisateur ON mise.id_utilisateur = utilisateur.id
                WHERE mise.id_utilisateur = :id_utilisateur
                ORDER BY timbre.nom ASC, mise.prix_offert DESC";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->execute();
        return $stmt->fetchAll();
    
    }

    public function getMaxMise($id_enchere) {

        $sql = "SELECT MAX(prix_offert) AS max_mise 
                FROM mise 
                WHERE id_enchere = :id_enchere";
                
        $stmt = $this->prepare($sql);
        $stmt->bindParam(':id_enchere', $id_enchere);
        $stmt->execute();
        return $stmt->fetch();
    }
    

    
    
}


?>