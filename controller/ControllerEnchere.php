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
RequirePage::model('Enchere');
RequirePage::model('Mise');
RequirePage::model('Utilisateur');
RequirePage::library('Validation');


class ControllerEnchere extends Controller {

    public function index(){
        $enchere = new Enchere();
        $mise = new Mise();
        $encheresDetails = $enchere->getEnchereWithDetails();

        foreach ($encheresDetails as $key => $enchereDetail) {
            $maxMise = $mise->getMaxMise($enchereDetail['enchereId']);
            $encheresDetails[$key]['max_mise'] = $maxMise['max_mise'] ?? $enchereDetail['prix_min'];
       
        }
    
        return Twig::render('enchere/index.php', ['encheres' => $encheresDetails]);
    }


    public function create($idTimbre = null) {

        CheckSession::sessionAuth();        
        if ($_SESSION['privilege'] != 1 && $_SESSION['privilege'] != 2) {
            RequirePage::url('login');
            exit();
        }
        $timbre = new Timbre();

        if ($idTimbre) {
            
            $timbres = [$timbre->selectId($idTimbre)];
        } else {
        
        $timbres = $timbre->getTimbresByUserId($_SESSION['id']); 

     }
        return Twig::render('enchere/create.php', ['timbres' => $timbres]);
    }


    public function store() {


        $validation = new Validation;

        $prix_min = isset($_POST['prix_min']) ? $_POST['prix_min'] : '';
        $date_debut = isset($_POST['date_debut']) ? $_POST['date_debut'] : '';
        $date_fin = isset($_POST['date_fin']) ? $_POST['date_fin'] : '';
        $id_timbre = isset($_POST['id_timbre']) ? $_POST['id_timbre'] : '';



        $validation->name('prix_min')->value($prix_min)->pattern('float')->required();
        $validation->name('date_debut')->value($date_debut)->pattern('date_ymd')->required();
        $validation->name('date_fin')->value($date_fin)->pattern('date_ymd')->required();
        $validation->name('id_timbre')->value($id_timbre)->pattern('int')->required();

        if(!$validation->isSuccess()){

            $errors = $validation->displayErrors();
            return Twig::render('enchere/create.php', ['errors' => $errors]);
        } else {

            $enchere = new Enchere();
            $encheresDetails = $enchere->getEnchereWithDetails();
            $enchere->insert([
                'prix_min' => $prix_min,
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
                'id_timbre' => $id_timbre,
                'id_utilisateur' => $_SESSION['id'] 
            ]);

            // return Twig::render('enchere/index.php', ['encheres'=>$encheresDetails]);
            RequirePage::url('enchere/index');
            exit();

        }
    }


    public function destroy() {
        CheckSession::sessionAuth();
       
            $enchere = new Enchere();

            $enchereUserId = $enchere->getUserIdByEnchereId($_POST['id']);
            if ($enchereUserId != $_SESSION['id']) {
                $errors = 'Vous ne pouvez pas supprimer une enchère que vous n’avez pas créée.';
                return Twig::render('enchere/index.php', ['errors' => $errors, 'encheres' => $enchere->getEnchereWithDetails()]);
            }
        

            if ($enchere->isEnchereInMise($_POST['id'])) {
                $errors = 'Vous ne pouvez pas supprimer une enchère qui a des mises.';
                return Twig::render('enchere/index.php', ['errors' => $errors, 'encheres' => $enchere->getEnchereWithDetails()]);
            }

            //TO DO:
            //message d'erreur si l'enchère est active 


        
            $enchere->delete($_POST['id']);
    
        
            RequirePage::url('enchere/index');
        
    }
    

}

?>