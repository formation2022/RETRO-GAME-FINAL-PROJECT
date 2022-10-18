<?php

session_start();

include_once '../admin/admin-header.php';

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['nom']) && isset($_POST['prenom'])) {
    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
        require_once('../connect.php');
        // VARIABLES
        $email                 = htmlspecialchars($_POST['email']);
        $password             = htmlspecialchars($_POST['password']);
        $nom                 = htmlspecialchars($_POST['nom']);
        $prenom             = htmlspecialchars($_POST['prenom']);
        $role             = 'Vendeur';
        isset($_POST['isBlocked']) ? $isblocked = 1 : $isblocked = 0;

        // ADRESSE EMAIL VALIDE
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("location: ../admin/admin-gestion-vendeurs.php?error=1&message=l'adresse email est invalide.");
            exit();
        }
        if (isset($_POST['add'])) {
            // HASH
            $secret = sha1($email) . time();
            $secret = sha1($secret) . time();
            // CHIFFRAGE DU MOT DE PASSE
            $password = "aq1" . sha1($password . "123") . "25";

            $req = $bdd->prepare("INSERT INTO users(nom,prenom,email, password,cle,role,isBlocked) VALUES(?,?,?,?,?,?,?)");
            if ($req->execute(array($nom, $prenom, $email, $password, $secret, 'Vendeur', $isblocked))) {
                header('location: ../admin/admin-gestion-vendeurs.php?success=2');
                exit();
            } else {
                header('location: ../admin/admin-gestion-vendeurs.php?error=1&message=Une erreur est survrnue pendant votre inscription.');
                exit();
            }
        } elseif (isset($_POST['update'])) {
            $email                 = htmlspecialchars($_POST['email']);
            $password             = htmlspecialchars($_POST['password']);
            $nom                 = htmlspecialchars($_POST['nom']);
            $prenom             = htmlspecialchars($_POST['prenom']);
            $role             = 'Vendeur';
            isset($_POST['isBlocked']) ? $isblocked = 1 : $isblocked = 0;
            // HASH
            // $secret = sha1($email) . time();
            // $secret = sha1($secret) . time();
            // CHIFFRAGE DU MOT DE PASSE
            // $password = "aq1" . sha1($password . "123") . "25";

            $id = $_POST['num'];
            $req = $bdd->prepare("UPDATE users SET nom=?,prenom=?,email=?, password=?,isBlocked=? WHERE id=?");
            if ($req->execute(array($nom, $prenom, $email, $password, $isblocked, $id))) {
                header('location: ../admin/admin-gestion-vendeurs.php?success=3');
                exit();
            } else {
                header('location: ../admin/admin-gestion-vendeurs.php?error=1&message=Une erreur est survrnue pendant la mise à jour.');
                exit();
            }
        } elseif (isset($_POST['delete'])) {
            $id = $_POST['num'];
            $req = $bdd->prepare("DELETE FROM users WHERE id=?");
            if ($req->execute(array($id))) {
                header('location: ../admin/admin-gestion-vendeurs.php?success=4');
                exit();
            } else {
                header('location: ../admin/admin-gestion-vendeurs.php?error=1&message=Une erreur est survrnue pendant la suppression.');
                exit();
            }
        }
    } else {
        header('location: ../admin/admin-gestion-vendeurs.php?error=1&message=Vous devez reseigner tout les champs.');
        exit();
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
                echo '<div class="bg-success">Le vendeur a bien été supprimé.</div>';
            }
        }
        ?>
    </div>
    <?php
    if (isset($_SESSION['connect']) && $_SESSION['connect'] == 1) { ?>
        <h2 class="mt-5" style="border-bottom: #D917FA 2px solid;">Gestion des vendeurs</h2>
        <div class="container border m-2">
            <div class="row  m-2 border">
                <div class="col border m-2 pe-5">
                    <form method="POST" action="../admin/admin-gestion-vendeurs.php">
                        <input type="hidden" name="num" id="num" class="">
                        <div class="input-group m-3">
                            <span class="input-group-text">Nom</span>
                            <input type="text" name="nom" id="nom" class="form-control" placeholder="" required>
                        </div>
                        <div class="input-group m-3">
                            <span class="input-group-text">Prénom</span>
                            <input type="text" name="prenom" id="prenom" class="form-control" placeholder="" required>
                        </div>
                        <div class="input-group m-3">
                            <span class="input-group-text">Email</span>
                            <input type="email" name="email" id="email" class="form-control" placeholder="vendeur@google.fr" required>
                        </div>
                        <div class="input-group m-3">
                            <span class="input-group-text">Mot de passe</span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="*****" required>
                        </div>
                        <div class="form-check form-switch border m-3">
                            <!-- <input class="form-check-input" type="radio" name="isBlocked" id="isBlocked"> -->
                            <input class="form-check-input" type="checkbox" name="isBlocked" id="isBlocked">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Bloqué
                            </label>
                        </div>
                        <div class="col-12 d-md-flex justify-content-md-center mb-2">
                            <button class="btn btn-success " type="submit" name="add">Ajouter</button>
                            <button class="btn btn-warning mx-2" type="submit" name="update">Mettre à jour</button>
                            <button class="btn btn-danger" type="submit" name="delete">Supprimer</button>
                        </div>
                    </form>
                </div>
            </div>
            <h2 class="mt-5" style="border-bottom: #D917FA 2px solid;">Liste des vendeurs</h2>
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover" id="data_seller">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th style="display:none" scope="col">id</th>
                                <th scope="col">N° vendeur</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Email</th>
                                <th scope="col">Mot de passe</th>
                                <th scope="col">Bloqué(o/n)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once('../connect.php');
                            $req = $bdd->prepare("SELECT * FROM users WHERE role='Vendeur'") or die(print_r($bdd->errorInfo()));
                            $req->execute(array());
                            $i = 1;
                            while ($user = $req->fetch()) {
                                echo '<tr>
                                    <td>
                                        <input type="checkbox" value="" id="chkbox' . $i . '"/>
                                    </td>
                                    <td style="display:none">' . $user['id'] . '</td>
                                    <td>' . $i . '</td>
                                    <td>' . $user['nom'] . '</td>
                                    <td>' . $user['prenom'] . '</td>
                                    <td>' . $user['email'] . '</td>
                                    <td>' . $user['password'] . '</td>
                                    <td>' . $user['isBlocked'] . '</td>
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
<script>
    let table = document.getElementById("data_seller");
    //e.target va être l'élément cliqué (un td, un élément de texte, etc.)
    //on cherche le "td" le plus proche, puis l'index de la ligne
    //on récupère chaque td de cette ligne
    table.addEventListener("click", function(e) {
        let idx = e.target.closest('td').parentNode.rowIndex;
        let allTr = table.querySelectorAll("tr");
        for (let i = 0; i < allTr.length; i++) {
            if (i == idx) {
                //on est sur la bonne ligne
                let tds = allTr[i].getElementsByTagName("td");
                let index = 0;
                for (td of tds) {
                    switch (index) {
                        case 1:
                            document.getElementById('num').setAttribute('value', td.innerHTML);
                            break;
                        case 3:
                            document.getElementById('nom').setAttribute('value', td.innerHTML);
                            break;
                        case 4:
                            document.getElementById('prenom').setAttribute('value', td.innerHTML);
                            break;
                        case 5:
                            document.getElementById('email').setAttribute('value', td.innerHTML);
                            break;
                        case 6:
                            document.getElementById('password').setAttribute('value', td.innerHTML);
                            break;
                        case 7:
                            (td.innerHTML == 1) ? document.getElementById('isBlocked').checked = true: document.getElementById('isBlocked').checked = false;
                            break;
                    }
                    index++;
                }
            }
        }
    });
</script>




<!-- <script src="../js/script.js"></script> -->
</body>

</html>