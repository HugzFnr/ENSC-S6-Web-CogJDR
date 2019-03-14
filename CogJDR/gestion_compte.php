<?php
    /**
     * = Page de gestion des comptes
     * 
     * == liste des actions :
     *
     *  1. `creer` : créer un compte
     *  0. `modifier` : modifier un compte
     *  0. `connecter` : connection à un compte
     *  0. `supprimer` : suppression du compte
     *  0. `deconnecter` : finire la session
     *  0. `afficher` : affiche les informations publiques du compte (ne redirige pas en cas de succès)
     *
     * == redirections :
     * 
     *  * en cas d'échec, redirige vers `redirection_echec`
     *  * en cas de succès, redirige vers `redirection_succes`
     */
    require_once "./inclus/connection.php";
    require_once "./inclus/session.php";

    $redirige = isset($_REQUEST['redirection_echec']) ? $_REQUEST['redirection_echec'] : "./#";

    switch (isset($_REQUEST['action']) ? $_REQUEST['action'] : "") {
        case "creer":
                $r = sql_select('Utilisateur', "email", array('email' => $_REQUEST['email']));
                if ($r->fetch()) {
                    $_SESSION['erreur'] = "Erreur compte existant";
                    //$redirige = $_REQUEST['redirection_echec'];
                } else {
                    $is = sql_insert('Utilisateur', array(
                        'id' => null,
                        'mdp' => $_REQUEST['mdp'],
                        'email' => $_REQUEST['email'],
                        'img' => $_REQUEST['img'] // TODO: gestion d'images (voir `connection.php`)
                    ));
                    
                    if ($is)
                        $redirige = $_REQUEST['redirection_succes'];
                    else {
                        $_SESSION['erreur'] = "Erreur /*-*/";
                        //$redirige = $_REQUEST['redirection_echec'];
                    } 
                }
            break;
        
        case "modifier":
                $is = sql_update('Utilisateur', array(
                    'mdp' => $_REQUEST['mdp'],
                    'email' => $_REQUEST['email'],
                    'img' => $_REQUEST['img'] // TODO: gestion d'images (voir `connection.php`)
                ), array('id' => $_SESSION['id']));
                    
                if ($is)
                    $redirige = $_REQUEST['redirection_succes'];
                else {
                    $_SESSION['erreur'] = "Erreur /*-*/";
                    //$redirige = $_REQUEST['redirection_echec'];
                }
            break;
        
        case "connecter":
                $r = sql_select('Utilisateur', "*", array('mdp' => $_REQUEST['mdp'], 'email' => $_REQUEST['email']));
                if ($utilisateur = $r->fetch()) {
                    $_SESSION['id'] = $utilisateur['id'];
                    $_SESSION['email'] = $utilisateur['email'];
                    $_SESSION['img'] = $utilisateur['img'];
                    $redirige = $_REQUEST['redirection_succes'];
                } else {
                    $_SESSION['erreur'] = "Erreur d'authentification";
                    //$redirige = $_REQUEST['redirection_echec'];
                }
            break;

        case "supprimer":
                sql_delete('Utilisateur', array('id' => $_SESSION['id']));

        case "deconnecter":
                unset($_SESSION['id']);
                unset($_SESSION['email']);
                unset($_SESSION['img']);
                unset($_SESSION['liste_donnees_jd']);
                unset($_SESSION['indice_jdr_suivi']);

                session_destroy();
            break;
        
        case "afficher":
                $r = sql_select('Utilisateur', array('id', 'email', 'img'), array('id' => $_REQUEST['id']));
                
                if ($utilisateur = $r->fetch()) {
                    $sous_titre = $utilisateur['email'];

                    include_once "./inclus/page_debut.php"; ?>

                    <h1>Affichage du compte de <?=$utilisateur['email']?> (no<?=$utilisateur['id']?>)</h1>
                    image : <?=$utilisateur['img']?>, <a>mp[?]</a>...<?php

                    include_once "./inclus/page_fin.php";

                    unset($redirige);
                } else
                    $_SESSION['erreur'] = "Erreur compte introuvable";
            break;
        
        default:
                $_SESSION['erreur'] = "Erreur d'action dans `gestion_compte.php`";
                //$redirige = $_REQUEST['redirection_echec'];
    }

    if (!empty($redirige))
        header("Location: $redirige");
?>
