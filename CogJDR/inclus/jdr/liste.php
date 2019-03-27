<ul>
    <?php
        if (empty($id_utilisateur))
            $r = sql_select(array('JDR', 'ModeleJDR'), "*", array('JDR::id_modele_jdr' => 'ModeleJDR::id_modele_jdr'), array('id_jdr' => 'DESC'), true);
        else
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
