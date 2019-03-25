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
    require_once "./inclus/connexion.php";
    require_once "./inclus/session.php";

    $redirige = isset($_REQUEST['redirection_echec']) ? $_REQUEST['redirection_echec'] : "./#";
    $_REQUEST['redirection_succes'] = isset($_REQUEST['redirection_succes']) ? $_REQUEST['redirection_succes'] : "./#";
    
    if ($_SESSION['indice_jdr_suivi'] < 0)
        foreach ($_SESSION['liste_donnees_jdr'] as $k => $v)
            if ($v['id_jdr'] == $_REQUEST['id'])
                $_SESSION['indice_jdr_suivi'] = $k;

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

                if (!sql_select('Joueur', 'pseudo', array('id_jdr_participe' => $_REQUEST['id'], 'pseudo' => $pseudo))->fetch()) {
                    sql_insert('Joueur', array(
                        'id_joueur' => null,
                        'id_utilisateur' => $_SESSION['id'],
                        'id_jdr_participe' => $_REQUEST['id'],
                        'pseudo' => $pseudo
                    ));

                    array_push($_SESSION['liste_donnees_jdr'], array(
                        'est_mj' => false,
                        'id_jdr' => $_REQUEST['id'],
                        'titre_jdr' => sql_select(
                                array('JDR', 'ModeleJDR'),
                                array('ModeleJDR.titre'),
                                array(
                                    'JDR::id_modele_jdr' => 'ModeleJDR::id_modele_jdr',
                                    'JDR::id_jdr' => $_REQUEST['id'],
                                )
                            )->fetch()['titre'],

                        'id_dans' => sql_select('Joueur', 'id_joueur', array('id_utilisateur' => $_SESSION['id'], 'id_jdr_participe' => $_REQUEST['id']))->fetch()['id_joueur'],
                        'pseudo_dans' => $pseudo,

                        'liste_equipe' => array(),
                        'indice_equipe_discussion_suivi' => 0
                    ));

                    if ($redirige == "./#")
                        $redirige = "./jdr.php?id=".$_REQUEST['id'];
                } else
                    $_SESSION['erreur'] = "Erreur pseudal existant";
            break;

        case "afficher":
                $where = isset($_REQUEST['code']) ? array('code_invite' => $_REQUEST['code']) : array('id_jdr' => $_REQUEST['id']);
                $r = sql_select('JDR', "*", $where);

                $jdr = $r->fetch();
                if ($jdr && $modele = sql_select('ModeleJDR', "*", array('id_modele_jdr' => $jdr['id_modele_jdr']))->fetch()) {
                    $__sous_titre = $modele['titre']." | ".$jdr['code_invite'];
                    $__css_necessaires = array("discussion", "jdr");
                    $__liste_equipes = array();

                    $est_connecte = isset($_SESSION['id']);

                    $a_rejoint = false;
                    if ($est_connecte)
                        foreach ($_SESSION['liste_donnees_jdr'] as $v) {
                            $a_rejoint = $v['id_jdr'] == $jdr['id_jdr'];

                            if ($a_rejoint) {
                                if ($_SESSION['indice_jdr_suivi'] < 0)
                                    exit;
        
                                if ($donnees_jdr = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']]) {
                                    if (empty($donnees_jdr['liste_equipe']))
                                        $__liste_equipes[] = array('href' => "#TODO", 'text' => "Rejoinier une équipe !", 'activ' => false);
                                    else foreach ($donnees_jdr['liste_equipe'] as $k => $v)
                                        $__liste_equipes[] = array('href' => $k, 'text' => $v['titre_equipe'], 'activ' => $k == $donnees_jdr['indice_equipe_discussion_suivi']);
                                }

                                break;
                            }
                        }

                    include_once "./inclus/page_debut.php";
                    
                    if (!$a_rejoint) {
                        include "./inclus/jdr/rejoindre.php";

                        if ($est_connecte) { ?>
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
                    } else {
                        include "./inclus/jdr/consulter.php"; ?>

                        <hr>
                        <form action="./jdr.php">
                            <input type="hidden" name="id" value="<?=$jdr['id_jdr']?>">

                            <div class="text-right">
                                <button class="btn btn-danger" type="submit" name="action" value="quitter">Quitter<!--? (retire TOUT, même les msg... -> idée : mettre l'ìd_utilisateur` à `null`) ?--></button>
                            </div>
                        </form><?php
                    }

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
