<h1 class="text-center">JDR : <?=$modele['titre']?></h1>

<img class="img_banniere" src="<?=$modele['img_banniere']?>" alt="Oof">

<hr>
<p>Joueurs actuellement inscrits à cette partie</p>

<!-- table des joueurs -->
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
<!-- FIN table des joueurs -->

<hr>

<!-- liste des actions -->
<h3>Liste des actions</h3>
<ol class="liste-actions">
    <?php
        $action_finies = array();

        $r = sql_select(
                array('ModeleAction', 'JDR', 'Autorise', 'Equipe', 'EstDans'),
                "*",
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
            if (strtotime($modele_action['horaire_activ']) < time()) {
                $action_finies[] = $modele_action;
                continue;
            }
            $a_repondu = sql_select(
                                array('Action_'),
                                'COUNT(*)',
                                array('Action_::id_modele_action' => $modele_action['id_modele_action'], 'Action_::id_joueur_effecteur' => $donnees_jdr['id_dans'])
                            )->fetch()[0]; ?>
            <li>
            <h4><span class="badge badge-<?=$a_repondu ? "secondary" : "primary" ?>"><?=$a_repondu ? "&check;" : "&nbsp;!&nbsp;" ?></span> <?php if (!$a_repondu) { ?><a href="./action.php?id=<?=$modele_action['id_modele_action']?>"><?php } ?><?=$modele_action['titre_action']?><?php if (!$a_repondu) { ?></a><?php } ?></h4>
                <table><tr>
                    <td class="w-100"><p><?=$modele_action['message_action']?></p></td>
                    <td><p class="text-right">horaire&nbsp;limite&nbsp;:&nbsp;<?=$modele_action['horaire_activ']?></p></td>
                </tr></table>
            </li><?php
            $compteur++;
        }
    ?>
</ol>

<h4>Action finies</h4>
<ol class="liste-actions">
    <?php
        foreach ($action_finies as $modele_action) { ?>
            <li>
                <h4><?php if ($donnees_jdr['est_mj']) { ?><a href="./action.php?id=<?=$modele_action['id_modele_action']?>"><?php } ?><?=$modele_action['titre_action']?><?php if ($donnees_jdr['est_mj']) { ?></a><?php } ?></h4>
                <table><tr>
                    <td class="w-100"><p><?=$modele_action['message_action']?></p></td>
                    <td><p class="text-right">horaire&nbsp;limite&nbsp;:&nbsp;<?=$modele_action['horaire_activ']?></p></td>
                </tr></table>
            </li><?php
            $compteur++;
        }
    ?>
</ol>
<!-- FIN liste des actions -->

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
