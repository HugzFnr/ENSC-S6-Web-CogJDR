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

    /** Récupère le `id_equipe` de l'équipe issue du modèle d'ID `id_modele_equipe` dans le JDR d'ID `id_jdr`. */
    function equipe_de_modele($id_modele_equie, $id_jdr) {
        return sql_select('Equipe', 'id_equipe', array('id_jdr' => $id_jdr, 'id_modele_equipe' => $id_modele_equie))->fetch()['id_equipe'];
    }

    /** Retire le joueur cible d'ID `id_joueur` de léquipe de modèle d'ID `id_modele_equipe` dans le JDR d'ID `id_jdr`. */
    function retirer_equipe($id_joueur, $id_modele_equie, $id_jdr) {
        return $id_modele_equie != null && sql_delete('EstDans', array(
                'id_joueur' => $id_joueur,
                'id_equipe' => equipe_de_modele($id_modele_equie, $id_jdr)
            ));
    }

    /** Ajoute le joueur cible d'ID `id_joueur` à l'équipe de modèle d'ID `id_modele_equipe` dans le JDR d'ID `id_jdr`. */
    function ajouter_equipe($id_joueur, $id_modele_equie, $id_jdr) {
        return $id_modele_equie != null && sql_insert('EstDans', array(
                'id_joueur' => $id_joueur,
                'id_equipe' => equipe_de_modele($id_modele_equie, $id_jdr)
            ));
    }
    
    /** 
     * Effectue l'action précisé par le modèle dans le context donné (`$context['action']`), notamment :
     *  - retirer le joueur d'une équipe,
     *  - ajouter le joueur à une équipe,
     *  - formatter et retouner le message du `ModeleAction`.
     */
    function effectuer_action($id_cible, $context) {
        // ajoute les détails de la cible dans le context
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
        
        // effectu l'action à proprement parler
        retirer_equipe($cible['id_joueur'], $context['action']['action_effet_id_modele_equipe_depart'], $context['jdr']['id_jdr']);
        ajouter_equipe($cible['id_joueur'], $context['action']['action_effet_id_modele_equipe_arrive'], $context['jdr']['id_jdr']);
        
        // prépare le message en replacant toute les $variables; par leur `$context['variable']`
        $action_message = $context['action']['message_action'];

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
