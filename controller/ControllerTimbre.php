<?php

RequirePage::model('CRUD');
RequirePage::model('Timbre');
RequirePage::model('Categorie');
RequirePage::model('Couleur');
RequirePage::model('Etat');
RequirePage::model('PaysOrigine');
RequirePage::model('Image');
RequirePage::library('Validation');


class ControllerTimbre extends Controller {

    public function index(){
        $timbre = new Timbre;
        $timbresDetails = $timbre-> getAllTimbresWithDetails();

        return Twig::render('timbre/index.php', ['timbres'=>$timbresDetails]);

        
    }


    public function show($id){
        $timbre = new Timbre;
        $detailsDuTimbre = $timbre->getTimbreDetailsById($id);
        
        return Twig::render('timbre/show.php', ['timbre' => $detailsDuTimbre]);
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
    
    
    public function store() {
        $validation = new Validation;
    
        // Assignation des variables
        $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $date_creation = isset($_POST['date_creation']) ? $_POST['date_creation'] : '';
        $tirage = isset($_POST['tirage']) ? $_POST['tirage'] : '';
        $dimensions = isset($_POST['dimensions']) ? $_POST['dimensions'] : '';
        $certifie = isset($_POST['certifie']) ? $_POST['certifie'] : '';
        $id_utilisateur = $_SESSION['id'];

        $_POST['id_utilisateur'] = $id_utilisateur;
    
        // Valide les données
        $validation->name('nom')->value($nom)->max(50)->required();
        $validation->name('date_creation')->value($date_creation)->pattern('date_ymd')->required(); 
        $validation->name('tirage')->value($tirage)->pattern('int')->min(0); 
        $validation->name('dimensions')->value($dimensions)->max(255); 

        if(!$validation->isSuccess()){
            $errors = $validation->displayErrors();
            return Twig::render('timbre/create.php', ['errors' => $errors, 'timbre' => $_POST]);
        } else {
            // Insertion du timbre
            $timbre = new Timbre();
            $insertId = $timbre->insert($_POST);
    
            // Gestion de l'upload des images
            if (isset($_FILES['images'])) {
                $uploadDir = __DIR__ . '/../uploads/';

                if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
                    echo "Le dossier d'upload n'existe pas ou n'est pas accessible en écriture : $uploadDir";
                    return; 
                }

                foreach ($_FILES['images']['name'] as $key => $name) {
                    if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                        $tmpName = $_FILES['images']['tmp_name'][$key];
                        $filename = uniqid() . "_" . $name;
                        $filepath = $uploadDir . $filename;

                        if (move_uploaded_file($tmpName, $filepath)) {
                            $image = new Image();
                            $isMain = ($key == $_POST['main_image']) ? 1 : 0;
                            $image->save([
                                'file' => $filename,
                                'image_principale' => $isMain,
                                'id_timbre' => $insertId
                            ]);
                        } else {
                            echo "Erreur lors du téléchargement de l'image $name : " . $_FILES['images']['error'][$key];
                        }
                    }
                }
            }

            RequirePage::url('timbre/show/' . $insertId);
        }
    }

    public function edit($id) {

        $timbre = new Timbre();
        $timbreDetails = $timbre->getTimbreDetailsById($id);
        $categorie = new Categorie;
        $selectCategorie = $categorie->select('categorie');
        $couleur = new Couleur;
        $selectCouleur = $couleur->select('couleur');
        $etat = new Etat;
        $selectEtat = $etat->select('etat');
        $pays = new PaysOrigine;
        $selectPaysOrigine = $pays->select('pays');
        // $images = new Image();
        // $selectImages = $images->select('image');
        return Twig::render('timbre/edit.php', ['timbre' => $timbreDetails, 'categories' => $selectCategorie, 'couleurs' => $selectCouleur, 'etats' => $selectEtat, 'pays' => $selectPaysOrigine]);

    }

    public function update() {
        $validation = new Validation;
        // Assignation des variables
        $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $date_creation = isset($_POST['date_creation']) ? $_POST['date_creation'] : '';
        $tirage = isset($_POST['tirage']) ? $_POST['tirage'] : '';
        $dimensions = isset($_POST['dimensions']) ? $_POST['dimensions'] : '';
        $certifie = isset($_POST['certifie']) ? $_POST['certifie'] : '';
        $id_utilisateur = $_SESSION['id'];
        //Supprimer la clé submit du post
        unset($_POST['submit']);

    
        // Valide les données
        $validation->name('nom')->value($nom)->max(50)->required();
        $validation->name('date_creation')->value($date_creation)->pattern('date_ymd')->required(); 
        $validation->name('tirage')->value($tirage)->pattern('int')->min(0); 
        $validation->name('dimensions')->value($dimensions)->max(255); 

        if(!$validation->isSuccess()){

            $categorie = new Categorie;
            $selectCategorie = $categorie->select('categorie');
            $couleur = new Couleur;
            $selectCouleur = $couleur->select('couleur');
            $etat = new Etat;
            $selectEtat = $etat->select('etat');
            $pays = new PaysOrigine;
            $selectPaysOrigine = $pays->select('pays');
            $errors =  $validation->displayErrors();

            return Twig::render('timbre/edit.php', ['timbre' => $_POST, 'categories' => $selectCategorie, 'couleurs' => $selectCouleur, 'etats' => $selectEtat, 'pays' => $selectPaysOrigine, 'errors' => $errors]);

        } else {
            $timbre = new Timbre;
            $update = $timbre->update($_POST);
            RequirePage::url('timbre/show/'.$_POST['id']);
        }


    }


    public function destroy() {
        CheckSession::sessionAuth();
        if ($_SESSION['privilege'] == 1 || $_SESSION['privilege'] == 2) {
            $timbre = new Timbre();
    
            if ($timbre->isTimbreInEnchere($_POST['id'])) {
              
                $error = 'Vous ne pouvez pas supprimer un timbre qui est actuellement en enchère.';
                return Twig::render('timbre/index.php', ['error' => $error, 'timbres' => $timbre->getAllTimbresWithDetails()]);
            }
    
            // Récupérer le chemin de l'image
            $cheminImage = $timbre->getImagePath($_POST['id']);
            
            // Supprimer l'image si elle existe
            if ($cheminImage && file_exists($cheminImage)) {
                unlink($cheminImage);
            }
    
        
            $timbre->delete($_POST['id']);
    
        
            RequirePage::url('timbre/index');
        } else {
          
            RequirePage::url('login');
        }
    }
    
    

}
?>
