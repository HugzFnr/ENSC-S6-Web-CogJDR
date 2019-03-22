<h1 class="text-center">JDR : <?=$modele['titre']?></h1>

<img class="img_banniere" src="<?=$modele['img_banniere']?>" alt="Oof">

<hr>
<p>Joueurs actuellement inscrits à cette partie</p>

<table class="liste_joueurs">
    <tr>
        <th>Adresse e-mail</th><th>Pseudo</th><?php if ($donnees_jdr['est_mj']) foreach ($donnees_jdr['liste_equipe'] as $v) { ?><th><?=$v['titre_equipe']?></th><?php } ?><th></th>
    </tr>

    <?php
        $r = sql_select('Joueur', array('id_joueur', 'pseudo', 'id_utilisateur'), array('id_jdr_participe' => $jdr['id_jdr']));

        for ($k = 0; $k < $jdr['nb_max_joueurs']; $k++) {
            $joueur = $r->fetch();

            if ($joueur) {
                $email = sql_select('Utilisateur', 'email', array('id' => $joueur['id_utilisateur']))->fetch()['email']; ?>
                <tr>
                    <td><?=substr($email, 0, strpos($email, "@"))?></td>
                    <td><?=$joueur['pseudo']?></td>
                    <?php
                        if ($donnees_jdr['est_mj']) {
                            foreach ($donnees_jdr['liste_equipe'] as $equipe) {
                                if (sql_select(
                                            array('EstDans'),
                                            "*",
                                            array(
                                                'id_joueur' => $joueur['id_joueur'],
                                                'id_equipe' => $equipe['id_equipe']
                                            )
                                        )->fetch()) { ?>
                                    <td>x</td><?php
                                } else { ?>
                                    <td></td><?php
                                }
                            }
                        }
                    ?>
                    <td><a href="#TODO">Envoyer un MP</a></td>
                </tr><?php
            } else { ?>
                <tr>
                    <td>-</td><td>-</td><?php if ($donnees_jdr['est_mj']) foreach ($donnees_jdr['liste_equipe'] as $v) { ?><td>-</td><?php } ?><td>-</td>
                </tr><?php
            }
        }
    ?>
</table>

<hr>
<div class="card">
    <article class="card-body">
        <?php include "./inclus/discussion/discussion.php" ?>
    </article>
</div>
