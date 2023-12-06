<?php
require_once('CRUD.php');

class Privilege extends CRUD {

    protected $table = 'privilege';
    protected $primaryKey = 'id';

    protected $fillable = ['privilege'];
}

?>