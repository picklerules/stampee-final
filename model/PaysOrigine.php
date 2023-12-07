<?php
require_once('CRUD.php');

class PaysOrigine extends CRUD {

    protected $table = 'pays_origine';
    protected $primaryKey = 'id';

    protected $fillable = ['pays'];
}

?>