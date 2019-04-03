<?php
    $quoi = isset($_REQUEST['quoi']) ? $_REQUEST['quoi'] : "partie";

    if ($quoi == "partie") {
        $__sous_titre = "Créer une nouvelle partie";
        include "./inclus/page_debut.php";

        include "./inclus/creer/partie.php";
    } else/*if ($quoi == "modele")*/ {
        $__sous_titre = "Créer un nouveau modèle de JDR";
        include "./inclus/page_debut.php";

        include "./inclus/creer/$quoi.php";
    }

    include "./inclus/page_fin.php";
?>
