<?php
    session_start();

    // TMP.lel
    if (empty($_SESSION['liste_donnees_jd'])) {
        $_SESSION['liste_donnees_jd'] = array(
            array(
                'id_jdr' => 0,
                'id_equipe_liste' => array(0, 1, 2, 3),
                'id_equipe_discussion_suivi' => 0,
                'id_joueur' => 1
            ),
            array(
                'id_jdr' => 1,
                'id_equipe_liste' => array(42, 12, 69),
                'id_equipe_discussion_suivi' => 12,
                'id_joueur' => 7
            )
        );
        $_SESSION['indice_jdr_suivi'] = 0; // indice dans la liste d'au dessus :)
    }
    //$_SESSION['id'] = 1;
?>
