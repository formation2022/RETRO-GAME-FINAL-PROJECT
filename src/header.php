<?php
if (isset($_SESSION['profil'])) {
    if (empty($_SESSION['profil'])) {
        $imgProfile = "profil.png";
    } else {
        $imgProfile = $_SESSION['profil'];
    }
} else {
    $imgProfile = "profil.png";
}

?>
<!DOCTYPE html>
<html lang=fr>

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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="./Design/style.css">
    <link rel="icon" type="image/png" href="../img/Retrogame_1.png">
</head>

<body>
    <!--  text-bg-dark -->
    <header class="p-3" style="background-color:#D917FA;">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="../img/retrogame.png" alt="retrogame" width="90" height="90" class="bi me-2 rounded-pill">
                </a>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="../src/jeuxretro.php" class="nav-link px-2 text-white">Jeux retro</a></li>
                    <li><a href="../src/jeux.php" class="nav-link px-2 text-white">Jeux</a></li>
                    <li><a href="../src/console.php" class="nav-link px-2 text-white">Consoles</a></li>
                    <li><a href="../src/accessoires.php" class="nav-link px-2 text-white">Accessoires</a></li>
                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <input type="search" class="form-control form-control " placeholder="Search..." aria-label="Search">
                </form>

                <div class="text-end">
                    <button type="button" onClick="window.location.href ='/src/login.php';" class="btn btn-outline-light me-2">Login</button>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo " <img src=\"../img/profils/$imgProfile\" alt=\"profile\" width=\"32\" height=\"32\" class=\"rounded-circle\">" ?> </a>
                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href="../src/panier.php">Mon panier</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../src/admin/admin-login.php">Admin</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../src/logout.php">Log out</a></li>
                    </ul>
                </div>
                <!--  -->
                <div class="navbar-nav mx-2">
                    <a href="../src/panier.php" class="nav-item nav-link active">
                        <h5 class="mt-2 cart">
                            <i class="fas fa-shopping-cart"></i>
                            <?php

                            // if (isset($_SESSION['cart'])) {
                            //     $count = count($_SESSION['cart']);
                            //     echo "<span id=\"cart_count\" class=\"text-warning bg-light\">$count</span>";
                            // } else {
                            //     echo "<span id=\"cart_count\" class=\"text-warning bg-light\">0</span>";
                            // }

                            ?>
                        </h5>
                    </a>
                </div>
                <!--  -->
            </div>

        </div>
    </header>