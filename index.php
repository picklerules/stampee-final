<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('PATH_DIR', 'http://localhost:8888/stampee-pw1/');
require_once('controller/Controller.php');
require_once('library/RequirePage.php');
require_once __DIR__.'/vendor/autoload.php';
require_once('library/Twig.php');
require_once('library/CheckSession.php');


$url = isset($_GET["url"]) ? explode ('/', ltrim($_GET["url"], '/')) : '/';

if ($url == '/') {
    require_once('controller/ControllerHome.php');
    $controller = new ControllerHome;
    echo $controller->index();
} else {
    // controller
    $requestURL = $url[0];
    $requestURL = ucfirst($requestURL);
    $controllerPath = __DIR__."/controller/Controller".$requestURL.".php";

    if ($url == '/') {
        require_once('controller/ControllerHome.php');
        $controller = new ControllerHome;
        echo $controller->index();
    } else {
        // controller
        $requestURL = $url[0];
        $requestURL = ucfirst($requestURL);
        $controllerPath = __DIR__."/controller/Controller".$requestURL.".php";
    
        if (file_exists($controllerPath)) {
            require_once($controllerPath);
            $controllerName = 'Controller'.$requestURL;
            $controller = new $controllerName;
            if (isset($url[1])) {
                $method = $url[1];
                if (method_exists($controller, $method)) {
                    if (isset($url[2])) {
                        echo $controller->$method($url[2]);
                    } else {
                        echo $controller->$method();
                    }
                } else {
                    // Méthode non trouvée dans le contrôleur, rediriger vers une page d'erreur 404
                    header("HTTP/1.0 404 Not Found");
                    Twig::render('error404.php', ['title' => 'Error 404']);
                    exit;
                }
            } else {
                echo $controller->index();
            }
        } else {
            // Redirection vers une page d'erreur 404
            header("HTTP/1.0 404 Not Found");
            Twig::render('error404.php', ['title' => 'Error 404']);
            exit;
        }
    }
    
}
?>