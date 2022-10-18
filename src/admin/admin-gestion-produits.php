<?php
session_start();

$arr_categories = array();
$arr_genres = array();
$arr_plateforme = ['PS1', 'PS2', 'PS3', 'PS4', 'PS5', 'PSP', 'PS-VITA', 'XBOX-X', 'XBOX-ONE', 'XBOX-360', 'SWITCH', 'WII-U', 'WII', '3DS', 'DS', 'PC', 'RETRO'];

include_once '../admin/admin-header.php';

require_once('../connect.php');

// recuperer les categories
$req1 = $bdd->prepare("SELECT id,libelle FROM catigories");
$req1->execute(array());
$arr_categories = $req1->fetchAll();

// recuperer les genres
$req2 = $bdd->prepare("SELECT id,libelle FROM genres");
$req2->execute(array());
$arr_genres = $req2->fetchAll();

if (
    isset($_POST['libelle']) && isset($_POST['description']) && isset($_POST['plateforme'])
    && isset($_POST['stock']) && isset($_POST['prix']) && isset($_FILES['photo'])
    // && isset($_POST['isSelected']) && isset($_POST['isDisponible']) && isset($_POST['isActive'])
) {
    if (
        !empty($_POST['libelle']) && !empty($_POST['description']) && !empty($_POST['plateforme']) &&
        !empty($_POST['stock'])
        // && !empty($_POST['photo'])
    ) {
        require_once('../connect.php');
        // VARIABLES
        $libelle        = htmlspecialchars($_POST['libelle']);
        $description    = htmlspecialchars($_POST['description']);
        $stock          = htmlspecialchars($_POST['stock']);
        $prix           = htmlspecialchars($_POST['prix']);

        $fabricant      = htmlspecialchars($_POST['fabricant']);
        $editeur        = htmlspecialchars($_POST['editeur']);

        $plateforme     = htmlspecialchars($_POST['plateforme']);
        $idGenre        = htmlspecialchars($_POST['genre']);
        $idCategorie    = htmlspecialchars($_POST['categorie']);

        isset($_POST['isSelected']) ? $isSelected = 1 : $isSelected = 0;
        isset($_POST['isDisponible']) ? $isDisponible = 1 : $isDisponible = 0;
        isset($_POST['isActive']) ? $isActive = 1 : $isActive = 0;

        if (isset($_POST['add'])) {

            //verifier si l'image existe == l'image a été stockée temporairement sur le serveur

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {

                if ($_FILES['photo']['size'] <= 3000000) { //l'image fait moins de 3MO

                    $informationsImage = pathinfo($_FILES['photo']['name']);
                    $extensionImage = $informationsImage['extension'];
                    $extensionsArray = array('png', 'gif', 'jpg', 'jpeg'); //extensions qu'on autorise
                    $imgProduit = htmlspecialchars($_FILES['photo']['name']);
                    // le type de l'image correspond à ce que l'on attend, on peut alors l'envoyer sur notre serveur
                    if (in_array($extensionImage, $extensionsArray)) {

                        $toDir = '../../img/produits/' . $plateforme;
                        if (!is_dir($toDir)) {
                            mkdir($toDir, 0777, true);
                        }

                        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $toDir . '/' . basename($_FILES['photo']['name']))) {
                            header('location: ../admin/admin-gestion-produits.php?error=1&message=Échec du téléchargement!, toDir=' . $toDir);
                            exit();
                        }
                        //Ajout produit
                        $req = $bdd->prepare("INSERT INTO produits (
                                    libelle,description,plateforme,editeur,stock,isDisponible,isActive,
                                    fabricant,idGenre,idCategorie,prix,image,isSelected) 
                                    VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                        if ($req->execute(array(
                            $libelle, $description, $plateforme, $editeur, $stock, $isDisponible,
                            $isActive, $fabricant, $idGenre, $idCategorie, $prix, $imgProduit, $isSelected
                        ))) {
                            header('location: ../admin/admin-gestion-produits.php?success=2');
                            exit();
                        } else {
                            header('location: ../admin/admin-gestion-produits.php?error=1&message=Une erreur est survernue pendant votre inscription.');
                            exit();
                        }
                    } else {
                        header('location: ../admin/admin-gestion-produits.php?error=1&message=Extention non autorisée.');
                        exit();
                    }
                } else {
                    header('location: ../admin/admin-gestion-produits.php?error=1&message=Verifiez la taille de l image.');
                    exit();
                }
            } else {
                header('location: ../admin/admin-gestion-produits.php?error=1&message=Une erreur est survernue pendant le télèchargement.');
                exit();
            }
        } elseif (isset($_POST['update'])) {
            // $Image = "";
            //verifier si l'image existe == l'image a été stockée temporairement sur le serveur
            // if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {

            //     if ($_FILES['photo']['size'] <= 3000000) { //l'image fait moins de 3MO

            //         $informationsImage = pathinfo($_FILES['photo']['name']);
            //         $extensionImage = $informationsImage['extension'];
            //         $extensionsArray = array('png', 'gif', 'jpg', 'jpeg'); //extensions qu'on autorise
            //         $imgProduit = htmlspecialchars($_FILES['photo']['name']);
            //         // le type de l'image correspond à ce que l'on attend, on peut alors l'envoyer sur notre serveur
            //         if (in_array($extensionImage, $extensionsArray)) {

            //             $toDir = '../../img/produits/' . $plateforme;
            //             if (!is_dir($toDir)) {
            //                 mkdir($toDir, 0777, true);
            //             }

            //             if (!move_uploaded_file($_FILES['photo']['tmp_name'], $toDir . '/' . basename($_FILES['photo']['name']))) {
            //                 header('location: ../admin/admin-gestion-produits.php?error=1&message=Échec du téléchargement!, toDir=' . $toDir);
            //                 exit();
            //             }
            //         } else {
            //             header('location: ../admin/admin-gestion-produits.php?error=1&message=Extention non autorisée.');
            //             exit();
            //         }
            //     } else {
            //         header('location: ../admin/admin-gestion-produits.php?error=1&message=Verifiez la taille de l image.');
            //         exit();
            //     }
            // } else {
            //     header('location: ../admin/admin-gestion-produits.php?error=1&message=Une erreur est survernue pendant le télèchargement.');
            //     exit();
            // }
            $id = $_POST['num'];
            //mise à jour du produit
            $req = $bdd->prepare("UPDATE produits 
                                  SET libelle=?,description=?,plateforme=?,editeur=?,stock=?,isDisponible=?,isActive=?,
                                    fabricant=?,idGenre=?,idCategorie=?,prix=?,isSelected=? 
                                    WHERE id=?
                                ");
            if ($req->execute(
                array(
                    $libelle, $description, $plateforme, $editeur, $stock, $isDisponible,
                    $isActive, $fabricant, $idGenre, $idCategorie, $prix, $isSelected, $id
                )
            )) {
                header('location: ../admin/admin-gestion-produits.php?success=2');
                exit();
            } else {
                header('location: ../admin/admin-gestion-produits.php?error=1&message=Une erreur est survernue pendant votre inscription.');
                exit();
            }
        } elseif (isset($_POST['delete'])) {
            $id = $_POST['num'];
            $req = $bdd->prepare("DELETE FROM produits WHERE id=?");
            if ($req->execute(array($id))) {
                header('location: ../admin/admin-gestion-produits.php?success=4');
                exit();
            } else {
                header('location: ../admin/admin-gestion-produits.php?error=1&message=Une erreur est survrnue pendant la suppression.');
                exit();
            }
        }
    } else {
        header('location: ../admin/admin-gestion-produits.php?error=1&message=Vous devez renseigner tous les champs.');
    }
}

?>

<section>
    <div class="container">
        <?php
        // echo var_dump($_GET);
        if (isset($_GET['error'])) {
            if (isset($_GET['message'])) {
                echo '<div class="bg-danger">' . htmlspecialchars($_GET['message']) . '</div>';
            }
        } elseif (isset($_GET['success'])) {
            if ($_GET['success'] == 1) {
                echo '<div class="bg-success">Vous êtes connecté.</div>';
            } else if ($_GET['success'] == 2) { //ajout réussi
                echo '<div class="bg-success">Ajout réussit.</div>';
            } elseif ($_GET['success'] == 3) { //mise à jour réussi
                echo '<div class="bg-success">Mise à jour effectuée.</div>';
            } elseif ($_GET['success'] == 4) { //suppression réussi
                echo '<div class="bg-success">Le produit a bien été supprimé.</div>';
            }
        }
        ?>
    </div>
    <?php
    if (isset($_SESSION['connect']) && $_SESSION['connect'] == 1) { ?>
        <h2 class="mt-5" style="border-bottom: #D917FA 2px solid;">Gestion des produits</h2>
        <div class="container border mx-3 my-3 pb-3">
            <div class="row  m-2 pt-2 border">
                <div class="col border m-2 pe-5">
                    <form method="POST" action="../admin/admin-gestion-produits.php" enctype="multipart/form-data">
                        <input type="hidden" name="num" id="num" class="">
                        <!-- maxlength=10 pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2} -->
                        <!-- libelle -->
                        <div class="input-group m-3">
                            <span class="input-group-text">Libellé</span>
                            <input type="text" name="libelle" id="libelle" class="form-control" required>
                        </div>
                        <!-- description -->
                        <div class="input-group m-3">
                            <span class="input-group-text">Description</span>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                        <!-- plate-forme -->
                        <div class="input-group m-3">
                            <span class="input-group-text">Plateforme</span>
                            <select class="form-select form-select-sm" name="plateforme" id="plateforme" required>
                                <option>Votre choix</option>
                                <?php foreach ($arr_plateforme as $plate) {
                                    echo '<option value="' . $plate . '">' . $plate . '</option>';
                                } ?>
                            </select>
                        </div>
                        <!-- editeur -->
                        <div class="input-group m-3">
                            <span class="input-group-text">Editeur</span>
                            <input type="text" name="editeur" id="editeur" class="form-control" maxlength=10>
                        </div>
                        <!-- quantité en stock -->
                        <div class="input-group m-3">
                            <span class="input-group-text">Quantité en stock</span>
                            <input type="text" name="stock" id="stock" class="form-control" title="Valeurs numérique attendues" required>
                        </div>
                        <!-- fabricant -->
                        <div class=" input-group m-3">
                            <span class="input-group-text">Fabricant</span>
                            <input type="text" name="fabricant" id="fabricant" class="form-control">
                        </div>
                        <!-- genre -->
                        <div class="input-group m-3">
                            <span class="input-group-text">Genre</span>
                            <select class="form-select form-select-sm" name="genre" id="genre" required>
                                <option selected>Votre choix</option>
                                <?php foreach ($arr_genres as $genre) {
                                    echo '<option value="' . $genre['id'] . '">' . $genre['libelle'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <!-- catégories -->
                        <div class="input-group m-3">
                            <span class="input-group-text">Catégorie</span>
                            <select class="form-select form-select-sm" name="categorie" id="categorie" required>
                                <option selected>Votre choix</option>
                                <?php foreach ($arr_categories as $categorie) {
                                    echo '<option  value="' . $categorie['id'] . '">' . $categorie['libelle'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <!-- prix -->
                        <div class="input-group m-3">
                            <span class="input-group-text">prix (€)</span>
                            <input type="text" name="prix" id="prix" class="form-control" title="Valeurs numérique à virgule attendues" required>
                        </div>
                        <!-- photo -->
                        <div class="input-group m-3">
                            <button class="btn btn-outline-secondary" type="button">Photo du produit</button>
                            <input type="file" class="form-control" name="photo" id="photo">
                        </div>
                        <div class="row">
                            <div class="col">
                                <!-- produit disponible -->
                                <div class="form-check form-switch border m-3">
                                    <input class="form-check-input" type="checkbox" name="isDisponible" id="isDisponible" checked>
                                    <label class="form-check-label" for="isDisponible">
                                        Disponible
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <!-- produit active -->
                                <div class="form-check form-switch border m-3">
                                    <input class="form-check-input" type="checkbox" name="isActive" id="isActive" checked>
                                    <label class="form-check-label" for="isActive">
                                        Activé
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <!-- produit sélectionné -->
                                <div class="form-check form-switch border m-3">
                                    <input class="form-check-input" type="checkbox" name="isSelected" id="isSelected" checked>
                                    <label class="form-check-label" for="isSelected">
                                        Selectionné
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Actions possible -->
                        <div class="col-12 d-md-flex justify-content-md-center mb-2">
                            <button class="btn btn-success " type="submit" name="add">Ajouter</button>
                            <button class="btn btn-warning mx-2" type="submit" name="update">Mettre à jour</button>
                            <button class="btn btn-danger" type="submit" name="delete">Supprimer</button>
                        </div>
                    </form>
                </div>
            </div>
            <h2 class="mt-5" style="border-bottom: #D917FA 2px solid;">Produits</h2>
            <div class="container pt-2 border">
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-bordered text-center table-hover table-sm align-middle" id="data_product">
                        <thead style="font-size:.9rem">
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">#</th>
                                <th style="display:none" scope="col">id</th>
                                <th scope="col">Libellé</th>
                                <th scope="col">Plateforme</th>
                                <th scope="col">Catégorie</th>
                                <th scope="col">Genre</th>
                                <th scope="col">Photo du produit</th>
                                <th scope="col">Date de création</th>
                                <th scope="col">Quantité en stock</th>
                                <th scope="col">Prix (€)</th>
                                <th scope="col">Editeur</th>
                                <th scope="col">Fabricant</th>
                                <th scope="col">Description</th>
                                <th scope="col">Disponible(o/n)</th>
                                <th scope="col">Active(o/n)</th>
                                <th scope="col">Selection(o/n)</th>
                            </tr>
                        </thead>
                        <tbody style="font-size:.7rem">
                            <?php
                            require_once('../connect.php');
                            $req = $bdd->prepare("SELECT pr.id, pr.libelle, pr.description, pr.plateforme, pr.editeur, pr.create_date, 
                                                        pr.stock, pr.isDisponible, pr.isActive, pr.fabricant, pr.prix, pr.image, pr.isSelected,
                                                        pr.idCategorie, c.libelle as categorie,pr.idGenre, g.libelle as genre
                                                FROM produits pr 
                                                LEFT JOIN catigories c ON pr.idCategorie = c.id 
                                                LEFT JOIN Genres g ON pr.idGenre = g.id 
                                                ORDER BY pr.id DESC") or die(print_r($bdd->errorInfo()));
                            $req->execute(array());
                            $i = 1;
                            while ($produit = $req->fetch()) {

                                $produit['isDisponible'] == 1 ? $isDisponible = '<input type="checkbox" value="1" disabled name="isDisponible" checked/>' : '<input type="checkbox" value="0" name="isDisponible"/>';
                                $produit['isActive'] == 1 ? $isActive =         '<input type="checkbox" value="1" disabled name="isActive" checked/>'     : '<input type="checkbox" value="0" name="isActive"/>';
                                $produit['isSelected'] == 1 ? $isSelected =     '<input type="checkbox" value="1" disabled name="isSelected" checked/>'   : '<input type="checkbox" value="0" name="isSelected"/>';
                                echo '<tr>
                                    <th scope="row">' . $i . '</th>
                                     <td><input type="checkbox" value="" id="chkbox' . $i . '"/></td>
                                    <td style="display:none">' . $produit['id'] . '</td>   
                                    <td>' . $produit['libelle'] . '</td>
                                    <td>' . $produit['plateforme'] . '</td>
                                    <td>' . $produit['categorie'] . '</td>
                                    <td>' . $produit['genre'] . '</td>
                                    <td><input type="image" src="/img/produits/' . $produit['plateforme'] . '/' . $produit['image'] . '" alt="" width="64" height="64"></td>
                                    <td>' . $produit['create_date'] . '</td>
                                    <td>' . $produit['stock'] . '</td>
                                    <td>' . $produit['prix'] . '</td>
                                    <td>' . $produit['editeur'] . '</td>
                                    <td>' . $produit['fabricant'] . '</td>
                                    <td>' . $produit['description'] . '</td>
                                    <td> ' . $isDisponible . '</td>
                                    <td> ' . $isActive . '</td>
                                    <td>' . $isSelected . '</td>
            
                                </tr>';
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>

        <?php
    }
        ?>
</section>
<script type="text/javascript">
    let table = document.getElementById("data_product");
    let arr_plateforme = ['PS1', 'PS2', 'PS3', 'PS4', 'PS5', 'PSP', 'PS-VITA', 'XBOX-X', 'XBOX-ONE', 'XBOX-360', 'SWITCH', 'WII-U', 'WII', '3DS', 'DS', 'PC', 'RETRO'];
    let categories = ['JEUX', 'JEUX RETRO', 'ACCESSOIRES', 'CONSOLES'];
    let genres = ['ACTION', 'AVIATION', 'COMBAT', 'COURSE', 'JEUX DE SOCIETE', 'JEUX DE RÔLE', 'LUDO EDUCATION'];

    table.addEventListener("click", function(e) {
        let idx = e.target.closest('td').parentNode.rowIndex;
        let allTr = table.querySelectorAll("tr");
        for (let i = 0; i < allTr.length; i++) {
            if (i == idx) {
                //on est sur la bonne ligne
                let tds = allTr[i].getElementsByTagName("td");
                let index = 0;

                for (td of tds) {
                    // alert(index + ' : ' + td.innerHTML);
                    switch (index) {
                        case 1:
                            document.getElementById('num').setAttribute('value', td.innerHTML);
                            break;
                        case 2:
                            document.getElementById('libelle').setAttribute('value', td.innerHTML);
                            break;
                        case 12:
                            document.getElementById('description').innerHTML = td.innerHTML;
                            break;
                        case 3:
                            document.getElementById('plateforme').options[arr_plateforme.indexOf(td.innerHTML) + 1].selected = true;
                            break;
                        case 10:
                            document.getElementById('editeur').setAttribute('value', td.innerHTML);
                            break;
                        case 8:
                            document.getElementById('stock').setAttribute('value', td.innerHTML);
                            break;
                        case 9:
                            document.getElementById('prix').setAttribute('value', td.innerHTML);
                            break;
                        case 11:
                            document.getElementById('fabricant').setAttribute('value', td.innerHTML);
                            break;
                        case 6:
                            document.getElementById('photo').innerHTML = 'mario_carte.jpg'; //td.innerHTML;
                            break;
                        case 5:
                            document.getElementById('genre').options[genres.indexOf(td.innerHTML) + 1].selected = true;
                            break;
                        case 4:
                            document.getElementById('categorie').options[categories.indexOf(td.innerHTML) + 1].selected = true;
                            break;
                        case 13:
                            (td.innerHTML.split('')[31] == "1") ? document.getElementById('isDisponible').checked = true: document.getElementById('isDisponible').checked = false;
                            break;
                        case 14:
                            (td.innerHTML.split('')[31] == "1") ? document.getElementById('isActive').checked = true: document.getElementById('isActive').checked = false;
                            break;
                        case 15:
                            (td.innerHTML.split('')[30] == "1") ? document.getElementById('isSelected').checked = true: document.getElementById('isSelected').checked = false;
                            break;
                    }
                    index++;
                }
            }
        }
    });
</script>

</body>

</html>