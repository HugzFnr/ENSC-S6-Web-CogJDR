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

<form action="./gestion_compte.php" method="post">
    <input type="hidden" name="action" value="<?=isset($_SESSION['id']) ? "modifier" : "connecter" ?>">
    <input type="hidden" name="redirection_echec" value="<?=$_SERVER['REQUEST_URI']?>">
    <input type="hidden" name="redirection_succes" value="<?=$_SERVER['REQUEST_URI']?>">

    <input type="text" name="email" id="gestion_compte_email" placeholder="Entrez votre <?=isset($_SESSION['id']) ? "nouvel " : ""?>email"<?=isset($_SESSION['email']) ? " value=".$_SESSION['email'] : ""?>>
    <input type="password" name="mdp" id="gestion_compte_mdp" placeholder="Entrez un <?=isset($_SESSION['id']) ? "nouveaux " : ""?>mot de passe"<?=isset($_SESSION['mdp']) ? " value=".$_SESSION['mdp'] : ""?>>
    <input type="text" name="img" id="gestion_compte_img" value="sdbldb"><!--input type="file" name="img" id="gestion_compte_img"-->

    <button type="submit"><?=isset($_SESSION['id']) ? "Modifier les Donn&eacute;es" : "Se Connecter"?></button>
</form>
<hr>

<?php include "./inclus/discussion.php" ?>
<hr>

<?php require "./inclus/page_fin.php" ?>
