<?php
    /**
     * = Page de gestion des comptes
     * 
     * == liste des actions :
     *
     *  1. `creer` : créer un jrd (note : après avoir renseigner les formulaires sur la page)
     *  0. `rejoindre` : rejoindre un jdr (note : après avoir cliquer sur rejoindre de la page `action=afficher`)
     *  0. `quitter` : quitter le jdr [?]
     *  0. `afficher` : affiche les informations du jdr selon l'utilisateur (mj ou joueur) (fonctionne avec un code ou avec un id),
     *              c'est l'action par défaut si non précisée (ne redirige pas en cas de succès)
     *
     * == redirections :
     * 
     *  * en cas d'échec, redirige vers `redirection_echec`
     *  * en cas de succès, redirige vers `redirection_succes`
     */
    require_once "./inclus/connection.php";
    require_once "./inclus/session.php";

    $redirige = isset($_REQUEST['redirection_echec']) ? $_REQUEST['redirection_echec'] : "./#";
    
    switch (isset($_REQUEST['action']) ? $_REQUEST['action'] : "afficher") {
        
        case "creer":
                $code = substr(bin2hex(random_bytes(ceil(8 / 2))), 0, 8);
                sql_insert('JDR', array(
                    'id_jdr' => null,
                    'id_modele_jdr' => $_REQUEST['id_modele_jdr'],
                    'code_invite' => $code,
                    'nb_max_joueurs' => empty($_REQUEST['nb_max_joueurs']) ? 0 : $_REQUEST['nb_max_joueurs'],
                    'nb_min_joueurs' => empty($_REQUEST['nb_min_joueurs']) ? 0 : $_REQUEST['nb_min_joueurs'],
                    'jours_ouvrables' => "7 jours" // voir l'énumération
                ));
                echo "code d'invitation: <a href=\"./gestion_jdr.php?code=$code\">$code";
            break;

        case "rejoindre":
                if (!sql_select('Joueur', 'pseudo', array('id_jrd_participe' => $_REQUEST['id_jdr']))) {
                    sql_insert('Joueur', array(
                        'id_joueur' => null,
                        'id_utilisateur' => htmlentities($_SESSION['id']),
                        'id_jrd_participe' => htmlentities($_REQUEST['id_jrd']),
                        'pseudo' => htmlentities($_REQUEST['pseudo'])
                    ));
                } else
                    $_SESSION['erreur'] = "Erreur pseudal existant";
            break;

        case "quitter":
                sql_delete('Joueur', array('id_joueur' => $_SESSION['liste_donnees_jd'][$_SESSION['indice_jdr_suivi']]['id_joueur']));
                unset($_SESSION['liste_donnees_jd'][$_SESSION['indice_jdr_suivi']]);
                $_SESSION['indice_jdr_suivi'] = sizeof($_SESSION['liste_donnees_jd']) - 1;
            break;

        case "afficher":
                $where = empty($_REQUEST['id_jdr']) ? array('code_invite' => $_REQUEST['code']) : array('id_jdr' => $_REQUEST['id_jdr']);
                $r = sql_select('JDR', "*", $where);

                if ($jdr = $r->fetch() && $modele = sql_select('ModeleJDR', "*", array('id_modele_jdr' => $jdr['id_modele_jdr']))) {
                    $sous_titre = $modele['titre']." {".$jdr['code_invite']."}";
                    
                    include_once "./inclus/page_debut.php"; ?>

                    <h1>Affichage du JDR <?=$modele['titre']?> (no<?=$jdr['id_jdr']?>)</h1>
                    description : <?=$modele['desc_jdr']?>, imgeeze...<br><br>
                    
                    <?php
                        $a_rejoint = false;
                        foreach ($_SESSION['liste_donnees_jd'] as $value)
                            $a_rejoint = isset($value['id_jdr']) && $value['id_jdr'] == $jdr['id_jdr'];
                        
                        if (!$a_rejoint) { ?>
                            <form action="gestion_jdr">
                                <input type="hidden" name="action" value="rejoindre">
                                <input type="hidden" name="id_jdr" value="<?=$jdr['id_jdr']?>">
                                
                                <input type="text" name="pseudo" id="rejoindre_pseudo" placeholder="Choisisez un Pseudal">
                                <button type="submit">Rejoindre</button>
                            </form>
                        <?php }

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
