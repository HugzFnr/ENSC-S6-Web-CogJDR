<?php
    /**
     * Ce fichier pourra contenir un parser perso pour :
     *  - effectuer l'action
     *      . contitions ?
     *  - message aux joueur
     *      . :variables
     *      . cibles ?
     */
    require_once "./inclus/connexion.php";
    require_once "./inclus/session.php";
    
    function effectuer_action($id_cible, $context) {
        $cible = sql_select(
                array('Joueur', 'Utilisateur'),
                array(
                    'Joueur.id_joueur',
                    'Joueur.pseudo',
                    'Utilisateur.id',
                    'Utilisateur.email'
                ),
                array(
                    'Utilisateur::id' => 'Joueur::id_utilisateur',
                    'Joueur::id_joueur' => $id_cible
                )
            )->fetch();
        $context['cible'] = $cible;

        $action_effet = $context['action']['action_effet'];
        $action_message = $context['action']['message_action'];
        /*- TODO */

        $parties = explode("$", $action_message);
        $retour = $parties[0];
        unset($parties[0]);
        foreach ($parties as $partie) {
            $tmp = explode(";", $partie, 2);
            $clefs = explode(".", $tmp[0]);

            $donnee = $context;
            foreach ($clefs as $clef)
                $donnee = $donnee[$clef];
            
            $retour.= $donnee.$tmp[1];
        }
        return $retour;
    }
?>
