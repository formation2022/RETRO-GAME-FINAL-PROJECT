<?php
session_start();
include_once('./src/header.php');
include_once('./src/utils.php');
// detruire la session admin
if (isset($_SESSION['connect']) && $_SESSION['connect'] == 1 && $_SESSION['role'] == 'Admin') {
    session_unset(); // DESACTIVE LA SESSION
    session_destroy(); // DETRUIT LA SESSION
    setcookie('auth', '', time() - 1, '/', null, false, true); // DETRUIT LE COOKIE
}
if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
    if ($_SESSION['connect'] == 1) {
        include_once('./src/ajouterpanier.php');
        $_SESSION['panier'] = 1;
    } else {
        header('location: index.php?error=1&message=Vous devez être connecté pour ajouter des produits dans le panier.');
    }
}
?>
<main>
    <div class="container">
        <?php
        // echo var_dump($_GET);
        if (isset($_GET['error'])) {
            if (isset($_GET['message'])) {
                echo '<div class="bg-danger">' . htmlspecialchars($_GET['message']) . '</div>';
            }
        } elseif (isset($_GET['success'])) {
            if ($_GET['success'] == 1) {
                if (isset($_GET['message'])) {
                    echo '<div class="bg-success">' . htmlspecialchars($_GET['message']) . '</div>';
                }
            }
        }
        ?>
    </div>
    <div class="album py-2 bg-light">
        <div class="container">
            <div class="row text-center col-sm-12">
                <?php
                include_once('./src/connect.php');
                $req = $bdd->prepare("SELECT * FROM produits WHERE isSelected = 1");
                $req->execute();
                while ($produit = $req->fetch()) {
                    printElement(
                        $produit['libelle'],
                        $produit['description'],
                        $produit['id'],
                        $produit['prix'],
                        $produit['image'],
                        $produit['plateforme']
                    );
                }
                ?>
            </div>
        </div>
    </div>
</main>

<?php
include_once('./src/footer.php');
?>