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

    // public function __construct(){
    //     CheckSession::sessionAuth();
    //     if($_SESSION['privilege'] != 1) {
    //         RequirePage::url('login');
    //         exit();
    //     }
    // }

    public function index(){
        $utilisateur = new Utilisateur;
        $select = $utilisateur->select('username');

        $timbre = new Timbre;

        $privilege = new Privilege;
        $select = $utilisateur->select('username, id_privilege, id_timbre_favori');

      
        foreach($select as $utilisateur){
          
            $selectPrivilege = $privilege->selectId($utilisateur['id_privilege']);
            $utilisateur['privilege'] = $selectPrivilege['privilege'];

           
            $selectTimbre = $timbre->selectId($utilisateur['id_timbre_favori']);
            $utilisateur['timbre'] = $selectTimbre['nom'];
        }

        return Twig::render('utilisateur/index.php', ['utilisateurs'=>$select]);
    }

    public function create(){ 
        $privilege = new Privilege;
        $select = $privilege->select('privilege');
        $timbreFavori = new Timbre;
        $selectTimbre = $timbreFavori->select('nom');
        return Twig::render('utilisateur/create.php', ['privileges' => $select, 'timbres' => $selectTimbre]);
    }

    public function store(){
        $validation = new Validation;
        extract($_POST);
        $validation->name('username')->value($username)->max(50)->required();
        $validation->name('password')->value($password)->max(255)->min(6)->required();
        $validation->name('email')->value($email)->max(50)->required()->pattern('email');
        $validation->name('privilege')->value($id_privilege)->required();
        $validation->name('timbre')->value($id_timbre_favori);


        if(!$validation->isSuccess()){
            $errors =  $validation->displayErrors();
            $privilege = new Privilege;
            $timbre = new Timbre;
            $select = $privilege->select('privilege');
            $selectTimbre = $timbre->select('nom');
            return Twig::render('utilisateur/create.php', ['errors' =>$errors, 'privileges' => $select, 'timbres' => $selectTimbre, 'utilisateur' => $_POST]);
            exit();
        }

        $utilisateur = new Utilisateur;
        
        //vérifier si l'utilisateur est unique
        if ($utilisateur->selectByUsername($username)) {
    
            $errors =  'L\'utilisateur existe déjà.';
            $privilege = new Privilege;
            $timbre = new Timbre;
            $select = $privilege->select('privilege');
            $selectTimbre = $timbre->select('nom');
            return Twig::render('utilisateur/create.php', ['errors' => $errors, 'privileges' => $select, 'timbres' => $selectTimbre, 'utilisateur' => $_POST]);
        }


        $options = [
            'cost' => 10
        ];
        $salt = "G7j$@_ul";
        $passwordSalt = $_POST['password'].$salt;
        $_POST['password'] =  password_hash($passwordSalt , PASSWORD_BCRYPT, $options);
        
        $insert = $utilisateur->insert($_POST);

        RequirePage::url('utilisateur');
    }
}
?>
 