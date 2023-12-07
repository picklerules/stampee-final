<?php
require_once('CRUD.php');

class Categorie extends CRUD {

    protected $table = 'categorie';
    protected $primaryKey = 'id';

    protected $fillable = ['categorie'];

}

?>