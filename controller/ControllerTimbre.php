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
                $uploadDir = __DIR__ . '/../uploads/';// Assurez-vous que ce chemin est correct

                if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
                    echo "Le dossier d'upload n'existe pas ou n'est pas accessible en écriture : $uploadDir";
                    return; // Arrêtez l'exécution si le dossier n'est pas correct
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


            // Rediriger ou afficher un message de succès
            RequirePage::url('timbre/show/' . $insertId);
        }
    }
    

}
?>
