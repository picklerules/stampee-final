<?php

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

         // Debugging: Check if any data is fetched
    error_log(print_r($encheresDetails, true));

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
    
            $timbre = new Timbre();
            $timbres = [$timbre->selectId($id_timbre)];
    
            return Twig::render('enchere/create.php', ['errors' => $errors, 'timbres' => $timbres]);
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

    public function edit($id) {
        CheckSession::sessionAuth();

        $enchere = new Enchere();
        $enchereUserId = $enchere->getUserIdByEnchereId($id);
        if ($enchereUserId != $_SESSION['id']) {
            $errors = 'Vous ne pouvez pas modifier une enchère que vous n’avez pas créée.';
            return Twig::render('enchere/index.php', ['errors' => $errors, 'encheres' => $enchere->getEnchereWithDetails()]);
        }

        $enchere = new Enchere();
        $encheresDetails = $enchere->getEnchereWithDetailsById($id);

        // var_dump($encheresDetails);
        // die();

        return Twig::render('enchere/edit.php', ['enchere' => $encheresDetails]);

    }

    public function update() {
        $validation = new Validation;
        // Assignation des variables
        $prix_min = isset($_POST['prix_min']) ? $_POST['prix_min'] : '';
        $date_debut = isset($_POST['date_debut']) ? $_POST['date_debut'] : '';
        $date_fin = isset($_POST['date_fin']) ? $_POST['date_fin'] : '';
        $id_utilisateur = $_SESSION['id'];

        //Supprimer la clé submit du post
        unset($_POST['submit']);
      
    
        // Valide les données
        $validation->name('prix_min')->value($prix_min)->pattern('float')->required();
        $validation->name('date_debut')->value($date_debut)->pattern('date_ymd')->required();
        $validation->name('date_fin')->value($date_fin)->pattern('date_ymd')->required();

        if(!$validation->isSuccess()){

            $mise = new Mise();
            $enchere = new Enchere();
            $encheresDetails = $enchere->getEnchereWithDetailsById($idEnchere);
    

            $errors =  $validation->displayErrors();

            return Twig::render('enchere/edit.php', ['enchere' => $encheresDetails, 'errors' => $errors]);

        } else {
            $enchere = new Enchere;
            $update = $enchere->update($_POST);
            RequirePage::url('enchere/index/');
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

    public function search(){
        $enchere = new Enchere();
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;
    
        if ($keyword) {
            $encheresDetails = $enchere->searchByTimbreName($keyword);
            if (empty($encheresDetails)) {
                $errors = "Aucune enchère ne correspond à cette recherche";
            }

        }
    
        return Twig::render('enchere/index.php', ['encheres' => $encheresDetails, 'errors' => $errors ?? null]);
    }
    
    

}

?>