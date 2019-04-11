<?php
    /**
     * = Page de gestion des comptes
     * 
     * == liste des actions :
     *
     *  1. `creer` : créer un jdr (note : après avoir renseigner les formulaires sur la page)
     *  0. `rejoindre` : rejoindre un jdr (note : après avoir cliquer sur rejoindre de la page `action=afficher`)
     *  0. `quitter` : quitter le jdr [?]
     *  0. `virer` : retire un joueur de la partie (à n'utiliser que si la partie n'a pas commencé)
     *  0. `etat_demarrer` : change l'état de la partie de "lancement" vers "deroulement"
     *  0. `etat_finir` : change l'état de la partie de "deroulement" vers "fin"
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
    
    // si un ID est précisé, met à jour les données de session
    if (isset($_REQUEST['id'])) {
        maj_donnees_jdr();

        if (isset($_SESSION['indice_jdr_suivi']))
            maj_jdr_suivi($_REQUEST['id']);

        if (-1 < @$_SESSION['indice_jdr_suivi'])
            $donnees_jdr = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']];
    }

    switch (isset($_REQUEST['action']) ? $_REQUEST['action'] : "afficher") {
        
        /**
         * Créer un nouveau JDR :
         * 
         * _REQUEST :
         *  - id_modele_jdr
         *  - nb_max_joueurs (si empty alors 0)
         *  - nb_min_joueurs (si empty alors 0)
         */
        case "creer":
                // génère un code aléatoire
                $code = "";
                for ($i = 0; $i < 8; $i++) {
                    switch (rand(1, 3)) {
                        case 1: $code.= chr(rand(ord('a'), ord('z'))); break;
                        case 2: $code.= chr(rand(ord('A'), ord('Z'))); break;
                        case 3: $code.= chr(rand(ord('0'), ord('9'))); break;
                    }
                }

                $id_modele_jdr = $_REQUEST['modele']['choix_modele'];
                $pseudo_mj = $_REQUEST['modele']['pseudo_mj'];
                $nb_joueurs_max = empty($_REQUEST['parametres']['nb_joueurs_max']) ? -1 : $_REQUEST['parametres']['nb_joueurs_max'];
                $nb_joueurs_min = empty($_REQUEST['parametres']['nb_joueurs_min']) ? -1 : $_REQUEST['parametres']['nb_joueurs_min'];
                $jours_ouvrables = $_REQUEST['parametres']['occurence'];

                // créer l'intance de JDR
                sql_insert('JDR', array(
                        'id_jdr' => null,
                        'id_modele_jdr' => $id_modele_jdr,
                        'code_invite' => $code,
                        'nb_max_joueurs' => $nb_joueurs_max,
                        'nb_min_joueurs' => $nb_joueurs_min,
                        'jours_ouvrables' => $jours_ouvrables." jours" // voir l'énumération
                    ));
                $id_jdr = sql_select('JDR', 'MAX(id_jdr)')->fetch()[0];

                // ajoute l'équipe "Tous"
                $id_modele_equipe_tous = sql_select('ModeleEquipe', 'id_modele_equipe', array('id_modele_jdr' => $id_modele_jdr, 'titre_equipe' => "Tous"))->fetch()['id_modele_equipe'];
                sql_insert('Equipe', array('id_equipe' => null, 'id_modele_equipe' => $id_modele_equipe_tous, 'id_jdr' => $id_jdr));

                // ajoute l'équipe "Vivants"
                $id_modele_equipe_tous = sql_select('ModeleEquipe', 'id_modele_equipe', array('id_modele_jdr' => $id_modele_jdr, 'titre_equipe' => "Vivants"))->fetch()['id_modele_equipe'];
                sql_insert('Equipe', array('id_equipe' => null, 'id_modele_equipe' => $id_modele_equipe_tous, 'id_jdr' => $id_jdr));

                // création d'un MJ de ce JDR à partire de l'utilisateur
                sql_insert('MJ', array(
                        'id_mj' => null,
                        'id_utilisateur' => $_SESSION['id'],
                        'id_jdr_dirige' => $id_jdr,
                        'pseudo_mj' => $pseudo_mj
                    ));

                // recharge les données et ajoute le nouveau JDR
                maj_donnees_jdr();

                //echo "Code d'invitation: <a href=\"./jdr.php?code=$code\">$code</a>";
                echo $id_jdr; // note : utilisé par JS pour redirigé lors de la création (voir `creerPartie.js`)
                unset($redirige);
            break;

        /**
         * @Depreciated
         * Retire un joueur d'un JDR (déprécié, probablement mauvait) :
         * 
         * _SESSION :
         *  - liste_donnees_jdr
         *      - id_dans
         *  - indice_jdr_suivi
         */
        case "quitter":
                if ($_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']]['est_mj'])
                    exit;
                $id_joueur = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']]['id_dans'];
                sql_delete('Message_', array('id_joueur' => $id_joueur));
                sql_delete('EstUn', array('id_joueur' => $id_joueur));
                sql_delete('EstDans', array('id_joueur' => $id_joueur));
                sql_delete('Action_', array('id_joueur_cible' => $id_joueur));
                sql_delete('Joueur', array('id_joueur' => $id_joueur));
                unset($_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']]);
                $_SESSION['indice_jdr_suivi'] = sizeof($_SESSION['liste_donnees_jdr']) - 1;
            break;

        /**
         * Ajout un joueur, attaché à l'utilisateur actuel, à la partie :
         * 
         * _REQUEST :
         *  - id : id_jdr_participe / id_jdr
         * 
         * _SESSION :
         *  - id
         *  - liste_donnees_jdr
         */
        case "rejoindre":
                $pseudo = htmlentities($_REQUEST['pseudo']);

                // vérifie qu'un utilisateur n'a pas déjà utiliser ce pseudo pour son joueur dans ce JDR
                if (!sql_select('Joueur', 'pseudo', array('id_jdr_participe' => $_REQUEST['id'], 'pseudo' => $pseudo))->fetch()) {
                    // vérifie qu'il reste de la place
                    if (sql_select('Joueur', 'COUNT(*)', array('id_jdr_participe' => $_REQUEST['id']))->fetch()[0] < sql_select('JDR', 'nb_max_joueurs', array('id_jdr' => $_REQUEST['id']))->fetch()['nb_max_joueurs']) {
                        // créée le nouveau joueur
                        sql_insert('Joueur', array(
                                'id_joueur' => null,
                                'id_utilisateur' => $_SESSION['id'],
                                'id_jdr_participe' => $_REQUEST['id'],
                                'pseudo' => $pseudo
                            ));
                        $id_joueur = sql_select('Joueur', 'MAX(id_joueur)')->fetch()[0];

                        // ajouter le joueur à l'équipe "Tous" de ce JDR
                        $id_equipe_tous = sql_select(
                                    array('ModeleEquipe', 'Equipe', 'JDR'),
                                    'Equipe.id_equipe',
                                    array(
                                            'Equipe::id_modele_equipe' => 'ModeleEquipe::id_modele_equipe',
                                            'JDR::id_jdr' => $_REQUEST['id'],
                                            'ModeleEquipe::id_modele_jdr' => 'JDR::id_modele_jdr',
                                            'ModeleEquipe::titre_equipe' => "Tous"
                                        )
                                )->fetch()['id_equipe'];
                        sql_insert('EstDans', array('id_joueur' => $id_joueur, 'id_equipe' => $id_equipe_tous));

                        // ajouter le joueur à l'équipe "Vivants" de ce JDR
                        $id_equipe_vivants = sql_select(
                                    array('ModeleEquipe', 'Equipe', 'JDR'),
                                    'Equipe.id_equipe',
                                    array(
                                            'Equipe::id_modele_equipe' => 'ModeleEquipe::id_modele_equipe',
                                            'JDR::id_jdr' => $_REQUEST['id'],
                                            'ModeleEquipe::id_modele_jdr' => 'JDR::id_modele_jdr',
                                            'ModeleEquipe::titre_equipe' => "Vivants"
                                        )
                                )->fetch()['id_equipe'];
                        sql_insert('EstDans', array('id_joueur' => $id_joueur, 'id_equipe' => $id_equipe_vivants));

                        // ajoute toutes les données de ce nouveau joueur concernant ce JDR dans la _SESSION
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

                            'id_dans' => $id_joueur,
                            'pseudo_dans' => $pseudo,

                            'liste_equipe' => array(),
                            'indice_equipe_discussion_suivi' => 0
                        ));

                        // redirige vers la page du JDR
                        if ($redirige == "./#")
                            $redirige = "./jdr.php?id=".$_REQUEST['id'];
                    } else
                        $_SESSION['erreur'] = "Erreur plus de place libre";
                } else
                    $_SESSION['erreur'] = "Erreur pseudal existant";
            break;

        /**
         * Retire le joueur de la partie (la partie doir être dans l'état "lancement") :
         * 
         * _REQUEST :
         *  - id : id_jdr
         *  - joueur : id_joueur
         */
        case "virer":
                if ($donnees_jdr['est_mj'] || $_REQUEST['joueur'] == $donnees_jdr['id_dans']) {
                    sql_delete('Message_', array('id_joueur' => $_REQUEST['joueur']));
                    sql_delete('EstDans', array('id_joueur' => $_REQUEST['joueur']));
                    sql_delete('Joueur', array('id_joueur' => $_REQUEST['joueur']));
                    $redirige = $_REQUEST['redirection_succes'];
                }
            break;

        /**
         * Change l'état de la partie depuis "lancement" vers "deroulement" :
         * 
         * _REQUEST:
         *  - id : id_jdr
         */
        case "etat_demarrer":
                if ($donnees_jdr['est_mj']) {
                    sql_update('JDR', array('etat_partie' => "deroulement"), array('id_jdr' => $donnees_jdr['id_jdr']));
                    $redirige = $_REQUEST['redirection_succes'];
                }
            break;

        /**
         * Change l'état de la partie depuis "deroulement" vers "fin" :
         * 
         * _REQUEST:
         *  - id : id_jdr
         */
        case "etat_finir":
                if ($donnees_jdr['est_mj']) {
                    sql_update('JDR', array('etat_partie' => "fin"), array('id_jdr' => $donnees_jdr['id_jdr']));
                    $redirige = $_REQUEST['redirection_succes'];
                }
            break;

        /**
         * Affiche des données pertinantes (selon l'utilisateur) sur un JDR :
         * 
         * _REQUEST :
         *  - code ou id : id_jdr
         * 
         * _SESSION : *
         * 
         * Fait appel à `inclus/jdr/rejoint.php` ou `inclus/jdr/consulter.php` selon l'utilisateur.
         */
        case "afficher":
                if (!isset($_REQUEST['id']) && !isset($_REQUEST['code'])) { // s'il n'y a pas de JDR dans la requette (ni id ni code) affiche la `inclus/jdr/liste.php`
                    include_once "./inclus/page_debut.php";

                    include "./inclus/jdr/liste.php";

                    include_once "./inclus/page_fin.php";

                    unset($redirige);
                } else {
                    $where = isset($_REQUEST['code']) ? array('code_invite' => $_REQUEST['code']) : array('id_jdr' => $_REQUEST['id']);
                    $r = sql_select('JDR', "*", $where);

                    // cherche le JDR correspondand
                    $jdr = $r->fetch();
                    if ($jdr && $modele = sql_select('ModeleJDR', "*", array('id_modele_jdr' => $jdr['id_modele_jdr']))->fetch()) {
                        $etat_partie = $jdr['etat_partie'];

                        $__sous_titre = $modele['titre']." | ".$jdr['code_invite'];
                        $__css_necessaires = array("discussion", "jdr");
                        $__liste_equipes = array();
                        $__fond_ecran = $modele['img_fond'];

                        $est_connecte = isset($_SESSION['id']);

                        // détermine :
                        //  - si l'utilisateur a un joueur dans cette partie (a_rejoint)
                        //  - la liste des équipes à afficher dans la barre latérale (__liste_equipe)
                        $a_rejoint = false;
                        if ($est_connecte)
                            foreach ($_SESSION['liste_donnees_jdr'] as $v) {
                                $a_rejoint = $v['id_jdr'] == $jdr['id_jdr'];

                                if ($a_rejoint) {
                                    if ($_SESSION['indice_jdr_suivi'] < 0)
                                        exit;
                                    
                                    //maj_donnees_jdr();
                                    $donnees_jdr = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']];

                                    // cette partie récupère toutes équipes à afficher dans la barre latérale
                                    if ($donnees_jdr && $etat_partie != "lancement") {
                                        $compteur = 0;

                                        foreach ($donnees_jdr['liste_equipe'] as $k_ => $v_) if ($v_['discussion_autorisee'] || $donnees_jdr['est_mj']) {
                                            $compteur++;
                                            
                                            if ($v_['titre_equipe'] == "MP") { // cas où la conv est un MP : ajout le nom des participant dans le titre
                                                $tmp = sql_select(
                                                        array('Joueur', 'EstDans', 'Equipe'),
                                                        'Joueur.pseudo',
                                                        array(
                                                            'Joueur::id_joueur' => 'EstDans::id_joueur',
                                                            'EstDans::id_equipe' => 'Equipe::id_equipe',
                                                            'Joueur::id_joueur !' => $donnees_jdr['est_mj'] ? -1 : $donnees_jdr['id_dans'],
                                                            'Equipe::id_equipe' => $v_['id_equipe']
                                                        )
                                                    );
                                                $pseudoA = $tmp->fetch()['pseudo'];
                                                $pseudoB = $tmp->fetch()['pseudo'];

                                                // si c'est le MJ qui a créer cet MP, pseudoB est vide : on récupère pseudoMJ uniquement s'il n'a pas deja été utilisé pour un autre MP
                                                if ((empty($pseudoA) || empty($pseudoB)) && empty($pseudoMJ))
                                                    $pseudoMJ = sql_select('MJ', 'pseudo_mj', array('id_jdr_dirige' => $donnees_jdr['id_jdr']))->fetch()['pseudo_mj'];

                                                $titre = "MP - ".(empty($pseudoA) ? $pseudoMJ : $pseudoA).($donnees_jdr['est_mj'] ? " et ".(empty($pseudoB) ? $pseudoMJ : $pseudoB) : "");
                                            } else
                                                $titre = $v_['titre_equipe'];

                                            $__liste_equipes[] = array('href' => $k_, 'text' => $titre, 'active' => $k_ == $donnees_jdr['indice_equipe_discussion_suivi']);
                                        }

                                        // s'il n'ya à aucune équipe autorisant la discussion (ou aucune tout cours)
                                        if ($compteur == 0)
                                            $__liste_equipes[] = array('href' => "./equipe.php", 'text' => "Rejoiniez une équipe !", 'active' => false);
                                    }

                                    break;
                                }
                            }

                        include_once "./inclus/page_debut.php";

                        // s'il n'a pas encore rejoint ou que la partie n'a pas encore commencé
                        if ($etat_partie == "lancement" || !$a_rejoint)
                            include "./inclus/jdr/rejoindre.php";
                        else { // sinon ajoute un form pour quitter @Depreciated
                            include "./inclus/jdr/consulter.php";
                            /*?>

                            <hr>
                            <form action="./jdr.php">
                                <input type="hidden" name="id" value="<?=$jdr['id_jdr']?>">

                                <div class="text-right">
                                    <button class="btn btn-danger" type="submit" name="action" value="quitter">Quitter<!--? (retire TOUT, même les msg... -> idée : mettre l'ìd_utilisateur` à `null`) ?--></button>
                                </div>
                            </form><?php*/
                        }

                        include_once "./inclus/page_fin.php";

                        unset($redirige);
                    } else
                        $_SESSION['erreur'] = "Erreur JDR non trouver";
                }
            break;
            
        default:
                $_SESSION['erreur'] = "Erreur d'action dans `jdr.php`";
    }

    if (!empty($redirige))
        header("Location: $redirige");
?>
