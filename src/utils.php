<?php
    function printElement($libelle,$description,$price,$image){
        echo '
            <div class="col">
                <div class="card shadow-sm ">
                    <img src="/img/'.$image.'" 
                        alt="'.$libelle.'" 
                        width="55%" height="225px" class="card-img">
                    <div class="card-body">
                        <p class="card-text text-center ">'.$price.'€</p>
                        <p class="card-text text-center">'.$description.'</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="rating">
                                <div class="stars">
                                    <i class="fa fa-star gold">☆</i>
                                    <i class="fa fa-star gold">☆</i>
                                    <i class="fa fa-star">☆</i>
                                    <i class="fa fa-star">☆</i>
                                    <i class="fa fa-star">☆</i>
                                </div>
                            </div>
                            <small class="text-muted">9 avis</small>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
?>