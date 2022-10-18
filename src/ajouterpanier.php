<?php

include_once('./src/connect.php');

if (isset($_POST["product_id"]) && !empty($_POST["product_id"])) {
    $idProduit = $_POST["product_id"];
    if (isset($_SESSION['idClient'])) {
        $client_id = $_SESSION['idClient'];
    } else {
        header('location: ./index.php?error=1&message=Vous devez être connécté pour ajouter des produits dans le panier.');
        exit();
    }
    //verifier si l'article exist
    $req1 = $bdd->prepare("SELECT * FROM panier WHERE idProduit = ? AND idClient = ?");
    $req1->execute(array($idProduit, $client_id));
    $qte = 0;
    while ($element = $req1->fetch()) {
        $qte = $element['quantite'];
    }
    if ($qte == 0) {
        $req = $bdd->prepare("SELECT * FROM produits WHERE id = ?");
        $req->execute(array($idProduit));
        while ($produit = $req->fetch()) {
            $prix = $produit['prix'];
            $libelle = $produit['libelle'];
            $description = $produit['description'];
        }
        //inserer la ligne du produit
        $req = $bdd->prepare("INSERT INTO panier (idProduit,prix,idClient) VALUES (?,?,?)");
        $req->execute(array($idProduit, $prix, $client_id));
    } else {
        $qte++;
        //mise à jour de la ligne du produit dns le panier
        $req2 = $bdd->prepare("UPDATE panier SET quantite = ? WHERE idProduit = ?");
        $req2->execute(array($qte, $idProduit));
    }
}
