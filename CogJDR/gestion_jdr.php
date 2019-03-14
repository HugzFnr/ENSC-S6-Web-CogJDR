<?php
    /**
     * = Page de gestion des comptes
     * 
     * == liste des actions :
     *
     *  1. `creer` : créer un jrd
     *  0. `rejoindre` : rejoindre un jdr, c'est l'action par défaut si non précisée (note : après avoir cliquer sur rejoindre de la page `action=afficher`)
     *  0. `quitter` : quitter le jdr [?]
     *  0. `afficher` : affiche les informations du jdr selon l'utilisateur (mj ou joueur) (ne redirige pas en cas de succès)
     *
     * == redirections :
     * 
     *  * en cas d'échec, redirige vers `redirection_echec`
     *  * en cas de succès, redirige vers `redirection_succes`
     */
    require_once "./inclus/connection.php";
    require_once "./inclus/session.php";

    $redirige = isset($_REQUEST['redirection_echec']) ? $_REQUEST['redirection_echec'] : "./#";
    
    switch (isset($_REQUEST['action']) ? $_REQUEST['action'] : "rejoindre") {
        
        case "creer":
                echo "TODUUUUUU~ &#127927;";
            break;

        case "rejoindre":
                if (!sql_select('Joueur', 'pseudo', array('id_jrd_participe' => $_REQUEST['id_jdr']))) {
                    sql_insert('Joueur', array(
                        'id_joueur' => null,
                        'id_utilisateur' => $_SESSION['id'],
                        'id_jrd_participe' => $_REQUEST['id_jrd'],
                        'pseudo' => $_REQUEST['pseudo']
                    ));
                } else
                    $_SESSION['erreur'] = "Erreur pseudal existant";
            break;

        case "quitter":
                echo "TODUUUUUU~ &#127927;";
            break;

        case "afficher":
                $r = sql_select('JDR', "*", array('code_invite' => $_REQUEST['code']));

                if ($jdr = $r->fetch() && $modele = sql_select('ModeleJDR', "*", array('id_modele_jdr' => $jdr['id_modele_jdr']))) {
                    $sous_titre = $modele['titre']." {".$jdr['code_invite']."}";
                    
                    include_once "./inclus/page_debut.php"; ?>

                    <h1>Affichage du JDR <?=$modele['titre']?> (no<?=$jdr['id_jdr']?>)</h1>
                    description : <?=$modele['desc_jdr']?>, imgeeze...
                    
                    <form action="gestion_jdr">
                        <input type="hidden" name="action" value="rejoindre">
                        <input type="hidden" name="id_jdr" value="<?=$jdr['id_jdr']?>">
                        
                        <input type="text" name="pseudo" id="rejoindre_pseudo" placeholder="Choisisez un Pseudal">
                        <button type="submit">Rejoindre</button>
                    </form><?php

                    include_once "./inclus/page_fin.php";
                } else {
                    $_SESSION['Erreur JDR non trouver'];
                }
            break;
            
        default:
                $_SESSION['erreur'] = "Erreur d'action dans `gestion_jdr.php`";
    }

    if (!empty($redirige))
        header("Location: $redirige");
?>
