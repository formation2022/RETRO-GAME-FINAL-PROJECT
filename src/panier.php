<?php 
    include('../src/header.php'); 
?>
<div class="container">
    <div class="row mb-5">
        <h2 class="mt-5" style="border-bottom: #D917FA 2px solid;">Votre panier</h2>
        <div class="col-md-1">
        </div>
        <div class="col-md-10 border pe-5">
            <h5 class="mt-5" style="color: #D917FA;">Votre panier est vide pour le moment.</h6> 
            <h6>Parcourez les plateformes pour trouver les produits que vous souhaitez acheter.</h6>  
            <div class="col-10 d-md-flex justify-content-md-end gap-md-2 pb-2">
                <button onClick="window.location.href ='../index.php';" class="btn btn-success p-2"  type="button">Je continue mes achats</button>
                <button class="btn btn-success"  type="button">Je valide mon panier</button>
            </div>                        
        </div>  
        
    </div>
</div>
<?php include('../src/footer.php'); ?>
	

