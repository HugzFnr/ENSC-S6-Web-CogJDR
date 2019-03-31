<?php
    /**
     * = Page de gestion des comptes
     * 
     * == liste des actions :
     *
     *  1. `creer` : créer un compte
     *  0. `modifier` : modifier un compte
     *  0. `connecter` : connexion à un compte
     *  0. `supprimer` : suppression du compte
     *  0. `deconnecter` : finir la session
     *  0. `afficher` : affiche les informations publiques du compte (ne redirige pas en cas de succès)
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

    switch (isset($_REQUEST['action']) ? $_REQUEST['action'] : "afficher") {

        /**
         * Modifie les données de l'utilisateur :
         * 
         * _REQUEST :
         *  - mdp
         *  - email
         *  - img
         * 
         * _SESSION :
         *  - id
         */
        case "modifier":
                // s'il a changer d'e-mail..
                if ($_REQUEST['email'] != $_SESSION['email']) {
                    // vérifie qu'il s'agit bien d'une adresse e-mail valide
                    if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['erreur'] = "Erreur &ccedil;a ne ressemble pas a une adresse e-mail...";
                        break;
                    }
                    // vérifie qu'un utilisateur n'a pas déjà utiliser cette adresse e-mail
                    if (sql_select('Utilisateur', "email", array('email' => $_REQUEST['email']))->fetch()) {
                        $_SESSION['erreur'] = "Erreur e-mail d&eacute;j&agrave; utilis&eacute;e";
                        break;
                    }
                }

                // s'il a changer d'image, envoi la nouvelle image
                if ($_REQUEST['img'] != $_SESSION['img'])
                    $envoi = send_image($_FILES['img'], $_REQUEST['email'], "images/compte/");

                // si l'envoi à réussi, MAJ la BDD
                $is = $envoi['success'] && sql_update('Utilisateur', array(
                        'mdp' => $_REQUEST['mdp'],
                        'email' => htmlentities($_REQUEST['email']),
                        'img' => $envoi['fileName']
                    ), array('id' => $_SESSION['id']));

                    
                if ($is)
                    $redirige = $_REQUEST['redirection_succes'];
                else
                    $_SESSION['erreur'] = "Erreur /*-*/ : ".$envoi['msg'];
            break;

        /**
         * Créer un nouveau compte :
         * 
         * _REQUEST :
         *  - mdp
         *  - email
         *  - img
         */
        case "creer":
                // vérifie qu'il s'agit bien d'une adresse e-mail valide
                if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['erreur'] = "Erreur &ccedil;a ne ressemble pas a une adresse e-mail...";
                    break;
                }

                // vérifie qu'un utilisateur n'a pas déjà utiliser cette adresse e-mail
                if (sql_select('Utilisateur', "email", array('email' => $_REQUEST['email']))->fetch()) {
                    $_SESSION['erreur'] = "Erreur compte existant";
                    break;
                }

                if (0 < $_FILES['img']['size']) // si l'utilisateur a précisé une image, l'envoi
                    $envoi = send_image($_FILES['img'], $_REQUEST['email'], "images/compte/");
                else { // sinon duplique l'image par défaut
                    $nom_fichier = str_replace("%", "_", rawurlencode(str_replace(" ", "-", $_REQUEST['email'])));
                    $envoi = array('success' => copy("images/defaut/utilisateur.png", "images/compte/$nom_fichier.png"), 'fileName' => "$nom_fichier.png");
                }

                // si la création de compte à réussie, continue sur la case suivant
                if ($envoi['success'] && sql_insert('Utilisateur', array(
                            'id' => null,
                            'mdp' => $_REQUEST['mdp'],
                            'email' => htmlentities($_REQUEST['email']),
                            'img' => $envoi['fileName']
                        )))
                    $redirige = $_REQUEST['redirection_succes'];
                else {
                    $_SESSION['erreur'] = "Erreur /*-*/ : ".$envoi['msg'];
                    break;
                }
        
        /**
         * Récupère toutes les données de connection de l'utilisateur :
         * 
         * _REQUEST :
         *  - email
         *  - mdp
         */
        case "connecter":
                // vérifie d'abord que l'utilisateur existe
                $r = sql_select('Utilisateur', "*", array('email' => $_REQUEST['email']));
                if ($utilisateur = $r->fetch()) {
                    // puis que le mot de passe est le bon
                    if ($_REQUEST['mdp'] == $utilisateur['mdp']) {
                        $_SESSION['id'] = $utilisateur['id'];
                        $_SESSION['email'] = $utilisateur['email'];
                        $_SESSION['img'] = $utilisateur['img'];
                        
                        // charge toute les données des JDRs auquel l'utilisateur est connecté
                        maj_donnees_jdr();

                        $redirige = $_REQUEST['redirection_succes'];
                    } else
                        $_SESSION['erreur'] = "Erreur d'authentification - mauvais mot de passe";
                } else
                    $_SESSION['erreur'] = "Erreur d'authentification - compte innexistant";
            break;

        /**
         * @Depreciated
         * Supprime un compte (mais je pense pas que ça fonctionne -> erreur MySQL 1451 justifiée) :
         * 
         * _SESSION :
         *  - id
         */
        case "supprimer":
                sql_delete('Utilisateur', array('id' => $_SESSION['id']));

        /**
         * Déconnecte l'utilisateur
         */
        case "deconnecter":
                session_unset();
                session_destroy();
            break;

        /**
         * Affiche des informations sur un utilisateur :
         * 
         * _REQUEST :
         *  - id
         */
        case "afficher":
                $r = sql_select('Utilisateur', array('id', 'email', 'img'), array('id' => $_REQUEST['id']));
                
                if ($utilisateur = $r->fetch()) {
                    $__sous_titre = $utilisateur['email'];

                    include_once "./inclus/page_debut.php"; ?>

                    <h1>Affichage du compte de <?=$utilisateur['email']?> (no<?=$utilisateur['id']?>)</h1>
                    image : <code>./images/compte/<?=$utilisateur['img']?></code>, <a>mp[?]</a>...<?php

                    include_once "./inclus/page_fin.php";

                    unset($redirige);
                } else
                    $_SESSION['erreur'] = "Erreur compte introuvable";
            break;
        
        default:
                $_SESSION['erreur'] = "Erreur d'action dans `compte.php`";
                //$redirige = $_REQUEST['redirection_echec'];
    }

    if (!empty($redirige))
        header("Location: $redirige");
?>
