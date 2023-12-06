<?php

RequirePage::model('CRUD');
RequirePage::model('Timbre');
RequirePage::library('Validation');


class ControllerTimbre extends Controller {
    public function index(){
        $timbre = new Timbre;
        $select = $timbre->select('nom');
        return Twig::render('timbre/index.php', ['timbres'=>$select]);

        
    }


    public function show($id){
        $timbre = new Timbre;
        $selectId = $timbre->selectId($id);

        return Twig::render('timbre/show.php', ['timbre'=>$selectId]);
    }

    // public function create(){
    //     CheckSession::sessionAuth();
    //     if($_SESSION['privilege'] == 1 || $_SESSION['privilege'] == 2){
        
    //     $selectVendeurs = $vendeur->selectWithNom();
    //     return Twig::render('vetement-create.php', ['vendeurs' => $selectVendeurs]);
    //     }
    //     RequirePage::url('login'); 
    // }
    
    // public function store(){
    //     $validation = new Validation;
        
    //     // Assignation des variables
    //     $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    //     $description = isset($_POST['description']) ? $_POST['description'] : '';
    //     $prix = isset($_POST['prix']) ? $_POST['prix'] : '';
    
    //     // Valide les données
    //     $validation->name('nom')->value($nom)->max(50)->required();
    //     $validation->name('description')->value($description)->max(255);
    //     $validation->name('prix')->value($prix)->pattern('float')->min(0)->required();
    
    //     // Gestion de l'upload de l'image
    //     $imageFileName = null;
    //     if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0){
    //         $target_dir = "uploads/";
    //         $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            
    //         // Déplace le fichier uploadé
    //         if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
    //             $imageFileName = basename($_FILES["fileToUpload"]["name"]);
    //         } else {
    //             $validation->errors[] = "Erreur lors de l'upload de l'image.";
    //         }
    //     }
    
    //     // Continue avec la validation et l'insertion des données
    //     if(!$validation->isSuccess()){
    //         $vendeur = new Vendeur;
    //         $selectVendeurs = $vendeur->selectWithNom();
    //         $errors =  $validation->displayErrors();
    //         return Twig::render('vetement-create.php', ['errors' => $errors, 'vendeurs' => $selectVendeurs, 'vetement' => $_POST]);
    //     } else {
    //         $_POST['file'] = $imageFileName;
    //         $vetement = new Vetement;
    //         $insert = $vetement->insert($_POST);
    //         RequirePage::url('vetement/show/' . $insert);
    //     }
    // }
    
    
    // public function edit($id){    
    //     CheckSession::sessionAuth();
    //     if($_SESSION['privilege'] == 1 || $_SESSION['privilege'] == 2){
    //     $vetement = new Vetement;
    //     $selectId = $vetement->selectId($id);
    //     $vendeur = new Vendeur;
    //     $selectVendeurs = $vendeur->selectWithNom();
    //     return Twig::render('vetement-edit.php', ['vetement' => $selectId, 'vendeurs' => $selectVendeurs]);
    //     }
    //     RequirePage::url('login'); 
    // }
    
    // public function update(){
    // $validation = new Validation;
        
    //     // Assignation des variables
    //   $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    //   $description = isset($_POST['description']) ? $_POST['description'] : '';
    //   $prix = isset($_POST['prix']) ? $_POST['prix'] : '';

    //   // Valide les données
    //   $validation->name('nom')->value($nom)->max(50)->required();
    //   $validation->name('description')->value($description)->max(255);
    //   $validation->name('prix')->value($prix)->pattern('float')->min(0)->required();

  

    //   if(!$validation->isSuccess()){

    //       $vendeur = new Vendeur;
    //       $selectVendeurs = $vendeur->selectWithNom();
    //       $errors =  $validation->displayErrors();
    //    return Twig::render('vetement-create.php', ['errors' =>$errors, 'vendeurs' => $selectVendeurs, 'vetement' => $_POST]);
    //    exit();
    //   }
    //     $vetement = new Vetement;
    //     $update = $vetement->update($_POST);
    //     RequirePage::url('vetement/show/'.$_POST['id']);
    // }
    

    // public function destroy(){
    //     CheckSession::sessionAuth();
    //     if($_SESSION['privilege'] == 1){
    //         $vetement = new Vetement;
                
    //         // Récupérer le chemin de l'image
    //         $cheminImage = $vetement->getImagePath($_POST['id']);
    
    //         // Supprimer l'image si elle existe
    //         if($cheminImage && file_exists($cheminImage)) {
    //             unlink($cheminImage);
    //         }
    
    //         $delete = $vetement->delete($_POST['id']);
    //         RequirePage::url('vetement/index');
    //     } else {
    //         RequirePage::url('login');
    //     }
    // }
    

}
?>
