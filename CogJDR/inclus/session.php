<?php
    session_start();

    // TMP.lel
    if (empty($_SESSION['liste_donnees_jd'])) {
        $_SESSION['liste_donnees_jd'] = array(
            array(
                'id_jdr' => 0,

                'id_joueur' => 1,
                'nom_joueur' => "<code>Joueur(id_joueur=1, id_jrd_participe=0) # pseudo</code>",

                'id_equipe_liste' => array(0, 1, 2, 3),
                'nom_equipe_liste' => "<code>(array) EstDans(id_joueur=1)</code>",

                'id_equipe_discussion_suivi' => 0,
                'nom_equipe_discussion_suivi' => "<code>ModeleEquipe( id_modele_equipe=Equipe(id_modele_equipe=0) ) # titre_equipe</code>"
            ),
            array(
                'id_jdr' => 1,

                'id_joueur' => 7,
                'nom_joueur' => "<code>Joueur(id_joueur=7, id_jrd_participe=1) # pseudo</code>",

                'id_equipe_liste' => array(42, 12, 69),
                'nom_equipe_liste' => "<code>(array) EstDans(id_joueur=7)</code>",

                'id_equipe_discussion_suivi' => 12,
                'nom_equipe_discussion_suivi' => "<code>ModeleEquipe( id_modele_equipe=Equipe(id_modele_equipe=12) ) # titre_equipe</code>"
            )
        );
        $_SESSION['indice_jdr_suivi'] = 0; // indice dans la liste d'au dessus :)
    }
    //$_SESSION['id'] = 1;
?>
