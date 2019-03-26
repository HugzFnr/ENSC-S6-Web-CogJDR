<ul>
    <?php
        $r = sql_select(array('JDR', 'ModeleJDR'), "*", array('JDR::id_modele_jdr' => 'ModeleJDR::id_modele_jdr'), array('id_jdr' => 'DESC'), true);

        while ($jdr = $r->fetch()) { ?>
            <li>
                <div class="card">
                    <h2><?=$jdr['titre']?></h2>
                    <p class="desc_jdr"><?=$jdr['desc_jdr']?></P>
                    <a href="./jdr.php?id=<?=$jdr['id_jdr']?>">Rejoindre ce JDR ! (code : <?=$jdr['code_invite']?>)</a>
                </div>
            </li><?php
        }
    ?>
</ul>