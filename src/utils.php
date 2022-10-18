<?php
// <p class="card-text">
//  $description
// </p>
function printElement($libelle, $description, $productid, $price, $image, $plateforme)
{
    $prix = round($price + ($price / 2), 2);
    $element = "
                <div class=\"col-md-3 col-sm-6 my-3 my-md-0\">
                    <form action=\"index.php\" method=\"post\">
                        <div class=\"card shadow mb-2\" style=\"width: 18rem;\">
                            <div class=\"bg-img\">
                                <img src=\"/img/produits/$plateforme/$image\" alt=\"$image\" class=\"img-fluid card-img-top m-2\">
                            </div>
                            <div class=\"card-body\">
                                <div class=\"titre\">
                                    <h5 class=\"card-title\">$libelle</h5>
                                </div>
                                <h6>
                                    <i class=\"fas fa-star\"></i>
                                    <i class=\"fas fa-star\"></i>
                                    <i class=\"fas fa-star\"></i>
                                    <i class=\"fas fa-star\"></i>
                                    <i class=\"far fa-star\"></i>
                                </h6>
                                <small><s class=\"text-secondary\">$prix</s></small>
                                <span class=\"price\">$price €</span><br />
                                <button type=\"submit\" class=\"btn btn-warning my-3\" name=\"add\">Ajouter au panier<i class=\"fas fa-shopping-cart\"></i></button>
                                <input type='hidden' name='product_id' value='$productid'>
                            </div>
                        </div>
                    </form>
                </div>
                ";
    echo $element;
}

function afficherElementDuPanier($id, $productimg, $plateforme, $productname, $productprice, $productid, $qte)
{
    $total = $qte * $productprice;
    $element = "
                <div class=\"row justify-content-md-center border\">
                    <div class=\"col col-lg-6\">
                        <div class=\"row\">
                            <div class=\"col \">
                                <img src=\"../img/produits/$plateforme/$productimg\" height=\"70\" alt=\"\">
                            </div>
                            <div class=\"col pt-3\">$productname</div>
                        </div>
                    </div>
                    <div class=\"col pt-3\">
                        $productprice €
                    </div>
                    <div class=\"col text-center pt-3\">
                        <a class=\"btn btn-secondary\" href=\"/../src/panier.php?action=remove&amp;product=$productid&amp;onBasket=true\" role=\"button\"><i class=\"fas fa-minus\"></i></a>
                        <input type=\"text\" disabled=\"disabled\" id=\"qte\" style=\"width: 40px;text-align:center\" value=\"$qte\" min=1 max=5>
                        <a class=\"btn btn-secondary\" href=\"/../src/panier.php?action=add&amp;product=$productid&amp;onBasket=true\" role=\"button\"><i class=\"fas fa-plus\"></i></a>
                        
                    </div>
                    <div class=\"col pt-3\">
                        $total €
                    </div>
                </div>
    ";
    echo  $element;
}
