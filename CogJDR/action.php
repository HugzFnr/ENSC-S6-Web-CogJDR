<?php
    /**
     * Actions :
     * 
     *  1. voter : (côté joueur) applique le vote d'un joueur (créer une entrée `Action_`)
     *  0. effectuer : (côté MJ) effectue les action programés par un `ModeleAction`
     */

    require_once "./inclus/connexion.php";
    require_once "./inclus/session.php";

    $donnees_jdr = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']];

    $__fond_ecran = $donnees_jdr['img_fond'];
    $__css_necessaires[] = "jdr";
    include_once "./inclus/page_debut.php";

    if ($donnees_jdr['est_mj'])
        include "./inclus/action/mj.php";
    else
        include "./inclus/action/joueur.php";
?>

<?php include_once "./inclus/page_fin.php" ?>
