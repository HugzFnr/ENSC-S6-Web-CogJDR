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

        case "modifier": // pas à jour
                $is = sql_update('Utilisateur', array(
                    'mdp' => $_REQUEST['mdp'],
                    'email' => htmlentities($_REQUEST['email']),
                    'img' => htmlentities($_REQUEST['img']) // TODO: gestion d'images (voir `./inclus/connection.php`)
                ), array('id' => $_SESSION['id']));
                    
                if ($is)
                    $redirige = $_REQUEST['redirection_succes'];
                else {
                    $_SESSION['erreur'] = "Erreur /*-*/";
                    //$redirige = $_REQUEST['redirection_echec'];
                }
            break;

        case "creer":
                var_dump($_FILES['img']);
                $r = sql_select('Utilisateur', "email", array('email' => $_REQUEST['email']));
                if ($r->fetch()) {
                    $_SESSION['erreur'] = "Erreur compte existant";
                    break;
                } else {
                    $envoi = send_image($_FILES['img'], $_REQUEST['email']);
                    if ($envoi['success'] && sql_insert('Utilisateur', array(
                                'id' => null,
                                'mdp' => $_REQUEST['mdp'],
                                'email' => htmlentities($_REQUEST['email']),
                                'img' => "images/utilisateurs/".$envoi['fileName']
                            )))
                        $redirige = $_REQUEST['redirection_succes'];
                    else {
                        $_ESSION['erreur'] = "Erreur /*-*/ : ".$envoi['msg'];
                        break;
                    }
                }
        
        case "connecter":
                $r = sql_select('Utilisateur', "*", array('email' => $_REQUEST['email']));
                if ($utilisateur = $r->fetch()) {
                    if ($_REQUEST['mdp'] == $utilisateur['mdp']) {
                        $_SESSION['id'] = $utilisateur['id'];
                        $_SESSION['email'] = $utilisateur['email'];
                        $_SESSION['img'] = $utilisateur['img'];
                        
                        $liste_constructeur = array();
                        $r_ = sql_select('Joueur', "*", array('id_utilisateur' => $_SESSION['id']));
                        while($joueur = $r_->fetch()) {
                            array_push($liste_constructeur, array(
                                'id_jdr' => $joueur['id_jdr_participe'],

                                'id_joueur' => $joueur['id_joueur'],
                                'nom_joueur' => $joueur['pseudo'],

                                // SELECT DISTINCT Equipe.id_equipe, ModeleEquipe.titre_equipe
                                // FROM EstDans JOIN Equipe JOIN ModeleEquipe
                                // WHERE EstDans.id_equipe = Equipe.id_equipe
                                //     AND Equipe.id_modele_equipe = ModeleEquipe.id_modele_equipe
                                //     AND EstDans.id_joueur = $joueur['id_joueur'];
                                'liste_equipe' => sql_select(
                                        array(
                                            'EstDans',
                                            'Equipe',
                                            'ModeleEquipe'
                                        ),
                                        array(
                                            'Equipe.id_equipe',
                                            'ModeleEquipe.titre_equipe'
                                        ),
                                        array(
                                            'EstDans.id_equipe' => 'Equipe.id_equipe',
                                            'Equipe.id_modele_equipe' => 'ModeleEquipe.id_modele_equipe',
                                            'EstDans.id_joueur' => $joueur['id_joueur']
                                        ),
                                        null,
                                        true
                                    )->fetchAll(PDO::FETCH_ASSOC),
                                'indice_equipe_discussion_suivi' => 0
                            ));
                        }
                        var_dump($liste_constructeur);
                        $_SESSION['liste_donnees_jdr'] = $liste_constructeur;
                        $_SESSION['indice_jdr_suivi'] = count($liste_constructeur) - 1; // indice dans la liste d'au dessus :)

                        $redirige = $_REQUEST['redirection_succes'];
                    } else
                        $_SESSION['erreur'] = "Erreur d'authentification - mauvais mot de passe";
                } else
                    $_SESSION['erreur'] = "Erreur d'authentification - compte innexistant";
            break;

        case "supprimer":
                sql_delete('Utilisateur', array('id' => $_SESSION['id']));

        case "deconnecter":
                session_unset();
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
                $_SESSION['erreur'] = "Erreur d'action dans `compte.php`";
                //$redirige = $_REQUEST['redirection_echec'];
    }

    if (!empty($redirige))
        header("Location: $redirige");
?>
