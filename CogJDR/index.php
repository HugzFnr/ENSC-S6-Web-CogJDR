<?php
    // temporaire (je crois)
    $__css_necessaires[] = "discussion";
?>

<?php require "./inclus/page_debut.php" ?>

<?php
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == "creer") { // affiche le formulaire de création de compte
        include "./inclus/inscription.php";
    } elseif (isset($_SESSION['id'])) { // affiche les liste des JDR disponibles, rejoints et dirigés
        require_once "./inclus/connexion.php";
        require_once "./inclus/session.php";
        
        if (!empty($_SESSION['liste_donnees_jdr']))
            $id_utilisateur = $_SESSION['id'];

        include "./inclus/jdr/liste.php";
    } else { // description à l'adresse de nouveaux utilisateur et visiteurs ?>
        <h1>Cog' JDR</h1>

        <p>Ce site vous permet de jouer à des parties de jeux de rôle type boîte mail avec vos camarades de promo que vous aimez tant; mais aussi de créer vos propres JDR et les inviter ! ...</p>
        <p>Placeat amet rem fuga. Iste earum dolor est dolorem. Labore nihil voluptas porro non et neque. Quaerat quaerat doloremque nihil alias consequatur. Rerum reprehenderit et dignissimos et.</p>
        <p>Omnis aspernatur provident illum quod sit rerum provident aut. Tenetur alias in aut et porro. Necessitatibus id ut fugit qui ducimus sed non.</p>
<?php
    }
?>


<?php require "./inclus/page_fin.php" ?>
