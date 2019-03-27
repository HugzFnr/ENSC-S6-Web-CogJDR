<?php
    /**
     * = Page de gestion des equipes
     * 
     * == liste des actions :
     *
     *  1. `creer` : créer une equipe
     *  0. `ajouter` : ajouter les joueurs à une equipe
     *  0. `retirer` : retirer les joueurs d'une équipe [?]
     *  0. `afficher` : affiche les informations de l'équipe selon l'utilisateur (peut rediriger si non authorisé, pas d'id : affiche toutes les équipes) (fonctionne avec un code ou avec un id),
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
        exit;
    $donnees_jdr = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']];

    switch (isset($_REQUEST['action']) ? $_REQUEST['action'] : "afficher") {
        
        case "creer":
                $id_modele_equipe = isset($_REQUEST['id_modele_equipe']) ? $_REQUEST['id_modele_equipe'] : 0;
                $liste_id_joueur = isset($_REQUEST['liste_id_joueur']) ? $_REQUEST['liste_id_joueur'] : array();

                if (empty($liste_id_joueur)) {
                    sql_insert('Equipe', array('id_equipe' => null, 'id_modele_equipe' => $id_modele_equipe, 'id_jdr' => $donnees_jdr['id_jdr']));
                    break;
                }

                // question ici-bas : comment tester qu'une équipe existe déjà ? données : liste des `id_joueur`s (ainsi que les tables `Equipe` et `EstDans`)
                /*if (sql_select(
                            array('EstDans', 'Equipe'),
                            'COUNT(*)',
                            array(
                                'EstDans::id_equipe' => 'Equipe::id_equipe',
                                'EstDans::id_joueur' => $liste_id_joueur
                            ),
                            null,
                            true
                        )->fetch()[0] == count($liste_id_joueur))
                    exit;*/
                $id_jdr = $donnees_jdr['id_jdr'];
                
                sql_insert('Equipe', array('id_equipe' => null, 'id_modele_equipe' => $id_modele_equipe, 'id_jdr' => $donnees_jdr['id_jdr']));
                $id_equipe = sql_select('Equipe', 'MAX(id_equipe)')->fetch()[0]; //$id_equipe = sql_select('Equipe', '@@IDENTITY');

        case "ajouter":
                if (!isset($id_equipe))
                    $id_equipe = $_REQUEST['id'];

                if (empty($liste_id_joueur))
                    $liste_id_joueur = $_REQUEST['liste_id_joueur'];

                $taille_equipe_max = sql_select(
                        array('Equipe', 'ModeleEquipe'),
                        'ModeleEquipe.taille_equipe_max',
                        array(
                            'Equipe::id_modele_equipe' => 'ModeleEquipe::id_modele_equipe',
                            'Equipe::id_equipe' => $id_equipe
                        )
                    )->fetch()['taille_equipe_max'];
                
                if (count($liste_id_joueur) < $taille_equipe_max)
                    exit;
        
                $equipe_constructeur = [];
        
                foreach ($liste_id_joueur as $id_joueur) if ($id_joueur)
                    $equipe_constructeur[] = array($id_joueur, $id_equipe);

                sql_insert('EstDans', array('id_joueur', 'id_equipe'), $equipe_constructeur, true);

                $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']]['liste_equipe'][] = array(
                    'id_equipe' => $id_equipe,
                    'titre_equipe' => sql_select(
                            array('Equipe', 'ModeleEquipe'),
                            array('ModeleEquipe.titre_equipe'),
                            array(
                                'Equipe::id_modele_equipe' => 'ModeleEquipe::id_modele_equipe',
                                'Equipe::id_equipe' => $id_equipe,
                            )
                        )->fetch()['titre_equipe']
                );
                $_SESSION['indice_jdr_suivi'] = count($_SESSION['liste_donnees_jdr']) - 1;

                unset($redirige);
            break;

        case "afficher":
                include_once "./inclus/page_debut.php";

                if (!isset($_REQUEST['id'])) {
                    $r = sql_select(
                        array('Equipe', 'ModeleEquipe'),
                        array('Equipe.id_equipe', 'ModeleEquipe.titre_equipe', 'ModeleEquipe.discussion_autorisee'),
                        array(
                            'ModeleEquipe::id_modele_equipe' => 'Equipe::id_modele_equipe',
                            'Equipe::id_jdr' => $donnees_jdr['id_jdr']
                        )
                    );
                    
                    while ($equipe = $r->fetch()) { ?>
                        <ul><?php
                            if ($equipe['discussion_autorisee'] || $donnees_jdr['est_mj']) { ?>
                                <li>
                                    <a href="./equipe.php?id=<?=$equipe['id_equipe']?>"><?=$equipe['titre_equipe']?></a>
                                </li><?php
                            } ?>
                        </ul><?php
                    }
                } else {
                    $id_equipe = $_REQUEST['id'];
                    $equipe = sql_select(
                        array('Equipe', 'ModeleEquipe'),
                        array('Equipe.id_equipe', 'ModeleEquipe.titre_equipe', 'ModeleEquipe.discussion_autorisee'),
                        array(
                            'ModeleEquipe::id_modele_equipe' => 'Equipe::id_modele_equipe',
                            'Equipe::id_equipe' => $id_equipe
                        )
                    )->fetch(); ?>
                    
                    <h2><?=$equipe['titre_equipe']?></h2>
                    <a href="<?=$equipe['id_equipe']?>">C'est une chouette équipe !</a><?php
                }
                include_once "./inclus/page_fin.php";

                unset($redirige);
            break;
            
        default:
                $_SESSION['erreur'] = "Erreur d'action dans `equipe.php`";
    }

    if (!empty($redirige))
        header("Location: $redirige");
?>
