<?php
    session_start();

    function maj_donnees_jdr() {
        if (!isset($_SESSION['id']))
            return false;

        $liste_constructeur = array();

        /*- selection sur la table Joueur */
        $r = sql_select('Joueur', "*", array('id_utilisateur' => $_SESSION['id']));
        while ($joueur = $r->fetch()) {
            array_push($liste_constructeur, array(
                'est_mj' => false,
                'id_jdr' => $joueur['id_jdr_participe'],
                'titre_jdr' => sql_select(
                        array('JDR', 'ModeleJDR'),
                        array('ModeleJDR.titre'),
                        array(
                            'JDR::id_modele_jdr' => 'ModeleJDR::id_modele_jdr',
                            'JDR::id_jdr' => $joueur['id_jdr_participe'],
                        )
                    )->fetch()['titre'],

                'id_dans' => $joueur['id_joueur'],
                'pseudo_dans' => $joueur['pseudo'],

                'liste_equipe' => sql_select(
                        array(
                            'EstDans',
                            'Equipe',
                            'ModeleEquipe'
                        ),
                        array(
                            'Equipe.id_equipe',
                            'ModeleEquipe.titre_equipe'
                        ),
                        array(
                            'EstDans::id_equipe' => 'Equipe::id_equipe',
                            'Equipe::id_modele_equipe' => 'ModeleEquipe::id_modele_equipe',
                            'EstDans::id_joueur' => $joueur['id_joueur']
                        ),
                        null,
                        true
                    )->fetchAll(PDO::FETCH_ASSOC),
                'indice_equipe_discussion_suivi' => 0
            ));
        }
        /*- FIN table Joueur */

        /*- selection sur la table MJ */
        $r = sql_select('MJ', "*", array('id_utilisateur' => $_SESSION['id']));
        while ($mj = $r->fetch()) {
            array_push($liste_constructeur, array(
                'est_mj' => true,
                'id_jdr' => $mj['id_jdr_dirige'],
                'titre_jdr' => sql_select(
                        array('JDR', 'ModeleJDR'),
                        array('ModeleJDR.titre'),
                        array(
                            'JDR::id_modele_jdr' => 'ModeleJDR::id_modele_jdr',
                            'JDR::id_jdr' => $mj['id_jdr_dirige'],
                        )
                    )->fetch()['titre'],

                'id_dans' => $mj['id_mj'],
                'pseudo_dans' => $mj['pseudo_mj'],
                
                'liste_equipe' => sql_select(
                        array(
                            'Equipe',
                            'ModeleEquipe',
                        ),
                        array(
                            'Equipe.id_equipe',
                            'ModeleEquipe.titre_equipe'
                        ),
                        array(
                            'Equipe::id_modele_equipe' => 'ModeleEquipe::id_modele_equipe',
                            'Equipe::id_jdr' => $mj['id_jdr_dirige']
                        ),
                        null,
                        true
                    )->fetchAll(PDO::FETCH_ASSOC),
                'indice_equipe_discussion_suivi' => 0
            ));
        }
        /*- FIN table MJ */
        
        $_SESSION['liste_donnees_jdr'] = $liste_constructeur;
        $_SESSION['indice_jdr_suivi'] = count($liste_constructeur) - 1; // indice dans la liste d'au dessus :)
    }

    function maj_jdr_suivi() {
        if ($_SESSION['indice_jdr_suivi'] < 0)
            foreach ($_SESSION['liste_donnees_jdr'] as $k => $v)
                if ($v['id_jdr'] == $_REQUEST['id']) {
                    $_SESSION['indice_jdr_suivi'] = $k;
                    return true;
                }
        return false;
    }
?>
