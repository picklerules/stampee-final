<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Twig{
    static public function render($template, $data = array()){
        $loader = new \Twig\Loader\FilesystemLoader('view');
        $twig = new  \Twig\Environment($loader, array('auto_reload' => true));
        
        if(isset($_SESSION['authentification']) && $_SESSION['authentification'] === md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'])){
            $guest = false;
        }else{
            $guest = true;
        }
      
        $twig->addGlobal('path', PATH_DIR);     
        $twig->addGlobal('guest', $guest);
        $twig->addGlobal('session', $_SESSION);
        
        
        echo $twig->render($template, $data);
    }

}

?>