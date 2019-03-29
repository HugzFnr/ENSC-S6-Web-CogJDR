<table class="container liste_joueurs">
    <?php
        $modele = sql_select(
                'ModeleAction',
                array(
                    'titre_action',
                    'desc_action',
                    'horaire_activ',
                    'message_action',
                    'action_effet',
                    'action_fct'
                ),
                array(
                    'id_modele_action' => $_REQUEST['id']
                )
            )->fetch();
        
        if ($modele) { ?>
            <h3><?=$modele['titre_action']?></h3>
            <p><?=$modele['desc_action']?></p><?php
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
            
            // récupère la liste des cibles
            $a_vote_contre = array();
            $compteur_vote = 0;
            while ($cible = $cibles->fetch()) { ?>
                <th><?=$cible['pseudo']?> (<?=$cible['pseudo']?>)</th><?php

                $a_vote_contre[$cible['id_joueur']] = array();

                $r = sql_select('Action_', 'id_joueur_effecteur', array('id_joueur_cible' => $cible['id_joueur']));
                while ($vote = $r->fetch()) {
                    $a_vote_contre[$cible['id_joueur']][] = $vote['id_joueur_effecteur'];
                    $compteur_vote+= count($vote['id_joueur_effecteur']);
                }
                
                foreach ($a_vote_contre as $cible => $votants) {
                    if (!isset($indice_majo) || count($a_vote_contre[$indice_majo]) < count($votants))
                        $indice_majo = $cible;
                    
                    if (!isset($indice_mino) || count($votants) < count($a_vote_contre[$indice_mino]))
                        $indice_mino = $cible;
                }
            }

            // affiche la liste des votants avec les croix en correspondances
            while ($autorise = $autorises->fetch()) { ?>
                <tr>
                    <td><?=$autorise['pseudo']?> (<?=$autorise['pseudo']?>)</td>
                    <?php
                        foreach ($a_vote_contre as $cible => $votants) { ?>
                            <td><?=in_array($autorise['id_joueur'], $votants) ? "&cross;" : ""?></td><?php
                        }
                    ?>
                </tr><?php
            }

            // affiche une dernière ligne avec "Majoritaire" et "Minoritaire"
            if ($compteur_vote != 0) { ?>
                <tr>
                    <td>Total : <?=$compteur_vote?> votes</td>
                    <?php
                        foreach ($a_vote_contre as $cible => $votants) { ?>
                            <td><?=$cible == $indice_majo ? "Majoritaire" : ($cible == $indice_mino ? "Minoritaire" : "")?></td><?php
                        }
                    ?>
                </tr><?php
            }
            
            // effectuation
            if (isset($_REQUEST['action']) && $_REQUEST['action'] == "effectuer") {
                require_once "./inclus/action/effectuer.php";

                $context = array(
                        'action' => $modele,
                        'vote' => array(
                                'majoritaire' => count($a_vote_contre[$indice_majo]),
                                'minoritaire' => count($a_vote_contre[$indice_mino]),
                                'total' => $compteur_vote
                            )
                    );

                switch ($modele['action_fct']) {

                    case 'voteMajoritaire':
                            echo effectuer_action($indice_majo, $context);
                        break;
                    
                    case 'voteMinoritaire':
                            echo effectuer_action($indice_mino, $context);
                        break;
                
                    case 'pouvoir':
                        break;
                }
            }
        }
    ?>
</table>
