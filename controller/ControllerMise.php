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
    
        $mise = new Mise();
        $validation = new Validation();
        
        $prix_offert = isset($_POST['prix_offert']) ? $_POST['prix_offert'] : '';
        $id_enchere = isset($_POST['id_enchere']) ? $_POST['id_enchere'] : '';
        $id_utilisateur = $_SESSION['id'];
        
        $validation->name('prix_offert')->value($prix_offert)->pattern('float')->required();

        
        if (!$validation->isSuccess()) {
            $errors = [];
            foreach ($validation->displayErrors() as $field => $messages) {
                $errors[$id_enchere][$field] = implode(", ", $messages);
            }
            $enchere = new Enchere();
            $encheresDetails = $enchere->getEnchereWithDetails();
            return Twig::render('enchere/index.php', ['errors' => $errors, 'encheres' => $encheresDetails]);

            // Ajouter la mise maximale pour chaque enchère en cas d'échec de validation
            foreach ($encheresDetails as $key => $enchereDetail) {
                $maxMise = $mise->getMaxMise($enchereDetail['enchereId']);
                $encheresDetails[$key]['max_mise'] = $maxMise['max_mise'] ?? $enchereDetail['prix_min'];
                // if($enchereDetail['enchereId']) {
                // $encheresDetails[$key]['errors'] = "Votre mise doit être supérieure à la mise actuelle.";}
                
            }
        }
        
        
        $enchere = new Enchere();
        $detailEnchere = $enchere->selectId($id_enchere); 
        //recupérer le prix min
        $prixMinEnchere = $detailEnchere['prix_min'];
        //récupérer la max mise
        $maxMise = $mise->getMaxMise($id_enchere);
        $maxMiseValue = $maxMise ? $maxMise['max_mise'] : $prixMinEnchere; 
        

        if ($prix_offert <= $maxMiseValue) {
            
            $bidErrors[$id_enchere] = ["Votre mise doit être supérieure à la mise actuelle."];
            $encheresDetails = $enchere->getEnchereWithDetails();

            // Ajouter la mise maximale pour chaque enchère en cas d'échec de validation
            foreach ($encheresDetails as $key => $enchereDetail) {
                $maxMise = $mise->getMaxMise($enchereDetail['enchereId']);
                $encheresDetails[$key]['max_mise'] = $maxMise['max_mise'] ?? $enchereDetail['prix_min'];
                // if($enchereDetail['enchereId']) {
                // $encheresDetails[$key]['errors'] = "Votre mise doit être supérieure à la mise actuelle.";}
                
            }
            return Twig::render('enchere/index.php', ['bidErrors' => $bidErrors, 'encheres' => $encheresDetails]);
        }
    
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
    
        RequirePage::url('enchere/index');
    }
    
}
?>