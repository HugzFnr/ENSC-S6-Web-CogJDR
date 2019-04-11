<div class="container">
    <form action="./action.php" method="post">
        <?php
            // si le joueur à déjà crée une `Action_` sur ce `ModeleAction`
            if ($id_action = sql_select(
                        array('ModeleAction', 'Action_'),
                        'Action_.id_action',
                        array('ModeleAction::id_modele_action' => 'Action_::id_modele_action', 'Action_::id_joueur_effecteur' => $donnees_jdr['id_dans'])
                    )->fetch()['id_action']) {
                if (empty($_REQUEST['action']) || $_REQUEST['action'] != "retirer") { // abandone ?>
                    <h1>Tu a déjà voté !</h1>
                    <a href="./action.php?action=retirer&id=<?=$_REQUEST['id']?>">oui, mais je veut changer mon vote x/</a><?php
                    include_once "./inclus/page_fin.php";
                    exit;
                } elseif ($_REQUEST['action'] == "retirer") { // change son vote : commence par le supprimer
                    sql_delete(
                            'Action_',
                            array('id_action' => $id_action)
                        );
                }
            }

            // récupère le modèle visé
            $modele = sql_select(
                    'ModeleAction',
                    array( 'titre_action', 'desc_action', 'horaire_activ'),
                    array('id_modele_action' => $_REQUEST['id'])
                )->fetch();

            // si l'action n'a pas encore expirer pour aujourd'hui
            if ($modele && time() < strtotime($modele['horaire_activ'])) { ?>
                <h1 class="text-center"><?=$modele['titre_action']?></h1>
                <p class="desc_action"><?=$modele['desc_action']?></p><?php

                if (empty($_REQUEST['action'])) { // cas par défaut : affiche la liste des joueurs ciblés dans un form ?>
                    <ol>
                        <?php
                            // récupère la liste des joueus ciblés par les action de ce modèle (en passant par le modèle d'équipe ciblé)
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

                            // affiche toutes les entrées en une liste d'input type=radio (ie. choix unique)
                            $compteur = 0;
                            while ($joueur = $cibles->fetch()) { ?>
                                <li><input type="radio" name="id_joueur_choix" id="choix<?=$compteur++?>" value="<?=$joueur['id_joueur']?>"><?=$joueur['pseudo']?> (<?=$joueur['email']?>)</li><?php
                            }
                        ?>
                    </ol>

                    <input type="hidden" name="id" value="<?=$_REQUEST['id']?>">
                    <button class="btn btn-primary" type="submit" name="action" value="voter">Envoyer</button><?php
                } elseif ($_REQUEST['action'] == "voter") { // cas où le joueur à fait son choix et à cliquer sur "Envoyer" (ligne d'au dessus)
                    // créer une nouvelle `Action_`
                    sql_insert('Action_', array(
                            'id_action' => null,
                            'id_modele_action' => $_REQUEST['id'],
                            'id_jdr' => $donnees_jdr['id_jdr'],
                            'id_joueur_cible' => $_REQUEST['id_joueur_choix'],
                            'id_joueur_effecteur' => $donnees_jdr['id_dans'],
                            'horaire_envoi' => null
                        )); ?>
                    <p>Vous avez voter pour : <?=sql_select('Joueur', 'pseudo', array('id_joueur' => $_REQUEST['id_joueur_choix']))->fetch()['pseudo']?></p>
                    <a href="./jdr.php?id=<?=$donnees_jdr['id_jdr']?>">Retourner au JDR</a><?php
                }
            } else { // le joueur n'était pas sensé être là... ?>
                <h1>Non, tu n'as pas le droit !</h1>
                <p>(#YouHaveNoPawerHere)</p><?php
            }
        ?>
    </form>
</div>
