<table class="liste_joueurs">
    <?php
        $modele = sql_select(
                'ModeleAction',
                array(
                    'titre_action',
                    'desc_action',
                    'horaire_activ'
                ),
                array(
                    'id_modele_action' => $_REQUEST['id']
                )
            )->fetch();
        
        if ($modele) {
            $cibles = sql_select(
                    array('Cible', 'ModeleEquipe', 'Equipe', 'EstDans', 'Joueur', 'Utilisateur'),
                    array(
                        'ModeleEquipe.titre_equipe',
                        'Joueur.pseudo',
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
                );
            
            $compteur = 0;
            while ($cible = $cibles->fetch()) { ?>
                <th></th><th><?=$cible['pseudo']?> (<?=$cible['pseudo']?>)</th><?php
                // ici selectionner les `Action_` contre ce joueur et les associe à des autorise
            }

            while ($autorise = $autorises->fetch()) { ?>
                <tr>
                    <td><?=$autorise['pseudo']?> (<?=$autorise['pseudo']?>)</td>
                </tr><?php
            }
        }
    ?>
</table>
