<?php

session_start();
include_once '../admin/admin-header.php';

if (isset($_SESSION['connect']) && $_SESSION['connect'] == 1) {
    header('location: ../admin/dashboard.php');
    exit();
}

if ((isset($_POST['email']) && isset($_POST['password'])) && (isset($_POST['admin']) || isset($_POST['vendeur']))) {
    if (isset($_POST['admin'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            require_once('../connect.php');
            // VARIABLES
            $email                 = htmlspecialchars($_POST['email']);
            $password             = htmlspecialchars($_POST['password']);
            // ADRESSE EMAIL VALIDE
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('location: ../admin/admin-login.php?error=1&message=Votre adresse email est invalide.');
                exit();
            }
            // HASH
            $secret = sha1($email) . time();
            $secret = sha1($secret) . time();
            // CHIFFRAGE DU MOT DE PASSE
            $password = "aq1" . sha1($password . "123") . "25";

            // CONNEXION
            $req = $bdd->prepare("SELECT * FROM sadmin WHERE email = ? LIMIT 1");
            $req->execute(array($email));
            $user = $req->fetch();
            if ($user) {
                if ($password == $user["password"]) {
                    $_SESSION['connect'] = 1;
                    $_SESSION['email']   = $user['email'];
                    $_SESSION['role']   = 'Admin';
                    header('location: ../admin/dashboard.php?success=1');
                    exit();
                } else {
                    header('location: ../admin/admin-login.php?error=1&message=Impossible de vous authentifier correctement.');
                    exit();
                }
            } else {
                header('location: ../admin/admin-login.php?error=1&message=Impossible de vous authentifier correctement.');
                exit();
            }
        }
    } else if (isset($_POST['vendeur'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            require_once('../connect.php');
            // VARIABLES
            $email                 = htmlspecialchars($_POST['email']);
            $password             = htmlspecialchars($_POST['password']);
            // ADRESSE EMAIL VALIDE
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('location: ../admin/admin-login.php?error=1&message=Votre adresse email est invalide.');
                exit();
            }
            // HASH
            $secret = sha1($email) . time();
            $secret = sha1($secret) . time();
            // CHIFFRAGE DU MOT DE PASSE
            $password = "aq1" . sha1($password . "123") . "25";

            // CONNEXION
            $req = $bdd->prepare("SELECT * FROM users WHERE email = ? AND role = 'Vendeur'");
            $req->execute(array($email));
            $user = $req->fetch();
            if ($user) {
                //tester le rôle
                if ($user['role'] == 'Vendeur') {
                    if (!$user['isBlocked']) {
                        //tester si le vendeur n'est pas bloqué
                        if ($password == $user['password']) {
                            $_SESSION['connect'] = 1;
                            $_SESSION['email']   = $user['email'];
                            $_SESSION['role']   = 'Vendeur';
                            header('location: ../admin/dashboard.php?success=1');
                            exit();
                        } else {
                            header('location: ../admin/admin-login.php?error=1&message=Impossible de vous authentifier correctement.');
                            exit();
                        }
                    } else {
                        header('location: ../admin/admin-login.php?error=1&message=Votre compte est bloqué pour le moment, contactez un administrateur.');
                        exit();
                    }
                } else {
                    header('location: ../admin/admin-login.php?error=1&message=Vous devez être vendeur pour se connecter ici.!!!' . $user['role']);
                    exit();
                }
            } else {
                header('location: ../admin/admin-login.php?error=1&message=Impossible de vous authentifier correctement.');
                exit();
            }
        }
    } else {
        echo 'test';
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
            } else {
                echo '<div class="bg-success">Ajout réussit.</div>';
            }
        }
        ?>
    </div>
    <h2 class="mt-5" style="border-bottom: #D917FA 2px solid;">Identification Admin / Vendeur</h2>
    <div class="container">
        <div class="row my-5">
            <div class="col border pe-5">
                <form method="POST" action="../admin/admin-login.php">
                    <div class="input-group m-3">
                        <span class="input-group-text">Votre email</span>
                        <input type="email" name="email" class="form-control" placeholder="exemple@google.fr" required>
                    </div>
                    <div class="input-group m-3">
                        <span class="input-group-text">Votre mot de passe</span>
                        <input type="password" name="password" class="form-control" placeholder="*****" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="admin" id="admin">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Administrateur
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="vendeur" id="vendeur">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Vendeur
                        </label>
                    </div>
                    <div class="col-12 d-md-flex justify-content-md-end mb-2">
                        <button class="btn btn-success" type="submit">Connection</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>