<?php

class CheckSession{

    static public function sessionAuth(){
        if(isset($_SESSION['authentification']) && $_SESSION['authentification'] === md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'])){
            return true;
        }else{
            RequirePage::url('login');
            exit();
        }
    }
}


?>