<?php
require_once('CRUD.php');

class Etat extends CRUD {

    protected $table = 'etat';
    protected $primaryKey = 'id';

    protected $fillable = ['etat'];
}

?>