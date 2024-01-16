<?php
require_once('CRUD.php');

class Enchere extends CRUD {

    protected $table = 'enchere';
    protected $primaryKey = 'id';

    protected $fillable = ['prix_min', 'date_debut', 'date_fin', 'coup_de_coeur', 'id_utilisateur', 'active', 'id_timbre'];


    public function getEnchereWithDetails(){

        $idUser = $_SESSION['id'] ?? null;
        
        $sql = "SELECT enchere.id AS enchereId, prix_min, date_debut, date_fin, coup_de_coeur, enchere.id_utilisateur, active, enchere.id_timbre, timbre.*, etat.etat, pays_origine.pays, categorie.categorie, couleur.couleur, image.file,
            EXISTS (SELECT 1 FROM favoris WHERE id_utilisateur = $idUser AND id_enchere = enchere.id) AS estFavoris
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

    public function isEnchereInMise($idEnchere) {

        $sql = "SELECT COUNT(*) 
                FROM mise 
                WHERE id_enchere = :idEnchere";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':idEnchere', $idEnchere);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public function getUserIdByEnchereId($idEnchere) {

        $sql = "SELECT id_utilisateur 
                FROM enchere 
                WHERE id = :id";
                
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $idEnchere);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['id_utilisateur'] : null;
    }
    
    public function searchByTimbreName($keyword) {
        $sql = "SELECT enchere.id AS enchereId, prix_min, date_debut, date_fin, coup_de_coeur, enchere.id_utilisateur, active, enchere.id_timbre, timbre.*, etat.etat, pays_origine.pays, categorie.categorie, couleur.couleur, image.file
                FROM enchere
                JOIN timbre ON enchere.id_timbre = timbre.id
                JOIN etat ON timbre.id_etat = etat.id
                JOIN pays_origine ON timbre.id_pays_origine = pays_origine.id
                JOIN categorie ON timbre.id_categorie = categorie.id
                JOIN couleur ON timbre.id_couleur = couleur.id
                JOIN image ON timbre.id = image.id_timbre
                WHERE timbre.nom LIKE :keyword";
    
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%');
        $stmt->execute();
        return $stmt->fetchAll();
    }
    

    
}

?>