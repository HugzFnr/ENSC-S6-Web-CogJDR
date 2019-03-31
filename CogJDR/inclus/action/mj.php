<div class="container">
<table class="container liste_joueurs">
    <?php
        // récupère le modèle visé
        $modele = sql_select(
                'ModeleAction',
                array(
                    'titre_action',
                    'desc_action',
                    'horaire_activ',
                    'message_action',
                    'action_effet_id_modele_equipe_depart',
                    'action_effet_id_modele_equipe_arrive',
                    'action_fct'
                ),
                array(
                    'id_modele_action' => $_REQUEST['id']
                )
            )->fetch();
        
        if ($modele) { ?>
            <h3><?=$modele['titre_action']?></h3>
            <p><?=$modele['desc_action']?></p><?php

            // récupère la liste des joueus ciblés par les action de ce modèle (en passant par le modèle d'équipe ciblé)
            $cibles = sql_select(
                    array('Cible', 'ModeleEquipe', 'Equipe', 'EstDans', 'Joueur', 'Utilisateur'),
                    array(
                        'ModeleEquipe.titre_equipe',
                        'Joueur.pseudo',
                        'Joueur.id_joueur',
                        'Utilisateur.email',
                        'Utilisateur.id'
                    ),
                    array(
                        'ModeleEquipe::id_modele_equipe' => 'Cible::id_modele_equipe_cible',
                        'Equipe::id_modele_equipe' => 'Cible::id_modele_equipe_cible',
                        'EstDans::id_equipe' => 'Equipe::id_equipe',
                        'EstDans::id_joueur' => 'Joueur::id_joueur',
                        'Utilisateur::id' => 'Joueur::id_utilisateur',
                        'Cible::id_modele_action' => $_REQUEST['id']
                    ),
                    array('Joueur.pseudo' => 'ASC'),
                    true
                );

            // récupère la liste des joueus autorisé à envoyer des action de ce modèle (en passant par le modèle d'équipe autorisé)
            $autorises = sql_select(
                    array('Autorise', 'ModeleEquipe', 'Equipe', 'EstDans', 'Joueur', 'Utilisateur'),
                    array(
                        'ModeleEquipe.titre_equipe',
                        'Joueur.pseudo',
                        'Joueur.id_joueur',
                        'Utilisateur.email',
                        'Utilisateur.id'
                    ),
                    array(
                        'ModeleEquipe::id_modele_equipe' => 'Autorise::id_modele_equipe_autorise',
                        'Equipe::id_modele_equipe' => 'Autorise::id_modele_equipe_autorise',
                        'EstDans::id_equipe' => 'Equipe::id_equipe',
                        'EstDans::id_joueur' => 'Joueur::id_joueur',
                        'Utilisateur::id' => 'Joueur::id_utilisateur',
                        'Autorise::id_modele_action' => $_REQUEST['id']
                    ),
                    array('Joueur.pseudo' => 'ASC'),
                    true
                ); ?>
            
            <th>Votants</th><?php
            
            // récupère la liste des horaires votes associés à la cible et au votant sous la forme :
            //      a_vote_contre[cible][votant] = horaire, avec cible et votant des IDs de joueur
            $a_vote_contre = array();
            $compteur_vote = 0;
            while ($cible = $cibles->fetch()) { // ajout chaque cible en entête du tableau ?>
                <th><?=$cible['pseudo']?> (<?=$cible['pseudo']?>)</th><?php

                $a_vote_contre[$cible['id_joueur']] = array();

                // récupère la liste des joueurs ayant voté pour cette cible
                $r = sql_select('Action_', array('id_joueur_effecteur', 'horaire_envoi'), array('id_joueur_cible' => $cible['id_joueur']));
                while ($vote = $r->fetch()) {
                    $a_vote_contre[$cible['id_joueur']][$vote['id_joueur_effecteur']] = $vote['horaire_envoi'];
                    $compteur_vote++;
                }

                // détermine les indices (également ID de joueurs) des majo et mino
                foreach ($a_vote_contre as $cible => $votes) {
                    if (!isset($indices_majo) || count($a_vote_contre[$indices_majo[0]]) < count($votes)) // on a trouver un nouveau majo strict
                        $indices_majo = array($cible);
                    elseif (count($a_vote_contre[$indices_majo[0]]) == count($votes)) // on a trouver une égalité
                        $indices_majo[] = $cible;
                    
                    if (!isset($indices_mino) || count($votes) < count($a_vote_contre[$indices_mino[0]])) // on a trouver un nouveau mino strict
                        $indices_mino = array($cible);
                    elseif (count($votes) == count($a_vote_contre[$indices_mino[0]])) // on a trouver une égalité
                        $indices_majo[] = $cible;
                }
            }

            // affiche la liste des votants avec les horaires en correspondances
            while ($autorise = $autorises->fetch()) { ?>
                <tr>
                    <td><?=$autorise['pseudo']?> (<?=$autorise['pseudo']?>)</td>
                    <?php
                        foreach ($a_vote_contre as $cible => $votants) { ?>
                            <td><?=array_key_exists($autorise['id_joueur'], $votants) ? explode(" ", $votants[$autorise['id_joueur']])[1] : ""?></td><?php
                        }
                    ?>
                </tr><?php
            }

            // affiche une dernière ligne avec "Total", "Majoritaire" et "Minoritaire"
            if ($compteur_vote != 0) { ?>
                <tr>
                    <td>Total : <?=$compteur_vote?> votes</td>
                    <?php
                        foreach ($a_vote_contre as $cible => $votants) { ?>
                            <td><?=in_array($cible, $indices_majo) ? "Majoritaire" : (in_array($cible, $indices_mino) ? "Minoritaire" : "")?></td><?php
                        }
                    ?>
                </tr><?php
            }
            
            // effectuation
            if (isset($_REQUEST['action']) && $_REQUEST['action'] == "effectuer") {
                require_once "./inclus/action/effectuer.php";

                // context de l'action : /!\\ surveiller son contenu pour des raisons de sécurité (ie. pas de mdp dedant lol)
                $context = array(
                        'action' => $modele,
                        'vote' => array( // todo
                                'nb_majoritaire' => count($a_vote_contre[$indices_majo[0]]),
                                'nb_minoritaire' => count($a_vote_contre[$indices_mino[0]]),
                                'nb_total' => $compteur_vote
                            ),
                        'jdr' => array('id_jdr' => $donnees_jdr['id_jdr'])
                    );

                switch ($modele['action_fct']) {

                    case 'voteMajoritaire':
                            $message = effectuer_action($indices_majo[0], $context);
                        break;

                    case 'voteMinoritaire':
                            $message = effectuer_action($indices_mino[0], $context);
                        break;

                    case 'pouvoir':
                        break;
                }

                echo "LeMessage: $message //<br><br>\n";
            }
        }
    ?>
</table>

<?php
    // s'il existe des `Action_` pour ce `ModeleAction`, ajoute un boutton pour effectuer (ou forcer si on est avant l'horaire prévu)
    if (0 < sql_select('Action_', 'COUNT(*)', array('id_modele_action' => $_REQUEST['id']))->fetch()[0]) { ?>
        <hr>

        <div class="text-right">
            <form action="./action.php" method="get">
                <input type="hidden" name="id" value="<?=$_REQUEST['id']?>">
                <button type="submit" name="action" value="effectuer" class="btn btn-danger"><?=strtotime($modele['horaire_activ']) < time() ? "Effectuer" : "Forcer"?> l'action</button>
            </form>
        </div><?php
    }
?>

</div>
