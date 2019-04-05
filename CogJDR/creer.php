<?php
    $quoi = isset($_REQUEST['quoi']) ? $_REQUEST['quoi'] : "partie";

    if ($quoi == "partie") {
        $__sous_titre = "Créer une nouvelle partie";
        include "./inclus/page_debut.php";

        include "./inclus/creer/partie.php";
    } elseif ($quoi == "modele") {
        $__sous_titre = "Créer un nouveau modèle de JDR";
        include "./inclus/page_debut.php";

        include "./inclus/creer/modele.php";
    } elseif ($quoi == "modele_v2") {
        $__sous_titre = "Créer un nouveau modèle de JDR";
        include "./inclus/page_debut.php";

        include "./inclus/creer/modele_v2.php";
    } else
        header("Location: ./#");

    include "./inclus/page_fin.php";
?>
