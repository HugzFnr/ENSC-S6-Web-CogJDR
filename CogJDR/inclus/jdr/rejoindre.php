<h1 class="text-center">JDR : <?=$modele['titre']?></h1>

<img class="img_banniere" src="<?=$modele['img_banniere']?>" alt="Oof">

<p class="desc_jdr"><?=$modele['desc_jdr']?></p>

<a href="">Télécharger les règles</a>

<hr>
<p>Joueurs actuellement inscrits à cette partie</p>

<table class="liste_joueurs container">
    <tr>
        <th>Adresse e-mail</th><th>Pseudo</th>
    </tr>

    <?php
        // récupère touts les joueurs déjà inscrit
        $r = sql_select('Joueur', array('pseudo', 'id_utilisateur'), array('id_jdr_participe' => $jdr['id_jdr']));

        for ($k = 0; $k < $jdr['nb_max_joueurs']; $k++) {
            $joueur = $r->fetch();

            if (!empty($joueur)) { ?>
                <tr>
                    <td><?=sql_select('Utilisateur', 'email', array('id' => $joueur['id_utilisateur']))->fetch()['email']?></td>
                    <td><?=$joueur['pseudo']?></td>
                </tr><?php
            } else { ?>
                <tr>
                    <td>-</td>
                    <td>-</td>
                </tr><?php
            }
        }
    ?>
</table>

<?php
    // s'il es connecté, ajout d'un form pour renter un pseudo
    if (isset($_SESSION['id'])) { ?>
        <hr>
        
        <form class="w-100" action="./jdr.php">
            <input type="hidden" name="id" value="<?=$jdr['id_jdr']?>">
            
            <table class="w-100">
                <tr>
                    <td><input class="form-control w-auto float-right" type="text" name="pseudo" id="rejoindre_pseudo" placeholder="Choisisez un Pseudal"></td>
                    <td><button class="btn btn-primary btn-block w-auto float-left" type="submit" name="action" value="rejoindre">Rejoindre</button></td>
                </tr>
            </table>
        </form><?php
    }
?>
