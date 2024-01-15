<?php
require_once('CRUD.php');

class Favoris extends CRUD {

    protected $table = 'favoris';
    protected $primaryKey = 'id';

    protected $fillable = ['id_utilisateur', 'id_enchere', 'date_ajout'];
}

?>