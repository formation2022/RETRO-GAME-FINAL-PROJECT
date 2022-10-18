<?php

session_start();

if ((isset($_POST['email']) && isset($_POST['password'])) && (isset($_POST['admin']) || isset($_POST['vendeur']))) {
    if (isset($_POST['admin'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            require_once('../src/connect.php');
            // VARIABLES
            $email                 = htmlspecialchars($_POST['email']);
            $password             = htmlspecialchars($_POST['password']);
            // ADRESSE EMAIL VALIDE
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('location: ../src/commun/dashboard.php?error=1&message=Votre adresse email est invalide.');
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
                    header('location: ../src/commun/dashboard.php?success=1');
                    exit();
                } else {
                    header('location: ../src/dashboard.php?error=1&message=Impossible de vous authentifier correctement.');
                    exit();
                }
            } else {
                header('location: ../src/commun/dashboard.php?error=1&message=Impossible de vous authentifier correctement.');
                exit();
            }
        }
    } else if (isset($_POST['vendeur'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            require_once('../src/connect.php');
            // VARIABLES
            $email                 = htmlspecialchars($_POST['email']);
            $password             = htmlspecialchars($_POST['password']);
            // ADRESSE EMAIL VALIDE
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('location: ../src/commun/dashboard.php?error=1&message=Votre adresse email est invalide.v');
                exit();
            }
            // HASH
            $secret = sha1($email) . time();
            $secret = sha1($secret) . time();
            // CHIFFRAGE DU MOT DE PASSE
            $password = "aq1" . sha1($password . "123") . "25";

            // CONNEXION
            $req = $bdd->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
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
                            header('location: ../src/commun/dashboard.php?success=1');
                            exit();
                        } else {
                            header('location: ../src/commun/dashboard.php?error=1&message=Impossible de vous authentifier correctement.');
                            exit();
                        }
                    } else {
                        header('location: ../src/commun/dashboard.php?error=1&message=Votre compte est bloqué pour le moment, contactez un administrateur.');
                        exit();
                    }
                } else {
                    header('location: ../src/commun/dashboard.php?error=1&message=Vous devez être vendeur pour se connecter ici.');
                    exit();
                }
            } else {
                header('location: ../src/commun/dashboard.php?error=1&message=Impossible de vous authentifier correctement.');
                exit();
            }
        }
    } else {
        echo 'test';
    }
}
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['nom']) && isset($_POST['prenom'])) {
    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
        require_once('../src/connect.php');
        // VARIABLES
        $email                 = htmlspecialchars($_POST['email']);
        $password             = htmlspecialchars($_POST['password']);
        $nom                 = htmlspecialchars($_POST['nom']);
        $prenom             = htmlspecialchars($_POST['prenom']);
        $role             = 'Vendeur';
        isset($_POST['isBlocked']) ? $isblocked = 1 : $isblocked = 0;

        // ADRESSE EMAIL VALIDE
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('location: ../src/commun/dashboard.php?error=1&message=Votre adresse email est invalide.');
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
                header('location: ../src/commun/dashboard.php?success=2');
                exit();
            } else {
                header('location: ../src/commun/dashboard.php?error=1&message=Une erreur est survrnue pendant votre inscription.');
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
                header('location: ../src/commun/dashboard.php?success=2');
                exit();
            } else {
                header('location: ../src/dashboard.php?error=1&message=Une erreur est survrnue pendant la mise à jour.');
                exit();
            }
        } elseif (isset($_POST['delete'])) {
            $id = $_POST['num'];
            $req = $bdd->prepare("DELETE FROM users WHERE id=?");
            if ($req->execute(array($id))) {
                header('location: ../src/commun/dashboard.php?success=2');
                exit();
            } else {
                header('location: ../src/commun/dashboard.php?error=1&message=Une erreur est survrnue pendant la suppression.');
                exit();
            }
        }
    } else {
        header('location: ../src/commun/dashboard.php?error=1&message=Vous devez reseigner tout les champs.');
        exit();
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Retrogame</title>
    <!--pour eviter la surcharge du cache -->
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="Keywords" content="JEUX,RETRO GAME,VIDEO,PS,PS1,PS2,PS3,PS4,PS5,3DS,DS,PSP,PS VITA,SWITCH,WII U,WII,PC,MOBILE,MANETTE,GAME,GAMEBOY">
    <meta name="description" content="RetroGame - Boutique Retrogaming depuis très longtemps, Retro Game propose un large choix de jeux vidéos et consoles retros. 
            Super Nintendo, Megadrive, Playstation...avec plus de 5000 références sur une trentaine de consoles différentes, découvrez ou redécouvrez ce qui a fait l'histoire du jeu vidéo! 
            Visitez également notre Espace mangas d'occasion à des prix défiants toute concurrence! ">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./Design/style.css">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .form-control-dark {
            border-color: var(--bs-gray);
        }

        .form-control-dark:focus {
            border-color: #fff;
            box-shadow: 0 0 0 .25rem rgba(255, 255, 255, .25);
        }

        .text-small {
            font-size: 85%;
        }

        .dropdown-toggle {
            outline: 0;
        }
    </style>
    <link rel="icon" type="image/png" href="../img/Retrogame_1.png">
</head>

<body>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="bootstrap" viewBox="0 0 118 94">
            <title>Bootstrap</title>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"></path>
        </symbol>
        <symbol id="home" viewBox="0 0 16 16">
            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z" />
        </symbol>
        <symbol id="speedometer2" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z" />
            <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z" />
        </symbol>
        <symbol id="table" viewBox="0 0 16 16">
            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z" />
        </symbol>
        <symbol id="people-circle" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
        </symbol>
        <symbol id="grid" viewBox="0 0 16 16">
            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z" />
        </symbol>
    </svg>
    <header>
        <div class="px-3 py-2 text-bg-dark">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="../src/commun/dashboard.php" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                        <img src="../img/retrogame.png" alt="retrogame" width="90" height="90" class="bi me-2 rounded-pill">
                    </a>
                    <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                        <li>
                            <a href="../index.php" class="nav-link text-secondary">
                                <svg class="bi d-block mx-auto mb-1" width="24" height="24">
                                    <use xlink:href="#home" />
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white">
                                <svg class="bi d-block mx-auto mb-1" width="24" height="24">
                                    <use xlink:href="#speedometer2" />
                                </svg>
                                Tableau de
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white">
                                <svg class="bi d-block mx-auto mb-1" width="24" height="24">
                                    <use xlink:href="#table" />
                                </svg>
                                Vendeurs
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white">
                                <svg class="bi d-block mx-auto mb-1" width="24" height="24">
                                    <use xlink:href="#grid" />
                                </svg>
                                Produits
                            </a>
                        </li>
                        <li>
                            <div class="dropdown text-end">
                                <a href="#" class="d-block nav-link text-decoration-none dropdown-toggle text-white" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="../img/profil.png" alt="mdo" width="32" height="32" class="rounded-circle bg-light">
                                </a>
                                <ul class="dropdown-menu text-small">
                                    <li><a class="dropdown-item" href="#">Log in</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../src/commun/logout-admin.php">Log out</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
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
        <?php
        if (isset($_SESSION['connect']) && $_SESSION['connect'] == 1) { ?>
            <h2 class="mt-5" style="border-bottom: #D917FA 2px solid;">Gestion des vendeurs</h2>
            <div class="container border m-2">
                <div class="row  m-2 border">
                    <div class="col border m-2 pe-5">
                        <form method="POST" action="../src/dashboard.php">
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
                                require_once('../src/connect.php');
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
                <h2 class="mt-5" style="border-bottom: #D917FA 2px solid;">Identification</h2>
                <div class="container">
                    <div class="row my-5">
                        <div class="col border pe-5">
                            <form method="POST" action="../src/dashboard.php">
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