<?php
require_once('fonctionsDB.php');

$connexion = connexionDB();
$request_payload = file_get_contents('php://input');
$data = json_decode($request_payload, true);

if (isset($data['action'])) {

    switch ($data['action']) {

        case 'addToFavoris':
            if (isset($data['id_enchere'])) {

                $result = addEnchereToFavoris($_SESSION['id'], $data['id_enchere']);
                echo json_encode(['success' => $result]);
            }
            break;
    
        case 'removeFromFavoris':
            if (isset($data['id_enchere'])) {
                
                $result = removeEnchereFromFavoris($_SESSION['id'], $data['id_enchere']);
                echo json_encode(['success' => $result]);
            }
            break;
        case 'filterByCategorie':
            if (isset($data['categorie'])) {
                $resultats = getEncheresByTimbresCategorie($data['categorie']);
                error_log(print_r($resultats, true)); 
                $data = [];
        
                if (mysqli_num_rows($resultats) > 0) {
                    while ($enchere = mysqli_fetch_assoc($resultats)) {
                        $data[] = $enchere;
                    }
                }
        
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($data);
            }
            break;
        


        default:
    }
} else {
    
    echo 'Erreur action';
}
?>
