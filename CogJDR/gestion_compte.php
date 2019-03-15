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
                        'mdp' => htmlentities($_REQUEST['mdp']),
                        'email' => htmlentities($_REQUEST['email']),
                        'img' => htmlentities($_REQUEST['img']) // TODO: gestion d'images (voir `./inclus/connection.php`)
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
                    'mdp' => htmlentities($_REQUEST['mdp']),
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
                                'id_jdr' => $joueur['id_jrd_participe'],

                                'id_joueur' => $joueur['id_joueur'],
                                'nom_joueur' => "<code>Joueur(id_joueur=1, id_jrd_participe=0) # pseudo</code>",

                                // SELECT DISTINCT Equipe.id_equipe, ModeleEquipe.titre_equipe
                                // FROM EstDans JOIN Equipe JOIN ModeleEquipe
                                // WHERE EstDans.id_equipe = Equipe.id_equipe
                                //     AND Equipe.id_modele_equipe = ModeleEquipe.id_modele_equipe
                                //     AND EstDans.id_joueur = $joueur['id_joueur'];
                                'liste_equipe' => sql_select(
                                        array('EstDans', 'Equipe', 'ModeleEquipe'),
                                        "DISTINCT Equipe.id_equipe, ModeleEquipe.titre_equipe",
                                        array(
                                            'EstDans.id_equipe' => 'Equipe.id_equipe',
                                            'Equipe.id_modele_equipe' => 'ModeleEquipe.id_modele_equipe',
                                            'EstDans.id_joueur' => $joueur['id_joueur']
                                        )
                                    )->fetchAll(),
                                
                                'indice_equipe_discussion_suivi' => 0
                            ));
                        }

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
                $_SESSION['erreur'] = "Erreur d'action dans `gestion_compte.php`";
                //$redirige = $_REQUEST['redirection_echec'];
    }

    if (!empty($redirige))
        header("Location: $redirige");
?>
