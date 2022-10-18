<?php
session_start();
include('../src/header.php');
require_once('./connect.php');

//un click sur le bouton "+/-" d'une ligne produit dans le panier
if (isset($_GET['action'])) {
    if (isset($_GET['product']) && !empty($_GET['product'])) {
        $prodId = htmlspecialchars($_GET['product']);
        $qte = 0;
        //recuperer la quantité produit dans le panier
        $reqs = $bdd->prepare("SELECT quantite FROM panier WHERE idProduit = ?");
        $reqs->execute(array($prodId));
        while ($panier = $reqs->fetch()) {
            $qte = $panier['quantite'];
        }
        if ($_GET['action'] == 'add') {
            //mise à jour de la ligne panier
            $req = $bdd->prepare("UPDATE panier SET quantite = (quantite + 1) WHERE idProduit = ?");
            $req->execute(array($prodId));
        } elseif ($_GET['action'] == 'remove') {
            if ($qte == 1) {
                //supprimer le produit du panier
                $reqd = $bdd->prepare("DELETE FROM panier WHERE idProduit = ?");
                $reqd->execute(array($prodId));
            } else {
                //mise à jour de la ligne panier
                $req = $bdd->prepare("UPDATE panier SET quantite = (quantite - 1) WHERE idProduit = ?");
                $req->execute(array($prodId));
            }
        }
    }
    header('location: ../src/panier.php');
}
?>
<div class="container bg-dark">
    <div class="row mb-5">
        <h2 class="mt-5" style="border-bottom: #D917FA 2px solid;">Votre panier</h2>
        <div class="col-md-1">

        </div>
        <div class="col-md-10 border pe-5">
            <div class="row">
                <?php
                if (isset($_SESSION['connect']) && $_SESSION['connect'] == 1) {
                    if (!isset($_SESSION['panier'])) { ?>
                        <h5 class="mt-2" style="color: #D917FA;">Votre panier est vide pour le moment.</h5>
                        <h6 class="p-2">Parcourez les plateformes pour trouver les produits que vous souhaitez acheter.</h6>
                    <?php   }
                } else { ?>
                    <h5 class="mt-2" style="color: #D917FA;">Votre panier est vide pour le moment.</h5>
                    <h6 class="mb-2">Parcourez les plateformes pour trouver les produits que vous souhaitez acheter.</h6>
                <?php } ?>
            </div>
            <!--  -->
            <div class="container text-center ">
                <div class="row justify-content-md-center bg-success">
                    <div class="col col-lg-6">
                        PRODUITS
                    </div>
                    <div id="test" class="col">
                        PRIX UNITAIRE
                    </div>
                    <div class="col">
                        QUANTITE
                    </div>
                    <div class="col">
                        TOTAL
                    </div>
                </div>
                <!--  -->
                <?php
                include_once('../src/connect.php');
                include_once('../src/utils.php');

                // parcourir les éléments du panier
                $req1 = $bdd->prepare("SELECT idProduit,quantite,id FROM panier WHERE idClient = ?");
                if (isset($_SESSION['idClient'])) {
                    $req1->execute(array($_SESSION['idClient']));
                }
                $total = 0.00;
                $fraisPort = 5.99;
                while ($panier = $req1->fetch()) {
                    $productid = $panier['idProduit'];
                    $qte = $panier['quantite'];
                    $panierId = $panier['id'];
                    //aller chercher les infos du produit
                    $req2 = $bdd->prepare("SELECT libelle,plateforme,prix,image 
                                            FROM produits
                                            WHERE id = ?");
                    $req2->execute(array($productid));

                    while ($produit = $req2->fetch()) {
                        $productimg = $produit['image'];
                        $plateforme = $produit['plateforme'];
                        $productname = $produit['libelle'];
                        $productprice = $produit['prix'];
                        $total += $productprice * $qte;
                        afficherElementDuPanier($panierId, $productimg, $plateforme, $productname, $productprice, $productid, $qte);
                    }
                    $total += $fraisPort;
                }
                if ($total == 0) {
                    $_SESSION['panier'] = 0;
                }
                ?>
                <!--  -->
                <div class="row">
                    <div class="col-10 d-md-flex justify-content-md-end gap-md-2 py-2">
                        FRAIS DE PORT
                    </div>
                    <div class="col border">
                        <?php echo $fraisPort . ' €'; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10 d-md-flex justify-content-md-end gap-md-2 py-2">
                        TOTAL
                    </div>
                    <div class="col border">
                        <?php echo $total . ' €'; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10 d-md-flex justify-content-md-end gap-md-2 py-2">
                        <button onClick="window.location.href ='../index.php';" class="btn btn-success p-2" type="button">Je continue mes achats</button>
                        <button class="btn btn-success" type="button">Je valide mon panier</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php include('../src/footer.php'); ?>