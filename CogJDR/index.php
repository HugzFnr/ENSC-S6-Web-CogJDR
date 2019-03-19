<?php require "./inclus/page_debut.php" ?>

<!--
    Plusieurs de ces pages sont à caractère de tests !
    (evidement_lol.php)
-->

<?php
    if (isset($_SESSION['erreur'])) { ?>
        <h2><?=$_SESSION['erreur']?></h2>
        <hr><?php
        unset($_SESSION['erreur']);
    }
?>

<form action="./compte.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="redirection_echec" value="<?=$_SERVER['REQUEST_URI']?>">
    <input type="hidden" name="redirection_succes" value="<?=$_SERVER['REQUEST_URI']?>">

    <input type="text" name="email" id="gestion_compte_email" placeholder="Entrez votre <?=isset($_SESSION['id']) ? "nouvel " : ""?>email"<?=isset($_SESSION['email']) ? " value=".$_SESSION['email'] : ""?>>
    <input type="password" name="mdp" id="gestion_compte_mdp" placeholder="Entrez un <?=isset($_SESSION['id']) ? "nouveaux " : ""?>mot de passe"<?=isset($_SESSION['mdp']) ? " value=".$_SESSION['mdp'] : ""?>>
    <input type="file" name="img" id="gestion_compte_img"<?=isset($_SESSION['img']) ? " value=".$_SESSION['img'] : ""?>>

    <button type="submit" name="action" value="connecter">Se Connecter</button>
    <button type="submit" name="action" value="creer">Créer le Compte</button>
</form>

<?php
    if (isset($_SESSION['liste_donnees_jdr'])) {
        echo "<hr>";
        include "./inclus/discussion.php";
    }
?>

<?php require "./inclus/page_fin.php" ?>
