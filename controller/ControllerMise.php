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
RequirePage::model('Utilisateur');
RequirePage::model('Enchere');
RequirePage::model('Image');
RequirePage::library('Validation');


class ControllerMise extends Controller {

    public function index(){
        $mise = new Mise;
        $id_utilisateur = $_SESSION['id'];
        $misesDetails = $mise-> getAllMisesWithDetails($id_utilisateur);


        return Twig::render('mise/index.php', ['mises'=>$misesDetails]);
    }


    public function store() {
        CheckSession::sessionAuth();        
        if ($_SESSION['privilege'] != 1 && $_SESSION['privilege'] != 2) {
            RequirePage::url('login');
            exit();
        }
    
        $validation = new Validation();
    
        $prix_offert = isset($_POST['prix_offert']) ? $_POST['prix_offert'] : '';
        $id_enchere = isset($_POST['id_enchere']) ? $_POST['id_enchere'] : '';
        $id_utilisateur = $_SESSION['id'];

        
    
        $validation->name('prix_offert')->value($prix_offert)->pattern('float')->required();
    
        if (!$validation->isSuccess()) {
            $errors = $validation->displayErrors();
            $enchere = new Enchere();
            $encheresDetails = $enchere->getEnchereWithDetails();
            return Twig::render('enchere/index.php', ['errors' => $errors, 'encheres' => $encheresDetails]);
        }
    
        $enchere = new Enchere();
        $encheresDetails = $enchere->getEnchereWithDetails();
        $detailEnchere = $enchere->selectId($id_enchere); 
        //recupérer le prix minimum
        $prixMinEnchere = $detailEnchere['prix_min'];

    
        // Vérification de la mise maximale
        $mise = new Mise();
        $maxMise = $mise->getMaxMise($id_enchere);
        $maxMiseValue = $maxMise ? $maxMise['max_mise'] : $prixMinEnchere; 

        if ($prix_offert <= $maxMiseValue) {
            $errors = "Votre mise doit être supérieure à la mise actuelle.";
            return Twig::render('enchere/index.php', ['errors' => $errors, 'encheres' => $encheresDetails]);
        }
    
        // Insertion de la nouvelle mise
        $insertResult = $mise->insert([
            'prix_offert' => $prix_offert,
            'date_heure' => date("Y-m-d H:i:s"),
            'id_enchere' => $id_enchere,
            'id_utilisateur' => $id_utilisateur
        ]);
    
        if (!$insertResult) {
            echo "Erreur lors de l'insertion de la mise.";
            return;
        }
    
        RequirePage::url('mise/index');
    }
    
}
?>