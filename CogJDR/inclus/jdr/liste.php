<!-- liste joueur -->
<ul>
    <?php
        if (!isset($id_utilisateur)) // si `id_utilisateur` n'est pas précisé, c'est qu'on veut afficher toutes les parties
            $r = sql_select(array('JDR', 'ModeleJDR'), "*", array('JDR::id_modele_jdr' => 'ModeleJDR::id_modele_jdr'), array('id_jdr' => 'DESC'), true);
        else // sinon on ne veut que celles auquel l'utilisateur participe
            $r = sql_select(
                    array('JDR', 'ModeleJDR', 'Joueur'),
                    "*",
                    array(
                        'JDR::id_modele_jdr' => 'ModeleJDR::id_modele_jdr',
                        'Joueur::id_jdr_participe' => 'JDR::id_jdr',
                        'Joueur::id_utilisateur' =>  $id_utilisateur
                    ),
                    array('id_jdr' => 'DESC'),
                    true
                );

        // pour chaque JDR affiche une entrée; si `id_utilisateur` n'est pas précisé on propose de rejoindre
        while ($jdr = $r->fetch()) { ?>
            <li>
                <a href="./jdr.php?id=<?=$jdr['id_jdr']?>">
                    <div class="card">
                        <h2><?=$jdr['titre']?></h2>
                        <p class="desc_jdr"><?=$jdr['desc_jdr']?></P>
                        <?php if (empty($id_utilisateur)) { ?><p class="text-right">Rejoindre ce JDR ! (code : <?=$jdr['code_invite']?>)</p><?php } ?>
                    </div>
                </a>
            </li><?php
        }
    ?>
</ul>
<!-- FIN liste joueur -->

<!-- liste MJ -->
<?php
    if (isset($id_utilisateur)) { // récupère toutes les parties que l'utilisateur dirige
        $r = sql_select(
                array('JDR', 'ModeleJDR', 'MJ'),
                "*",
                array(
                    'JDR::id_modele_jdr' => 'ModeleJDR::id_modele_jdr',
                    'MJ::id_jdr_dirige' => 'JDR::id_jdr',
                    'MJ::id_utilisateur' =>  $id_utilisateur
                ),
                array('id_jdr' => 'DESC'),
                true
            );

        // seulement si on a effectivement touver des JDR
        if (0 < $r->rowCount()) { ?>
            <h2>Vos JDR en tant que MJ</h2>
            <ul>
                <?php
                    while ($jdr = $r->fetch()) { ?>
                        <li>
                            <a href="./jdr.php?id=<?=$jdr['id_jdr']?>">
                                <div class="card">
                                    <h2><?=$jdr['titre']?></h2>
                                    <p class="desc_jdr"><?=$jdr['desc_jdr']?></P>
                                </div>
                            </a>
                        </li><?php
                    }
                ?>
            </ul><?php
        }
    }
?>
<!-- FIN liste MJ -->