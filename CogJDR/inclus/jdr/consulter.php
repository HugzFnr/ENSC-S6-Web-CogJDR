<h1 class="text-center">JDR : <?=$modele['titre']?></h1>

<img class="img_banniere" src="<?=$modele['img_banniere']?>" alt="Oof">

<hr>
<p>Joueurs actuellement inscrits à cette partie</p>

<table class="container liste_joueurs">
    <tr>
        <th>Adresse e-mail</th><th>Pseudo</th><?php if ($donnees_jdr['est_mj']) foreach ($donnees_jdr['liste_equipe'] as $v) if ($v['titre_equipe'] != "MP") { ?><th><?=$v['titre_equipe']?></th><?php } ?><th></th>
    </tr>

    <?php
        /**
         * TTT  OO    DD   OO    !!
         *  T  O  O   D D O  O   !!
         *  T   OO    DD   OO    !!
         */
        // TODO: optimiser cette partie en réduisant le nb d'appels à la base de données (j'en suis sur que c'est possible, lol)
        $r = sql_select('Joueur', array('id_joueur', 'pseudo', 'id_utilisateur'), array('id_jdr_participe' => $jdr['id_jdr']));

        for ($k = 0; $k < $jdr['nb_max_joueurs']; $k++) {
            $joueur = $r->fetch();

            if ($joueur) {
                $email = sql_select('Utilisateur', 'email', array('id' => $joueur['id_utilisateur']))->fetch()['email']; ?>
                <tr>
                    <td><?php
                        $i = strpos($email, "@");
                        echo 0 < $i ? substr($email, 0, $i) : $email;
                    ?></td>
                    <td><?=$joueur['pseudo']?></td>
                    <?php
                        if ($donnees_jdr['est_mj']) {
                            foreach ($donnees_jdr['liste_equipe'] as $equipe) if ($equipe['titre_equipe'] != "MP") {
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
                    <td><?php
                        if ($joueur['id_utilisateur'] != $_SESSION['id']) {
                            $tmp = sql_select(
                                    array('Equipe', 'EstDans'),
                                    "COUNT(*)",
                                    array(
                                        'Equipe::id_modele_equipe' => 0,
                                        'EstDans::id_equipe' => 'Equipe::id_equipe',
                                        'EstDans::id_joueur' => array($joueur['id_joueur'], $donnees_jdr['est_mj'] ? null : $donnees_jdr['id_dans'])
                                    )
                                )->fetch();
                            if ($tmp[0] != ($donnees_jdr['est_mj'] ? 1 : 2)) { ?>
                                <a href="#" onclick="creerMP(event, <?=$joueur['id_joueur']?>, <?=$donnees_jdr['est_mj'] ? "null" : $donnees_jdr['id_dans']?>)">Envoyer un MP</a><?php
                            }
                        }
                    ?></td>
                </tr><?php
            } else { ?>
                <tr>
                    <td>-</td><td>-</td><?php if ($donnees_jdr['est_mj']) foreach ($donnees_jdr['liste_equipe'] as $v) if ($v['titre_equipe'] != "MP") { ?><td>-</td><?php } ?><td>-</td>
                </tr><?php
            }
        }
    ?>
</table>

<script>
    creerMP = function(event, idA, idB) {
        event.preventDefault();
        $.post("./equipe.php", {
            action: "creer",
            id_modele_equipe: 0,
            liste_id_joueur: [idA, idB],
            redirection_succes: "./jdr.php?id=<?=$donnees_jdr['id_jdr']?>"
        }).done(function(data) {
            location.reload();
            /*console.log(data);
            alert("coucou");*/
        });
    }
</script>

<?php include "./inclus/discussion/discussion.php" ?>
