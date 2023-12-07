<?php
require_once('CRUD.php');

class Couleur extends CRUD {

    protected $table = 'couleur';
    protected $primaryKey = 'id';

    protected $fillable = ['couleur'];


}

?>