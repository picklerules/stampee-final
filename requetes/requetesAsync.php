<?php
require_once('fonctionsDB.php');

$connexion = connexionDB();
$request_payload = file_get_contents('php://input');
$data = json_decode($request_payload, true);

if (isset($data['action'])) {

    switch ($data['action']) {

        case 'addToFavoris':
            if (isset($data['id_enchere'])) {
                // Ajouter l'enchère aux favoris
                // Utilisez une fonction de votre fichier fonctionsDB pour gérer l'insertion
                $result = addEnchereToFavoris($_SESSION['id'], $data['id_enchere']);
                echo json_encode(['success' => $result]);
            }
            break;
    
        case 'removeFromFavoris':
            if (isset($data['id_enchere'])) {
                // Supprimer l'enchère des favoris
                // Utilisez une fonction de votre fichier fonctionsDB pour gérer la suppression
                $result = removeEnchereFromFavoris($_SESSION['id'], $data['id_enchere']);
                echo json_encode(['success' => $result]);
            }
            break;
    

        default:
    }
} else {
    
    echo 'Erreur action';
}
?>
