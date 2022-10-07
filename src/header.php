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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./Design/style.css">
    <script src="../js/script.js"></script>
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
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../img/profil.png" alt="profile" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small" style="">
                        <li><a class="dropdown-item" href="../src/panier.php">Mon panier</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../src/dashboard.php">Admin</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../src/logout.php">Log out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>