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
		//define('DB_PASSWORD', '');			// Windows

		$laConnexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
				
		if (!$laConnexion) {
			// La connexion n'a pas fonctionné
			die('Erreur de connexion à la base de données. ' . mysqli_connect_error());
		}
		
		$db = mysqli_select_db($laConnexion, 'stampee');

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

	


?>
