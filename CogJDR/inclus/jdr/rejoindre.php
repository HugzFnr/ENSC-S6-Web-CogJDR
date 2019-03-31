<h1 class="text-center">JDR : <?=$modele['titre']?></h1>

<img class="img_banniere" src="<?=$modele['img_banniere']?>" alt="Oof">

<p class="desc_jdr"><?=$modele['desc_jdr']?></p>

<a href="">Télécharger les règles</a>

<hr>
<p>Joueurs actuellement inscrits à cette partie</p>

<table class="liste_joueurs container">
    <th>Adresse e-mail</th><th>Pseudo</th><?php if (@$donnees_jdr['est_mj']) { ?><th></th><?php } ?>

    <?php
        // récupère touts les joueurs déjà inscrit
        $r = sql_select('Joueur', array('pseudo', 'id_utilisateur', 'id_joueur'), array('id_jdr_participe' => $jdr['id_jdr']));

        for ($k = 0; $k < $jdr['nb_max_joueurs']; $k++) {
            $joueur = $r->fetch();

            if (!empty($joueur)) { ?>
                <tr>
                    <td><?=sql_select('Utilisateur', 'email', array('id' => $joueur['id_utilisateur']))->fetch()['email']?></td>
                    <td><?=$joueur['pseudo']?></td>
                    <?php
                        if (@$donnees_jdr['est_mj']) { ?>
                            <td><a href="./jdr.php?id=<?=$jdr['id_jdr']?>&action=virer&joueur=<?=$joueur['id_joueur']?>&redirection_succes=<?=htmlentities("./jdr.php?id=".$jdr['id_jdr'])?>">Virer ce joueur</a></td><?php
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

<hr>
<?php
    if (@$donnees_jdr['est_mj']) { // s'il est MJ il peut démarrer la partie ?>
        <form class="w-100" action="./jdr.php">
            <input type="hidden" name="id" value="<?=$jdr['id_jdr']?>">
            <input type="hidden" name="redirection_succes" value="./jdr.php?id=<?=$jdr['id_jdr']?>">

            <button class="btn btn-primary btn-block w-auto" type="submit" name="action" value="etat_demarrer">Démarrer la partie</button>
        </form><?php
    } elseif ($etat_partie == "lancement"  && isset($_SESSION['id'])) { // si la partie n'a pas commencer
        if (!$a_rejoint) { // s'il est connecté, ajout d'un form pour renter un pseudo ?>
            <form class="w-100" action="./jdr.php">
                <input type="hidden" name="id" value="<?=$jdr['id_jdr']?>">
                <input type="hidden" name="redirection_succes" value="./jdr.php?id=<?=$jdr['id_jdr']?>">
                
                <table class="w-100">
                    <tr>
                        <td><input class="form-control w-auto float-right" type="text" name="pseudo" id="rejoindre_pseudo" placeholder="Choisisez un Pseudal"></td>
                        <td><button class="btn btn-primary btn-block w-auto float-left" type="submit" name="action" value="rejoindre">Rejoindre</button></td>
                    </tr>
                </table>
            </form><?php
        } else { // sinon il peut se retirer tant que la partie n'a pas commencée ?>
            <form class="w-100" action="./jdr.php">
                <input type="hidden" name="id" value="<?=$jdr['id_jdr']?>">
                <input type="hidden" name="joueur" value="<?=$donnees_jdr['id_dans']?>">
                <input type="hidden" name="redirection_succes" value="./jdr.php?id=<?=$jdr['id_jdr']?>">

                <button class="btn btn-primary btn-block w-auto" type="submit" name="action" value="virer">Se Retirer</button>
            </form><?php
        }
    } elseif ($etat_partie == "deroulement") { // si la partie est en cours, on ne peut plus rejoindre ?>
        <h2>Les inscriptions sont closes !</h2><?php
    } elseif ($etat_partie == "fin") { // de même si la partie est finie ?>
        <h2>Cette partie est finie !</h2><?php
    }
?>
