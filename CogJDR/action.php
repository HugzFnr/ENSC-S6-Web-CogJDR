<?php
    $__css_necessaires[] = "jdr";
    include_once "./inclus/page_debut.php";
?>

<?php
    require_once "./inclus/connexion.php";
    require_once "./inclus/session.php";

    $donnees_jdr = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']];

    if ($donnees_jdr['est_mj'])
        include "./inclus/action/mj.php";
    else
        include "./inclus/action/joueur.php";
?>

<?php include_once "./inclus/page_fin.php" ?>
