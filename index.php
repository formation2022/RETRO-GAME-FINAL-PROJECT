<?php
    include_once('./src/header.php');
    include_once('./src/utils.php');    
?>
<main>
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-6 row-cols-md-3">
                <?php
                    include_once('./src/connect.php'); 
                    $req = $bdd->prepare("SELECT * FROM produits");
                    $req->execute();
                    while($produit = $req->fetch()){
                        printElement($produit['libelle'],$produit['description'],$produit['prix'],$produit['image']);
                    }
                ?>                   
            </div>
        </div>
    </div>
</main>

<?php
    include_once('./src/footer.php');
?>
