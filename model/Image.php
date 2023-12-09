<?php
require_once('CRUD.php');

class Image extends CRUD {

    protected $table = 'image';
    protected $primaryKey = 'id';

    protected $fillable = ['image_principale', 'file', 'id_timbre'];
}

?>