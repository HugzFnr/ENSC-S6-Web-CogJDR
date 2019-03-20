<?php
    /**
     * = Page de gestion des comptes
     * 
     * == liste des actions :
     *
     *  1. `creer` : créer un jdr (note : après avoir renseigner les formulaires sur la page)
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
    $_REQUEST['redirection_succes'] = isset($_REQUEST['redirection_succes']) ? $_REQUEST['redirection_succes'] : "./#";
    
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
                echo "code d'invitation: <a href=\"./jdr.php?code=$code\">$code";
            break;

        case "quitter":
                $id_joueur = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']]['id_joueur'];
                sql_delete('Message_', array('id_joueur' => $id_joueur));
                sql_delete('EstUn', array('id_joueur' => $id_joueur));
                sql_delete('EstDans', array('id_joueur' => $id_joueur));
                sql_delete('Action_', array('id_joueur_cible' => $id_joueur));
                sql_delete('Joueur', array('id_joueur' => $id_joueur));
                unset($_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']]);
                $_SESSION['indice_jdr_suivi'] = sizeof($_SESSION['liste_donnees_jdr']) - 1;
            break;

        case "rejoindre":
                $pseudo = htmlentities($_REQUEST['pseudo']);
                if (!sql_select('Joueur', 'pseudo', array('id_jdr_participe' => $_REQUEST['id_jdr'], 'pseudo' => $pseudo))->fetch()) {
                    sql_insert('Joueur', array(
                        'id_joueur' => null,
                        'id_utilisateur' => $_SESSION['id'],
                        'id_jdr_participe' => $_REQUEST['id_jdr'],
                        'pseudo' => $pseudo
                    ));

                    array_push($_SESSION['liste_donnees_jdr'], array(
                        'id_jdr' => $_REQUEST['id_jdr'],

                        'id_joueur' => sql_select('Joueur', 'id_joueur', array('id_utilisateur' => $_SESSION['id'], 'id_jdr_participe' => $_REQUEST['id_jdr']))->fetch()['id_joueur'],
                        'nom_joueur' => $pseudo,

                        'liste_equipe' => array(),
                        'indice_equipe_discussion_suivi' => -1
                    ));

                    unset($redirige);
                } else
                    $_SESSION['erreur'] = "Erreur pseudal existant";

        case "afficher":
                $where = isset($_REQUEST['code']) ? array('code_invite' => $_REQUEST['code']) : array('id_jdr' => $_REQUEST['id_jdr']);
                $r = sql_select('JDR', "*", $where);

                $jdr = $r->fetch();
                if ($jdr && $modele = sql_select('ModeleJDR', "*", array('id_modele_jdr' => $jdr['id_modele_jdr']))->fetch()) {
                    $sous_titre = $modele['titre']." {".$jdr['code_invite']."}";
                    
                    include_once "./inclus/page_debut.php"; ?>

                    <h1>Affichage du JDR <?=$modele['titre']?> (no<?=$jdr['id_jdr']?>)</h1>
                    description : <?=$modele['desc_jdr']?>, imgeeze...<br><br>
                    
                    <?php
                        $est_connecte = isset($_SESSION['liste_donnees_jdr']);

                        $a_rejoint = false;
                        if ($est_connecte)
                            foreach ($_SESSION['liste_donnees_jdr'] as $value)
                                $a_rejoint = $value['id_jdr'] == $jdr['id_jdr'];
                        
                        if (!$a_rejoint) {
                            if ($est_connecte) { ?>
                                <form action="./jdr.php">
                                    <input type="hidden" name="action" value="rejoindre">
                                    <input type="hidden" name="id_jdr" value="<?=$jdr['id_jdr']?>">
                                    
                                    <input type="text" name="pseudo" id="rejoindre_pseudo" placeholder="Choisisez un Pseudal">
                                    <button type="submit">Rejoindre</button>
                                </form>
                            <?php } else { ?>
                                <form action="./compte.php" method="post">
                                    <input type="hidden" name="action" value="connecter">
                                    <input type="hidden" name="redirection_echec" value="<?=$_SERVER['REQUEST_URI']?>">
                                    <input type="hidden" name="redirection_succes" value="<?=$_SERVER['REQUEST_URI']?>">

                                    <input type="text" name="email" id="gestion_compte_email" placeholder="Entrez votre email">
                                    <input type="password" name="mdp" id="gestion_compte_mdp" placeholder="Entrez un mot de passe">
                                    <input type="text" name="img" id="gestion_compte_img" value="sdbldb"><!--input type="file" name="img" id="gestion_compte_img"-->

                                    <button type="submit"><?=isset($_SESSION['id']) ? "Modifier les Donn&eacute;es" : "Se Connecter"?></button>
                                </form>
                            <?php }
                        } else { ?>
                            <form action="./jdr.php">
                                <input type="hidden" name="action" value="quitter">
                                <input type="hidden" name="id_jdr" value="<?=$jdr['id_jdr']?>">
                                
                                <button type="submit">Quitter</button>
                            </form>
                        <?php }

                    include_once "./inclus/page_fin.php";

                    unset($redirige);
                } else
                    $_SESSION['erreur'] = "Erreur JDR non trouver";
            break;
            
        default:
                $_SESSION['erreur'] = "Erreur d'action dans `jdr.php`";
    }

    if (!empty($redirige))
        header("Location: $redirige");
?>
