<?php
	session_start();
	require('../src/log.php');
 	if(isset($_SESSION['connect'])){
		header('location: ..\index.php');
		exit();
	} 
	if(!empty($_POST['emaill']) && !empty($_POST['passwordd'])){
		require('../src/connect.php');
		// VARIABLES
		$email 				= htmlspecialchars($_POST['emaill']);
		$password 			= htmlspecialchars($_POST['passwordd']);
		// ADRESSE EMAIL VALIDE
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			header('location: login.php?error=1&message=Votre adresse email est invalide.');
			exit();
		}
		// HASH
		$secret = sha1($email).time();
		$secret = sha1($secret).time();
		// CHIFFRAGE DU MOT DE PASSE
		$password = "aq1".sha1($password."123")."25";
		// CONNEXION
		$req = $bdd->prepare("SELECT * FROM users WHERE email = ?");
		$req->execute(array($email));
		while($user = $req->fetch()){
			if($password == $user['password']){
				$_SESSION['connect'] = 1;
				$_SESSION['email']   = $user['email'];
				if(isset($_POST['auto'])){
					setcookie('auth', $user['secret'], time() + 364*24*3600, '/', null, false, true);
				}
				header('location: login.php?success=1');
				exit();
			}
			else {
				header('location: login.php?error=1&message=Impossible de vous authentifier correctement.');
				exit();
			}
		}
	}
?>
<?php include('../src/header.php'); ?>
<section>
    <div id="login-body">
        <div class="container">
            <?php if(isset($_GET['error'])){
                if(isset($_GET['message'])) {
                    echo'<div class="bg-danger">'.htmlspecialchars($_GET['message']).'</div>';
                }
                } else if(isset($_GET['success'])) {
                echo'<div class="bg-success">Vous êtes connecté.</div>';
                header('location: ..\index.php');
            } ?> 
            <h2 class="mt-5" style="border-bottom: #D917FA 2px solid;">Identification / Inscription</h2>
            <p class="mb-3">Vous étes déja client chez nous?</p>
            <p class="mb-3">Connectez vous en utilisant vos identifiants habituels </p>
            <div class="container">
                <div class="row my-5">
                    <div class="col border pe-5">
                        <p class="bg-black text-center text-light w-100%">
                            Déjà client? Connéctez vous.
                        </p>
                        <form method="POST" action="login.php">
                            <div class="input-group m-3">
                                <span class="input-group-text">Votre email</span>
                                <input type="email" name="emaill" class="form-control" placeholder="exemple@google.fr" >
                            </div>
                            <div class="input-group m-3">
                                <span class="input-group-text" >Votre mot de passe</span>
                                <input type="password" name="passwordd" class="form-control" placeholder="*********">
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="auto" checked>
                                <label class="form-check-label" for="flexSwitchCheckChecked">Rester connecté lors de mes prochaines visites</label>
                            </div>
                            <div class="col-12 d-md-flex justify-content-md-end">
                                <button class="btn btn-success" type="submit">Connection</button>
                            </div>
                        </form>
                    </div>
                    <div class="col border pe-5">
                        <p class="bg-black text-center text-light w-100%">
                            Déjà client? Connéctez vous.
                        </p>
                        <form method="POST" action="inscription.php">
                            <p class="mb-3 text-center">Afin de réaliser vos achats sur RetroGame.fr, vous aurez besoin d'un compte.</p>
                            <p class="mb-3 text-center">Devenir membre est gratuit et facile. Tout ce dont vous avez besoin est une adresse email valide.</p>
                            <div class="input-group m-3">
                                <span class="input-group-text">Votre email</span>
                                <input type="email" name="preEmail" class="form-control" placeholder="exemple@google.fr" >
                            </div>
                            <div class="col-12 d-md-flex justify-content-md-end ">
                                <button class="btn btn-success"  type="submit">Je crée mon compte</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('../src/footer.php'); ?>