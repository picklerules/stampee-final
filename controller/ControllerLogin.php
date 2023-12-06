<?php

RequirePage::model('CRUD');
RequirePage::model('Utilisateur');
RequirePage::library('Validation');

class ControllerLogin extends Controller {

    public function index(){
        Twig::render('auth/index.php');
    }

    public function auth(){
        $validation = new Validation;
        
 
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $validation->name('username')->value($username)->max(50)->required();
        $validation->name('password')->value($password)->max(255)->min(6)->required();
    

        if(!$validation->isSuccess()){
            $errors =  $validation->displayErrors();
         return Twig::render('auth/index.php', ['errors' =>$errors,  'username' => $_POST]);
         exit();
        }

        $utilisateur= new Utilisateur;
        $checkUtilisateur = $utilisateur->checkUtilisateur($_POST['username'], $_POST['password']);
        
        
        Twig::render('auth/index.php', ['errors'=> $checkUtilisateur, 'username' => $_POST]);

    }

    public function logout(){
        session_destroy();
        RequirePage::url('login');
    }
}


?>