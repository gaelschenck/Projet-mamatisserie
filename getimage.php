<?php 
require_once("config.php");

$id = $_GET['id'];
		if ($id){  
			$sql = "SELECT CreationName, CreationDescription,CreationImage FROM création WHERE Id = $id";
			$query = $dbh -> prepare($sql);
			// $query->bindParam(":creationimage", PDO::PARAM_STR);
			// $query->bindParam(":creationname", PDO::PARAM_STR);
			// $query->bindParam(":creationdescription", PDO::PARAM_STR);
			$query->execute();
			$result = $query->fetch();
			error_log(print_r($result,1));
			if ($result){
				echo json_encode (['jajax' => $result]);
				}
		}else{
			echo json_encode (['jajax' => "Erreur"]);
		};
/* Cette fonction est declenchee au moyen d'un appel AJAX depuis le formulaire de sortie de livre */
/* On recupere le numero l'identifiant du lecteur SID---*/
// On prepare la requete de recherche du lecteur correspondnat
// On execute la requete
// Si un resultat est trouve
	// On affiche le nom du lecteur
	// On active le bouton de soumission du formulaire
// Sinon
	// Si le lecteur n existe pas
		// On affiche que "Le lecteur est non valide"
		// On desactive le bouton de soumission du formulaire
	// Si le lecteur est bloque
		// On affiche lecteur bloque
		// On desactive le bouton de soumission du formulaire

?>
