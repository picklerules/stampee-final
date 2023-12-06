
<?php
require_once('CRUD.php');

class Utilisateur extends CRUD {
    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'email', 'password', 'id_privilege', 'id_timbre_favori'];


    public function selectTimbreFavori() {
        $sql = "SELECT timbre.id, timbre.nom, username FROM timbre
        INNER JOIN utilisateur ON utilisateur.id_timbre_favori = timbre.id";
        $stmt = $this->query($sql);
        $timbres = $stmt->fetchAll();
        return $timbres;
    }   

    public function checkUtilisateur($username, $password){

        $sql = "SELECT * FROM $this->table WHERE username = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute(array($username));
        $count = $stmt->rowCount();

        if($count === 1){
            $salt = "G7j$@_ul";
            $passwordSalt = $password.$salt;
            
            $info_utilisateur = $stmt->fetch();
           
            
            if(password_verify($passwordSalt , $info_utilisateur ['password'])){
                //session
                session_regenerate_id();
                $_SESSION['id'] = $info_utilisateur['id'];
                $_SESSION['username'] = $info_utilisateur['username'];
                $_SESSION['privilege'] = $info_utilisateur['id_privilege'];
                $_SESSION['authentification'] = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);

                RequirePage::url('timbre');
                exit();

            }else{
                $errors = "<ul><li>Verifier le mot de passe</li></ul>";
                return $errors;
            }

        }else{
            $errors = "<ul><li>Verifier le nom d'utilisateur</li></ul>";
            return $errors; 
        }

    }

    public function selectByUsername($username) {
        $sql = "SELECT * FROM $this->table WHERE username = :username";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        return $stmt->fetch() ?: false;
    }


}
