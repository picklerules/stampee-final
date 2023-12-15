<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

RequirePage::model('CRUD');
RequirePage::model('Timbre');
RequirePage::model('Categorie');
RequirePage::model('Couleur');
RequirePage::model('Etat');
RequirePage::model('PaysOrigine');
RequirePage::model('Mise');
RequirePage::model('Image');
RequirePage::library('Validation');


class ControllerMise extends Controller {

    public function index(){
        $mise = new Mise;
        $misesDetails = $mise-> getAllMisesWithDetails();

        return Twig::render('mise/index.php', ['mises'=>$misesDetails]);

        
    }
}

?>