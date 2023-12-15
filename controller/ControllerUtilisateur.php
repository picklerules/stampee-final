<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

RequirePage::model('CRUD');
RequirePage::model('Utilisateur');
RequirePage::model('Privilege');
RequirePage::model('Timbre');
RequirePage::library('Validation');


class ControllerUtilisateur extends Controller {

    public function index(){

        CheckSession::sessionAuth();
        if($_SESSION['privilege'] != 1) {
            RequirePage::url('login');
            exit();
        }
        $utilisateur = new Utilisateur;
        $select = $utilisateur->select('username, email, id_privilege');
    
        $privilege = new Privilege;

    
        $i = 0;
        foreach ($select as $user) {
            // Ajout des informations de privilège
            $selectPrivilege = $privilege->selectId($user['id_privilege']);
            $select[$i]['privilege'] = $selectPrivilege['privilege'];
    

    
            $i++;
        }
    
        return Twig::render('utilisateur/index.php', ['utilisateurs' => $select]);
    }
    

    public function create(){ 
        $privilege = new Privilege;
        $select = $privilege->select('privilege');
        return Twig::render('utilisateur/create.php', ['privileges' => $select]);
    }

    public function store() {
        $validation = new Validation;
    
        // Extraction des données POST
        extract($_POST);
    
        // Application des règles de validation
        $validation->name('username')->value($username)->max(50)->required();
        $validation->name('password')->value($password)->max(255)->min(6)->required();
        $validation->name('email')->value($email)->max(50)->required()->pattern('email');
    
        if ($_SESSION['privilege'] != 1) {
            $id_privilege = 2;
        } else {
            $id_privilege = $_POST['id_privilege'] ?? 2;
        }
    
        if(!$validation->isSuccess()) {
            $errors =  $validation->displayErrors();
            // Retour à la vue de création avec les messages d'erreur
            $privilege = new Privilege;
            $select = $privilege->select('privilege');
            return Twig::render('utilisateur/create.php', ['errors' => $errors, 'privileges' => $select, 'utilisateur' => $_POST]);
        }
    
        $utilisateur = new Utilisateur;
        
        
        //vérifier si l'utilisateur est unique
        if ($utilisateur->selectByUsername($username)) {
    
            $errors =  'L\'utilisateur existe déjà.';
            $privilege = new Privilege;
            $select = $privilege->select('privilege');
            return Twig::render('utilisateur/create.php', ['errors' => $errors, 'privileges' => $select, 'utilisateur' => $_POST]);
        }


        $options = [
            'cost' => 10
        ];
        $salt = "G7j$@_ul";
        $passwordSalt = $_POST['password'].$salt;
        $_POST['password'] =  password_hash($passwordSalt , PASSWORD_BCRYPT, $options);
        
        $userData = [
            'username' => $username,
            'email' => $email,
            'password' => $_POST['password'],
            'id_privilege' => $id_privilege 
        ];


        $insert = $utilisateur->insert($userData);


        RequirePage::url('utilisateur');


    }
}
?>
 