<h1 class="text-center">JDR : <?=$modele['titre']?></h1>

<div class="container">

    <img class="img_banniere" src="<?=$modele['img_banniere']?>" alt="Oof">

    <p class="desc_jdr"><?=$modele['desc_jdr']?></p>

    <div class="col-sm-12 text-center">
        <a target="blank" href="<?=sql_select(array('JDR','ModeleJDR'),'fichier_regles',array('JDR::id_modele_jdr'=> 'ModeleJDR::id_modele_jdr','JDR::id_jdr'=>$jdr['id_jdr']))->fetch()['fichier_regles']?>"><b>Télécharger les règles</b></a>

        <hr>
        <p><b>Joueurs actuellement inscrits à cette partie</b> &mdash; Code d'invitation: <?=$jdr['code_invite']?> (<a href="./jdr.php?code=<?=$jdr['code_invite']?>">lien directe</a>)</p>

        <table class="liste_joueurs container">
            <th>Adresse e-mail</th><th>Pseudo</th><?php if (@$donnees_jdr['est_mj']) { ?><th></th><?php } ?>

            <?php
                // récupère touts les joueurs déjà inscrit
                $r = sql_select('Joueur', array('pseudo', 'id_utilisateur', 'id_joueur'), array('id_jdr_participe' => $jdr['id_jdr']));

                $nb_joueur = 0;

                for ($k = 0; $k < $jdr['nb_max_joueurs']; $k++) {
                    $joueur = $r->fetch();

                    if (!empty($joueur)) {
                        $nb_joueur++; ?>
                        <tr>
                            <td><?=sql_select('Utilisateur', 'email', array('id' => $joueur['id_utilisateur']))->fetch()['email']?></td>
                            <td><?=$joueur['pseudo']?></td>
                            <?php
                                if (@$donnees_jdr['est_mj']) { ?>
                                    <td><a href="./jdr.php?id=<?=$jdr['id_jdr']?>&action=virer&joueur=<?=$joueur['id_joueur']?>">Virer ce joueur</a></td><?php
                                }
                            ?>
                        </tr><?php
                    } else { ?>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <?php
                                if (@$donnees_jdr['est_mj']) { ?>
                                    <td>-</td><?php
                                }
                            ?>
                        </tr><?php
                    }
                }
            ?>
        </table>
        
        <div class="col-sm-4 offset-sm-5">
            <hr>
            <?php
                if (@$donnees_jdr['est_mj']) { // s'il est MJ il peut démarrer la partie ?>
                    <form action="./jdr.php">
                        <input type="hidden" name="id" value="<?=$jdr['id_jdr']?>">
                        <input type="hidden" name="redirection_succes" value="./jdr.php?id=<?=$jdr['id_jdr']?>">

                        <button class="btn btn-primary btn-block w-auto" type="submit" name="action" value="etat_demarrer">Démarrer la partie</button>
                    </form><?php
                } elseif (!$a_rejoint && isset($_SESSION['id']) && $etat_partie == "lancement") { // s'il est connecté et que la partie n'a pas commencer
                    if ($nb_joueur < sql_select('JDR', 'nb_max_joueurs', array('id_jdr' => $jdr['id_jdr']))->fetch()['nb_max_joueurs']) { // si il rest des places, ajout d'un form pour renter un pseudo pour rejoindre ?>
                        <form action="./jdr.php">
                            <input type="hidden" name="id" value="<?=$jdr['id_jdr']?>">

                                    <label for="rejoindre_pseudo"> Pseudo pour la partie : </label>
                                    <input class="form-control" type="text" name="pseudo" id="rejoindre_pseudo" placeholder="Choisisez un pseudonyme">
                                    
                                    <button class="btn btn-primary btn-block" type="submit" name="action" value="rejoindre">Rejoindre</button>
                                
                        </form><?php
                    } else { // il  n'y a plus de place :'( ?>
                        <h2>Il n'y a plus de place !</h2><?php
                    }
                } elseif ($etat_partie == "deroulement") { // si la partie est en cours, on ne peut plus rejoindre ?>
                    <h2>Les inscriptions sont closes !</h2><?php
                } elseif ($etat_partie == "fin") { // de même si la partie est finie ?>
                    <h2>Cette partie est finie !</h2><?php
                }
                else if ($a_rejoint) {
                    echo("<h2> En attente du top départ du MJ ! </h2>");
                }
            ?>
        </div>
    </div>
</div>
