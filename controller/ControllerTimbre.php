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
RequirePage::library('Validation');


class ControllerTimbre extends Controller {

    public function index(){
        $timbre = new Timbre;
        $timbresDetails = $timbre->getAllTimbresWithDetails();
        return Twig::render('timbre/index.php', ['timbres'=>$timbresDetails]);

        
    }


    public function show($id){
        $timbre = new Timbre;
        $selectId = $timbre->selectId($id);

        return Twig::render('timbre/show.php', ['timbre'=>$selectId]);
    }

    public function create() {

        CheckSession::sessionAuth();
        if ($_SESSION['privilege'] == 1 || $_SESSION['privilege'] == 2) {

            $categorie = new Categorie;
            $selectCategorie = $categorie->select('categorie');
            $couleur = new Couleur;
            $selectCouleur = $couleur->select('couleur');
            $etat = new Etat;
            $selectEtat = $etat->select('etat');
            $pays = new PaysOrigine;
            $selectPaysOrigine = $pays->select('pays');


            return Twig::render('timbre/create.php', ['categories' => $selectCategorie, 'couleurs' => $selectCouleur, 'etats' => $selectEtat, 'pays' => $selectPaysOrigine]);

        }
        RequirePage::url('login');
    }
    
    
    public function store(){

        $validation = new Validation;
        
        // Assignation des variables
        $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $date_creation = isset($_POST['date_creation']) ? $_POST['date_creation'] : '';
        $tirage = isset($_POST['tirage']) ? $_POST['tirage'] : '';
        $dimensions = isset($_POST['dimensions']) ? $_POST['dimensions'] : '';
        $certifie = isset($_POST['$certifie']) ? $_POST['certifie'] : '';
    
        // Valide les données
        $validation->name('nom')->value($nom)->max(50)->required();
        $validation->name('date_creation')->value($date_creation)->pattern('date_ymd')->required(); 
        $validation->name('tirage')->value($tirage)->pattern('int')->min(0); 
        $validation->name('dimensions')->value($dimensions)->max(255); 
        $validation->name('certifie')->value($certifie)->pattern('bool');
         
        if (!Validation::is_bool($certifie)) {
            $validation->errors[] = 'Le format du champ certifie n\'est pas valide.';
        }
    
        // Gestion de l'upload de l'image
        $imageFileName = null;
        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0){
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            
            // Déplace le fichier uploadé
            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
                $imageFileName = basename($_FILES["fileToUpload"]["name"]);
            } else {
                $validation->errors[] = "Erreur lors de l'upload de l'image.";
            }
        }
    
        // Continue avec la validation et l'insertion des données
        if(!$validation->isSuccess()){
        
            $errors =  $validation->displayErrors();
            return Twig::render('timbre/create.php', ['errors' => $errors, 'timbre' => $_POST]);

        } else {

            $_POST['image_principale'] = $imageFileName;
            $timbre = new Timbre();
            $insertId = $timbre->insert($_POST);
            RequirePage::url('timbre/show/' . $insertId);

        }
    }
    

}
?>
