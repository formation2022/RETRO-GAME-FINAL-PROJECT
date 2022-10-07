<?php
		require('src/connect.php');

		// CONNEXION
		$req = $db->prepare("SELECT p.libelle, p.description, p.plateforme, p.isDisponible, p.stock, p.isActive, p.prix, a.note
                          FROM produits p
                          LEFT JOIN avis a ON (p.id = a.idProduit)
                          WHERE p.isActive = 1 AND p.isDisponible = 1;"
                          );
		$req->execute();

		while($user = $req->fetch()){
      
		}

?>
