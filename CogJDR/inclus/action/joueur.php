<form action="./action.php" method="post">
    <?php
        if (sql_select(
                    array('ModeleAction', 'Action_'),
                    'COUNT(*)',
                    array('ModeleAction::id_modele_action' => 'Action_::id_modele_action', 'Action_::id_joueur_effecteur' => $donnees_jdr['id_dans'])
                )->fetch()[0]) {
            include_once "./inclus/page_fin.php";
            exit;
        }

        $modele = sql_select(
                array(
                    'Equipe', 'ModeleEquipe', 'EstDans',
                    'ModeleAction', 'Autorise'
                ),
                array(
                    'ModeleAction.titre_action',
                    'ModeleAction.desc_action',
                    'ModeleAction.horaire_activ'
                ),
                array(
                    'Equipe::id_equipe' => 'EstDans::id_equipe',
                    'Equipe::id_modele_equipe' => 'ModeleEquipe::id_modele_equipe',
                    'ModeleEquipe::id_modele_equipe' => 'Autorise::id_modele_equipe_autorise',
                    'Autorise::id_modele_action' => 'ModeleAction::id_modele_action',
                    'ModeleAction::id_modele_action' => $_REQUEST['id'],
                    'EstDans::id_joueur' => $donnees_jdr['id_dans']
                ),
                null,
                true
            )->fetch();

        if ($modele && time() < strtotime($modele['horaire_activ'])) { ?>
            <h1 class="text-center"><?=$modele['titre_action']?></h1>
            <p class="desc_action"><?=$modele['desc_action']?></p><?php

            if (empty($_REQUEST['action'])) { ?>
                <ol>
                    <?php
                        $cibles = sql_select(
                                array(
                                    'Utilisateur', 'Joueur',
                                    'Equipe', 'ModeleEquipe', 'EstDans',
                                    'ModeleAction', 'Cible'
                                ),
                                array('Joueur.id_joueur', 'Joueur.pseudo', 'Utilisateur.email'),
                                array(
                                    'Joueur::id_utilisateur' => 'Utilisateur::id',
                                    'EstDans::id_joueur' => 'Joueur::id_joueur',
                                    'Equipe::id_equipe' => 'EstDans::id_equipe',
                                    'Equipe::id_modele_equipe' => 'ModeleEquipe::id_modele_equipe',
                                    'ModeleEquipe::id_modele_equipe' => 'Cible::id_modele_equipe_cible',
                                    'Cible::id_modele_action' => 'ModeleAction::id_modele_action',
                                    'ModeleAction::id_modele_action' => $_REQUEST['id']
                                ),
                                array('Joueur.pseudo' => 'ASC'),
                                true
                            );

                        $compteur = 0;
                        while ($joueur = $cibles->fetch()) { ?>
                            <li><input type="radio" name="id_joueur_choix" id="choix<?=$compteur++?>" value="<?=$joueur['id_joueur']?>"><?=$joueur['pseudo']?> (<?=$joueur['email']?>)</li><?php
                        }
                    ?>
                </ol>
                <input type="hidden" name="id" value="<?=$_REQUEST['id']?>">
                <button class="btn btn-primary" type="submit" name="action" value="vote">Envoyer</button><?php
            } elseif ($_REQUEST['action'] == "vote") {
                sql_insert('Action_', array(
                    'id_action' => null,
                    'id_modele_action' => $_REQUEST['id'],
                    'id_jdr' => $donnees_jdr['id_jdr'],
                    'id_joueur_cible' => $_REQUEST['id_joueur_choix'],
                    'id_joueur_effecteur' => $donnees_jdr['id_dans']
                )); ?>
                <p>Vous avez voté pour : <?=sql_select('Joueur', 'pseudo', array('id_joueur' => $_REQUEST['id_joueur_choix']))->fetch()['pseudo']?></p>
                <a href="./jdr.php?id=<?=$donnees_jdr['id_jdr']?>">Retourner au JDR</a><?php
            }
        } else { ?>
            <h1>Non, tu n'as pas le droit !</h1>
            <p>(#YouHaveNoPawerHere)</p><?php
        }
    ?>
</form>
