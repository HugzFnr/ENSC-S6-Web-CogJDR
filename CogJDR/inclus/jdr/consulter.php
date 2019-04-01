<h1 class="text-center">JDR : <?=$modele['titre']?></h1>

<img class="img_banniere" src="<?=$modele['img_banniere']?>" alt="Oof">

<div class="col-sm-12 text-center">
    <a target="blank" href="<?=sql_select(array('JDR','ModeleJDR'),'fichier_regles',array('JDR::id_modele_jdr'=> 'ModeleJDR::id_modele_jdr','JDR::id_jdr'=>$jdr['id_jdr']))->fetch()['fichier_regles'] ?>"><b>Télécharger les règles</b></a>

    <hr>
    <p><b>Joueurs actuellement inscrits à cette partie</b></p>

    <!-- table des joueurs -->
    <table class="container liste_joueurs">
        <th>Adresse e-mail</th><th>Pseudo</th><?php if ($donnees_jdr['est_mj'] || $etat_partie == "fin") foreach ($donnees_jdr['liste_equipe'] as $v) if ($v['titre_equipe'] != "MP") { ?><th><?=$v['titre_equipe']?></th><?php } ?><?php if ($etat_partie != "fin") { ?><th></th><?php } ?>

        <?php
            // TODO: optimiser cette partie en réduisant le nb d'appels à la base de données (possible ?) notament dans le foreach

            // récupère la liste des joueurs participant au JDR
            $r = sql_select('Joueur', array('id_joueur', 'pseudo', 'id_utilisateur'), array('id_jdr_participe' => $jdr['id_jdr']));

            // assure que le tableau contient exactement `nb_max_joueurs` entrées
            for ($k = 0; $k < $jdr['nb_max_joueurs']; $k++) {
                $joueur = $r->fetch();

                if ($joueur) { // si on a pas encore atteint le dernier joueurs inscrit
                    $email = sql_select('Utilisateur', 'email', array('id' => $joueur['id_utilisateur']))->fetch()['email']; ?>
                    <tr>
                        <td><?php
                            // n'affiche que la première partie de l'adresse e-mail (jusqu'avant le '@')
                            $i = strpos($email, "@");
                            echo 0 < $i ? substr($email, 0, $i) : $email;
                        ?></td>
                        <td><?=$joueur['pseudo']?></td>
                        <?php
                            // si l'utilisateur est MJ dans ce JDR, ou que la partie est finie
                            if ($donnees_jdr['est_mj'] || $etat_partie == "fin") { // ajout les colonnes indiquant les équipes de chaque joueur
                                foreach ($donnees_jdr['liste_equipe'] as $equipe) if ($equipe['titre_equipe'] != "MP") {
                                    if (sql_select(
                                                array('Equipe', 'ModeleEquipe'),
                                                'ModeleEquipe.titre_equipe',
                                                array(
                                                        'ModeleEquipe::id_modele_equipe' => 'Equipe::id_modele_equipe',
                                                        'Equipe::id_equipe' => $equipe['id_equipe']
                                                    )
                                            )->fetch()['titre_equipe'] == "Tous") { // si c'est l'équipe "Tous", on de l'affiche pas... ?>
                                        <td></td><?php
                                    } elseif (sql_select(
                                                'EstDans',
                                                "*",
                                                array(
                                                        'id_joueur' => $joueur['id_joueur'],
                                                        'id_equipe' => $equipe['id_equipe']
                                                    )
                                            )->fetch()) { ?>
                                        <td><a title="Retirer de" href="./equipe.php?action=retirer&id=<?=$equipe['id_equipe']?>&liste_id_joueur[]=<?=$joueur['id_joueur']?>&redirection_succes=./jdr.php?id=<?=$donnees_jdr['id_jdr']?>">&cross;</a></td><?php
                                    } else { ?>
                                        <td><a title="Ajouter à" href="./equipe.php?action=ajouter&id=<?=$equipe['id_equipe']?>&liste_id_joueur[]=<?=$joueur['id_joueur']?>&redirection_succes=./jdr.php?id=<?=$donnees_jdr['id_jdr']?>">&plus;</a></td><?php
                                    }
                                }
                            }

                            if ($etat_partie != "fin") { // si la partie n'est pas finie, ajoute les cases de MP ?>
                                <td><?php
                                    // ajout des liens de MP..
                                    if ($joueur['id_utilisateur'] != $_SESSION['id']) { // .. s'il s'agit du joueur d'un autre utilisateur..
                                        $tmp = sql_select(
                                                array('Equipe', 'EstDans'),
                                                "COUNT(*)",
                                                array(
                                                    'Equipe::id_modele_equipe' => 0,
                                                    'EstDans::id_equipe' => 'Equipe::id_equipe',
                                                    'EstDans::id_joueur' => array($joueur['id_joueur'], $donnees_jdr['est_mj'] ? null : $donnees_jdr['id_dans'])
                                                )
                                            )->fetch();
                                        if ($tmp[0] != ($donnees_jdr['est_mj'] ? 1 : 2)) { // .. s'il n'existe pas déjà une discussion MJ entre ces deux joueurs ?>
                                            <a href="#" onclick="creerMP(event, <?=$joueur['id_joueur']?>, <?=$donnees_jdr['est_mj'] ? "null" : $donnees_jdr['id_dans']?>)">Envoyer un MP</a><?php
                                        }
                                    }
                                ?></td><?php
                            }
                        ?>
                    </tr><?php
                } else { // reste des emplacements vide (cas où le JDR n'est pas plein : `$joueur` vaut `false` après le `fetch`) ?>
                    <tr>
                <td>-</td><td>-</td><?php if ($donnees_jdr['est_mj'] || $etat_partie == "fin") foreach ($donnees_jdr['liste_equipe'] as $v) if ($v['titre_equipe'] != "MP") { ?><td>-</td><?php } ?><?php if ($etat_partie != "fin") { ?><td>-</td><?php } ?>
                    </tr><?php
                }
            }
        ?>
    </table>
    <!-- FIN table des joueurs -->
</div>

<div class="col-sm-12">
    <?php
        if ($etat_partie != "fin") { ?>
            <hr>

            <!-- liste des actions -->
            <h2>Liste des actions</h2>
            <ol class="liste-actions">
                <?php
                    $compteur_action_ol1 = 0; // compte le nombre d'actions affichées dans la première liste (les actions non expirées)
                    $action_finies = array();

                    if ($donnees_jdr['est_mj']) // s'il est MJ, on affichera toutes les actions
                        $r = sql_select(
                                array('ModeleAction', 'JDR'),
                                array(
                                    'id_modele_action',
                                    'titre_action',
                                    'desc_action',
                                    'horaire_activ',
                                    'action_fct'
                                ),
                                array(
                                    'ModeleAction::id_modele_jdr' => 'JDR::id_modele_jdr',
                                    'JDR::id_jdr' => $donnees_jdr['id_jdr']
                                )
                            );
                    else // sinon (joueur), on ne veut que les action auquelles il est autorisé
                        $r = sql_select(
                                array('ModeleAction', 'JDR', 'Autorise', 'Equipe', 'EstDans'),
                                array(
                                    'ModeleAction.id_modele_action',
                                    'ModeleAction.titre_action',
                                    'ModeleAction.desc_action',
                                    'ModeleAction.horaire_activ'
                                ),
                                array(
                                    'ModeleAction::id_modele_jdr' => 'JDR::id_modele_jdr',
                                    'JDR::id_jdr' => $donnees_jdr['id_jdr'],
                                    'ModeleAction::id_modele_action' => 'Autorise::id_modele_action',
                                    'Autorise::id_modele_equipe_autorise' =>  'Equipe::id_modele_equipe',
                                    'Equipe::id_equipe' => 'EstDans::id_equipe',
                                    'EstDans::id_joueur' => $donnees_jdr['id_dans']
                                ),
                                array('ModeleAction.horaire_activ' => 'ASC')
                            );
                    
                    while ($modele_action = $r->fetch()) {
                        if (strtotime($modele_action['horaire_activ']) < time()) { // les actions finies sont affichées après, dans une liste séparée
                            $action_finies[] = $modele_action;
                            continue;
                        }

                        $compteur_action_ol1++;

                        if ($donnees_jdr['est_mj']) // s'il est MJ on compte le nombre de réponse ce form a eu
                            $a_repondu = sql_select('Action_', 'COUNT(*)', array('id_modele_action' => $modele_action['id_modele_action'], 'id_jdr' => $donnees_jdr['id_jdr']))->fetch()[0];
                        else // sinon on veut savoir si ce joueur à répondu
                            $a_repondu = !$donnees_jdr['est_mj'] && sql_select(
                                    array('Action_'),
                                    'COUNT(*)',
                                    array('Action_::id_modele_action' => $modele_action['id_modele_action'], 'Action_::id_joueur_effecteur' => $donnees_jdr['id_dans'])
                                )->fetch()[0]; ?>
                        <li>
                        <h4><?php if ($donnees_jdr['est_mj']) { ?><span class="badge badge-primary"><?=$a_repondu?></span> <?php } else { ?><span class="badge badge-<?=$a_repondu ? "secondary" : "primary"?>"><?=$a_repondu ? "&check;" : "&nbsp;!&nbsp;"?></span> <?php } if (!$a_repondu || $donnees_jdr['est_mj']) { ?><a href="./action.php?id=<?=$modele_action['id_modele_action']?>"><?php } ?><?=$modele_action['titre_action']?><?php if (!$a_repondu || $donnees_jdr['est_mj']) { ?></a><?php } ?></h4>
                            <table><tr>
                                <td class="w-100"><p><?=$modele_action['desc_action']?></p></td>
                                <td><p class="text-right">horaire&nbsp;limite&nbsp;:&nbsp;<?=$modele_action['horaire_activ']?></p></td>
                            </tr></table>
                        </li><?php
                    }
                ?>
            </ol>

            <?php
                if ($compteur_action_ol1 == 0) { // si la première liste est vide ?>
                    <h4>Pas d'actions restantes pour aujourd'hui, reviens demain !</h4><?php
                }

                // deuxième liste : les action expirées
                if (!empty($action_finies)) { ?>
                    <h2>Actions finies</h2>
                    <ol class="liste-actions">
                        <?php
                            foreach ($action_finies as $modele_action) { ?>
                                <li>
                                    <?php
                                        if ($donnees_jdr['est_mj']) {
                                            $a_repondu = sql_select('Action_', 'COUNT(*)', array('Action_::id_modele_action' => $modele_action['id_modele_action']))->fetch()[0];
                                            $a_action = 0 < sql_select('Action_', 'COUNT(*)', array('id_modele_action' => $modele_action['id_modele_action']))->fetch()[0]; ?>
                                            <h4>
                                                <form action="./action.php" method="get">
                                                    <span class="badge badge-primary"><?=$a_repondu?></span> <a href="./action.php?id=<?=$modele_action['id_modele_action']?>"><?=$modele_action['titre_action']?></a>
                                                    <input type="hidden" name="id" value="<?=$modele_action['id']?>"><?php
                                                    if ($a_action) { ?>
                                                        <button type="submit" name="action" value="effectuer" class="btn btn-secondary float-right">Effectuer l'action</button><?php
                                                    } else { ?>
                                                        <span class="btn btn-secondary float-right">Pas d'action&hellip;</span><?php
                                                    } ?>
                                                </form>
                                            </h4><?php
                                        } else { ?>
                                            <h4><?=$modele_action['titre_action']?></h4><?php
                                        }
                                    ?>

                                    <table><tr>
                                        <td class="w-100"><p><?=$modele_action['desc_action']?></p></td>
                                        <td><p class="text-right">horaire&nbsp;limite&nbsp;:&nbsp;<?=$modele_action['horaire_activ']?></p></td>
                                    </tr></table>
                                </li><?php
                            }
                        ?>
                    </ol><?php
                } else { // dans le cas d'un joueur lambda, on regarde s'il a un rôle à jouer
                    $r = sql_select(
                            array('Joueur', 'JDR', 'ModeleAction', 'Permet', 'Role_', 'EstUn'),
                            array('Role_.id_role', 'Role_.img_role', 'Role_.nom_role', 'Role_.desc_role', 'Permet.id_modele_action'),
                            array(
                                    'Joueur::id_joueur' => 'EstUn::id_joueur',
                                    'EstUn::id_role' => 'Role_::id_role',
                                    'Role_::id_modele_jdr' => 'JDR::id_modele_jdr',
                                    'JDR::id_jdr' => $donnees_jdr['id_jdr'],
                                    'Permet::id_role' => 'Role_::id_role',
                                    'Joueur::id_joueur' => $donnees_jdr['id_dans']
                                )
                        );

                    if (0 < $r->rowCount()) { ?>
                        <h2>Vos actions disponibles</h2>
                        <ol class="liste-actions">
                            <?php
                                while ($role = $r->fetch()) { ?>
                                    <li>
                                        <h4><?=$role['nom_role']?></h4>
                                        <img src="images/jdr/<?=$role['img_role']?>" alt="Oof">
                                        <p><?=$role['desc_role']?></p>
                                        <a href="./action?id=<?=$role['id_modele_action']?>">aller faire l'action lol</a>
                                    </li><?php
                                }
                            ?>
                        </ol><?php
                    }
                }
            ?>
            <!-- FIN liste des actions --><?php
        }
    ?>

    <script>
        // fonction appelée pour créer un MP
        creerMP = function(event, idA, idB) {
                event.preventDefault();
                $.post("./equipe.php", {
                        action: "creer",
                        id_modele_equipe: 0,
                        liste_id_joueur: [idA, idB],
                        redirection_succes: "./jdr.php?id=<?=$donnees_jdr['id_jdr']?>"
                    }).done(function(data) {
                            // recharge la page pour afficher la nouvelle discussion
                            location.reload();
                            /*console.log(data);
                            alert("coucou");*/
                        });
            }
    </script>
</div>

<div class="col-sm-6 offset-sm-5">
    <?php
        if (@$donnees_jdr['est_mj'] && $etat_partie != "fin") { // s'il est MJ il peut finir la partie ?>
            <hr>
            <form action="./jdr.php">
                <input type="hidden" name="id" value="<?=$jdr['id_jdr']?>">
                <input type="hidden" name="redirection_succes" value="./jdr.php?id=<?=$jdr['id_jdr']?>">

                <button class="btn btn-primary btn-block w-auto" type="submit" name="action" value="etat_finir">Cloturer la partie</button>
            </form><?php
        }
    ?>
</div>

<script>
    // fonction appelée pour créer un MP
    creerMP = function(event, idA, idB) {
            event.preventDefault();
            $.post("./equipe.php", {
                    action: "creer",
                    id_modele_equipe: 0,
                    liste_id_joueur: [idA, idB],
                    redirection_succes: "./jdr.php?id=<?=$donnees_jdr['id_jdr']?>"
                }).done(function(data) {
                        // recharge la page pour afficher la nouvelle discussion
                        location.reload();
                        /*console.log(data);
                        alert("coucou");*/
                    });
        }
</script>

<?php
    if ($etat_partie != "lancement")
        include "./inclus/discussion/discussion.php"
?>
