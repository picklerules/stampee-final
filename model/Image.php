<?php
require_once('CRUD.php');

class Image extends CRUD {

    protected $table = 'image';
    protected $primaryKey = 'id';

    protected $fillable = ['image_principale', 'file', 'id_timbre'];

    public function save($data) {
        // Affichez ou loguez les données pour vérifier qu'elles sont correctes
        echo "Sauvegarde des données de l'image : ";
        print_r($data);

        // Effectuez l'insertion
        $result = $this->insert($data);

        // Vérifiez si l'insertion a réussi et affichez ou loguez le résultat
        if ($result) {
            echo "Insertion réussie, ID de l'image : " . $result;
        } else {
            echo "Échec de l'insertion de l'image";
        }

        return $result;
    }
}

?>