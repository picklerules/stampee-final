<?php
	session_start();
	$connexion = connexionDB();
	/**
	 * Connection avec la base de données
	 */
	function connexionDB() {
		define('DB_HOST', 'localhost');
		define('DB_USER', 'root');
		define('DB_PASSWORD', 'root');			// MAC

		// define('DB_HOST', 'localhost');
		// define('DB_USER', 'e2395496');
		// define('DB_PASSWORD', '32fEWjU4cTBDn03DWq9Y');			// webdev

		//define('DB_PASSWORD', '');			// Windows

		$laConnexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
				
		if (!$laConnexion) {
			// La connexion n'a pas fonctionné
			die('Erreur de connexion à la base de données. ' . mysqli_connect_error());
		}
		
		//$db = mysqli_select_db($laConnexion, 'stampee'); //local
		$db = mysqli_select_db($laConnexion, 'e2395496');  //webdev

		if (!$db) {
			die ('La base de données n\'existe pas.');
		}
		
		mysqli_query($laConnexion, 'SET NAMES "utf8"');
		return $laConnexion;
	}

	/**
	 * Exécute la requête SQL
	 * Si le paramètre $insert est true, retourne l'id de la ressource ajoutée à la db
	 */
	function executeRequete($requete, $insert = false) {
		global $connexion;
		if ($insert) {
			mysqli_query($connexion, $requete);
			return $connexion->insert_id;
		} else {
			$resultats = mysqli_query($connexion, $requete);
			return $resultats;
		}
	}

	function addEnchereToFavoris($idUser, $idEnchere) {
		global $connexion;
		$idUser = mysqli_real_escape_string($connexion, $idUser);
		$idEnchere = mysqli_real_escape_string($connexion, $idEnchere);
		return executeRequete("INSERT INTO favoris (id_utilisateur, id_enchere) VALUES ('$idUser', '$idEnchere')", true);
	}

	function removeEnchereFromFavoris($idUser, $idEnchere) {
		global $connexion;
        $idUser = mysqli_real_escape_string($connexion, $idUser);
        $idEnchere = mysqli_real_escape_string($connexion, $idEnchere);
        return executeRequete("DELETE FROM favoris WHERE id_utilisateur = '$idUser' AND id_enchere = '$idEnchere'", true);
    }

	function getEncheresByTimbresCategorie($categorie) {

		return executeRequete("SELECT enchere.id, prix_min, date_debut, date_fin, coup_de_coeur, enchere.id_utilisateur, active, enchere.id_timbre, timbre.*, etat.etat, pays_origine.pays, categorie.categorie, couleur.couleur, image.file
									FROM enchere
									JOIN timbre ON timbre.id = enchere.id_timbre
									JOIN categorie ON timbre.id_categorie = categorie.id
									JOIN etat ON timbre.id_etat = etat.id
									JOIN pays_origine ON timbre.id_pays_origine = pays_origine.id
									JOIN couleur ON timbre.id_couleur = couleur.id
									JOIN image ON timbre.id = image.id_timbre
									WHERE categorie = '$categorie'");

	}
	

	


?>
