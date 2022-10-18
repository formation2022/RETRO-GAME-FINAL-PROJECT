<?php
session_start();

require_once('../src/connect.php');
$preEmail = '';
if (isset($_POST['preEmail']) && !empty($_POST['preEmail'])) {
    $preEmail = htmlspecialchars($_POST['preEmail']);
}

//traitement de l'email saisie dans le document avant
if ((isset($_POST['email']) && !empty($_POST['email'])) &&
    (isset($_POST['password']) && !empty($_POST['password'])) &&
    (isset($_POST['confirmpassword']) && !empty($_POST['confirmpassword'])) &&
    (isset($_POST['pseudo']) && !empty($_POST['pseudo'])) &&
    (isset($_POST['civilite']) && !empty($_POST['civilite'])) &&
    (isset($_POST['nom']) && !empty($_POST['nom'])) &&
    (isset($_POST['prenom']) && !empty($_POST['prenom'])) &&
    // (isset($_POST['portable']) && !empty($_POST['portable'])) &&
    (isset($_POST['datedenaissance']) && !empty($_POST['datedenaissance'])) &&
    (isset($_POST['adresse']) && !empty($_POST['adresse'])) &&
    (isset($_POST['pays']) && !empty($_POST['pays'])) &&
    (isset($_POST['codepostal']) && !empty($_POST['codepostal'])) &&
    (isset($_POST['ville']) && !empty($_POST['ville'])) &&
    (isset($_POST['conditiongeneral']) && !empty($_POST['conditiongeneral'])) //&&
    //(isset($_POST['complement']) && !empty($_POST['complement'])) &&
    //(isset($_POST['newsletter']) && !empty($_POST['newsletter']))
) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirmpassword = htmlspecialchars($_POST['confirmpassword']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $civilite = htmlspecialchars($_POST['civilite']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $portable = htmlspecialchars($_POST['portable']);
    $datedenaissance = htmlspecialchars($_POST['datedenaissance']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $complement = htmlspecialchars($_POST['complement']);
    $pays = htmlspecialchars($_POST['pays']);
    $codepostal = htmlspecialchars($_POST['codepostal']);
    $ville = htmlspecialchars($_POST['ville']);
    $conditiongeneral = htmlspecialchars($_POST['conditiongeneral']);
    $newsletter = htmlspecialchars($_POST['newsletter']);

    // echo 0;
    // ADRESSE EMAIL VALIDE
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('location: ../src/inscription.php?error=1&message=Votre adresse email est invalide.');
        exit();
    }
    // echo 1;
    if ($password !== $confirmpassword) {
        header('location: ../src/inscription.php?error=1&message=Vos mots de passe ne sont pas identiques.');
        exit();
    }
    // echo 2;
    // EMAIL DEJA UTILISEE
    $req = $bdd->prepare("SELECT count(*) as numberEmail FROM users WHERE email = ?");
    $req->execute(array($email));
    while ($email_verification = $req->fetch()) {
        if ($email_verification['numberEmail'] != 0) {
            header('location: ../src/inscription.php?error=1&message=Votre adresse email est déjà utilisée par un autre utilisateur.');
            exit();
        }
    }
    // HASH
    $secret = sha1($email) . time();
    $secret = sha1($secret) . time();
    // CHIFFRAGE DU MOT DE PASSE
    $password = "aq1" . sha1($password . "123") . "25";
    // echo $password."KLM".$secret;

    //verifier si l'image existe == l'image a été stockée temporairement sur le serveur
    if (isset($_FILES['profilImage']) && $_FILES['profilImage']['error'] == 0) {

        if ($_FILES['profilImage']['size'] <= 3000000) { //l'image fait moins de 3MO

            $informationsImage = pathinfo($_FILES['profilImage']['name']);
            $extensionImage = $informationsImage['extension'];
            $extensionsArray = array('png', 'gif', 'jpg', 'jpeg'); //extensions qu'on autorise
            $profilImage = htmlspecialchars($_FILES['profilImage']['name']);
            // le type de l'image correspond à ce que l'on attend, on peut alors l'envoyer sur notre serveur
            if (in_array($extensionImage, $extensionsArray)) {
                // on renomme notre image avec une clé unique suivie du nom du fichier
                move_uploaded_file($_FILES['profilImage']['tmp_name'], '../img/profils/' . basename($_FILES['profilImage']['name']));
            }
        }
    }

    // ENVOI
    $req = $bdd->prepare("INSERT INTO users(nom,prenom,email, password,cle,role,profilImage) VALUES(?,?,?,?,?,?,?)");
    if ($req->execute(array($nom, $prenom, $email, $password, $secret, 'Client', $profilImage))) {
        header('location: ../src/inscription.php?success=1');
        exit();
    } else {
        header('location: ../src/inscription.php?error=1&message=Une erreur est survrnue pendant votre inscription.');
        exit();
    }
}
?>
<?php
include('../src/header.php');
?>
<div class="container">
    <?php if (isset($_GET['error'])) {
        if (isset($_GET['message'])) {
            echo '<div class="bg-danger">' . htmlspecialchars($_GET['message']) . '</div>';
        }
    } else if (isset($_GET['success'])) {
        echo '<div class="bg-success">Vous êtes désormais inscrit. <br><a class="link active" href="../src/login.php">Connectez-vous</a>.</div>';
    } ?>
    <div class="row mb-5">
        <h2 class="mt-5" style="border-bottom: #D917FA 2px solid;">Identification / Inscription</h2>
        <div class="col-md-1">
        </div>
        <div class="col-md-8 border pe-5">
            <h4 class="mt-5" style="color: #D917FA;">Vos identifiants</h4>
            <form method="post" action="inscription.php" enctype="multipart/form-data">
                <div class="input-group m-3">
                    <span class="input-group-text" id="email">Adresse email *</span>
                    <?php echo "<input type=\"email\" name=\"email\" value= \"$preEmail\" 
                            class=\"form-control\" placeholder=\"exemple@google.fr\" required>"
                    ?>

                </div>
                <div class="input-group m-3">
                    <span class="input-group-text">Mot de passe *</span>
                    <input type="password" name="password" class="form-control" placeholder="*********" required>
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text">Confirmation mot de passe *</span>
                    <input type="password" name="confirmpassword" class="form-control" placeholder="*********" required>
                </div>
                <h4 class="mt-5" style="color: #D917FA;">Vos informations</h4>
                <div class="input-group m-3">
                    <span class="input-group-text">Pseudo *</span>
                    <input type="text" name="pseudo" class="form-control" placeholder="slider" required>
                </div>
                <!-- photo de profil -->
                <div class="input-group m-3">
                    <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon03">Image profile</button>
                    <input type="file" class="form-control" name="profilImage" aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                </div>

                <div class="input-group m-3">
                    <span class="input-group-text">civilité *</span>
                    <select class="form-select form-select-sm" name="civilite" required>
                        <option selected>Votre choix</option>
                        <option value="Mme">Madame</option>
                        <option value="Mr">Monsieur</option>
                    </select>
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text">Nom *</span>
                    <input type="text" name="nom" class="form-control" placeholder="" required>
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text">Prénom *</span>
                    <input type="text" name="prenom" class="form-control" required>
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text">Portable</span>
                    <!-- maxlength=10 pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2} -->
                    <input type="tel" name="portable" class="form-control">
                </div>
                <div class=" input-group m-3">
                    <span class="input-group-text">Date de naissance *</span>
                    <input type="date" name="datedenaissance" class="form-control" placeholder="jj/mm/aaaa" required>
                </div>
                <h4 class="mt-5" style="color: #D917FA;">Votre adresse</h4>
                <div class="input-group m-3">
                    <span class="input-group-text">Adresse *</span>
                    <input type="text" name="adresse" class="form-control" placeholder="" required>
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text">Complément</span>
                    <input type="text" name="complement" class="form-control" placeholder="">
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text">Pays *</span>
                    <select class="form-select form-select-sm" name="pays" required>
                        <option selected>Pays</option>
                        <option value="france">France</option>
                        <option value="maroc">Maroc</option>
                    </select>
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text">Code postal *</span>
                    <input type="text" name="codepostal" class="form-control" maxlength=5 required>
                </div>
                <div class="input-group m-3">
                    <span class="input-group-text">Ville *</span>
                    <input type="text" name="ville" class="form-control" placeholder="" required>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="conditiongeneral" required>
                    <label class="form-check-label" for="conditiongeneral">J'accepte les conditions générales de vente et les conditions générales d'utilisation.</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="newsletter">
                    <label class="form-check-label" for="newsletter">J'accepte de recevoir des offres de la part de Retrogame.fr .</label>
                </div>
                <div class="col-12 d-md-flex justify-content-md-end mb-3">
                    <button class="btn btn-success" type="submit">Je cée mon compte</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include('../src/footer.php'); ?>