<?php
    require_once "./../connexion.php";
    require_once "./../session.php";
    
    /*- création du modèle */
    $envoi_banniere = send_image($_FILES['img_banniere'], $_REQUEST['titre_modele'], "../../images/jdr/banniere/");
    $envoi_fond = send_image($_FILES['img_fond'], $_REQUEST['titre_modele'], "../../images/jdr/fond/");
    $envoi_logo = send_image($_FILES['img_logo'], $_REQUEST['titre_modele'], "../../images/jdr/logo/");
    $envoi_regles = send_file($_FILES['fichier_regles'], $_REQUEST['titre_modele'], "../../fichiers/jdr/regles/", array("pdf", "docx", "doc", "odt"));

    $modele_jdr = array(
            'id_modele_jdr' => null,
            'id_createur' => $_SESSION['id'],
            'titre' => $_REQUEST['titre_modele'],
            'desc_jdr' => $_REQUEST['desc_modele'],
            'fichier_regles' => $envoi_regles['fileName'],
            'img_banniere' => $envoi_banniere['fileName'],
            'img_fond' => $envoi_fond['fileName'],
            'img_logo' => $envoi_logo['fileName']
        );
    $id_modele_jdr = sql_insert('ModeleJDR', $modele_jdr, null, 'id_modele_jdr');


    /*- équipes vivants / tous / morts */
    $equipe_tous = array(
            'id_modele_equipe' => null,
            'id_modele_jdr' => $id_modele_jdr,
            'titre_equipe' => "Tous",
            'taille_equipe_max' => -1,
            'discussion_autorisee' => false
        );
    $id_modele_equipe_tous = sql_insert('ModeleEquipe', $equipe_tous, null, 'id_modele_equipe');

    $equipe_vivant = array(
            'id_modele_equipe' => null,
            'id_modele_jdr' => $id_modele_jdr,
            'titre_equipe' => "Vivants",
            'taille_equipe_max' => -1,
            'discussion_autorisee' => true
        );
    $id_modele_equipe_vivant = sql_insert('ModeleEquipe', $equipe_vivant, null, 'id_modele_equipe');

    $equipe_morts = array(
            'id_modele_equipe' => null,
            'id_modele_jdr' => $id_modele_jdr,
            'titre_equipe' => "Morts",
            'taille_equipe_max' => -1,
            'discussion_autorisee' => true
        );
    $id_modele_equipe_morts = sql_insert('ModeleEquipe', $equipe_morts, null, 'id_modele_equipe');


    /*- liste des équipes customs */
    for ($k = 0; $k < $_REQUEST['nb_equipes']; $k++) {
        $equipe = array(
                'id_modele_equipe' => null,
                'id_modele_jdr' => $id_modele_jdr,
                'titre_equipe' => $_REQUEST['nom_equipe'.$k],
                'taille_equipe_max' => $_REQUEST['taille_equipe'.$k],
                'discussion_autorisee' => $_REQUEST['discussion'.$k]
            );
        sql_insert('ModeleEquipe', $equipe);
    }


    /*- liste des roles */
    for ($k = 0; $k < $_REQUEST['nb_roles']; $k++) {
        $envoi_role = send_image($_FILES['img_role'.$k], $_REQUEST['titre_modele']."_".$_REQUEST['nom_role'.$k], "../../images/jdr/role/");

        $role = array(
                'id_role' => null,
                'id_modele_jdr' => $id_modele_jdr,
                'nom_role' => $_REQUEST['nom_role'.$k],
                'img_role' => $envoi_role['fileName'],
                'desc_role' => $_REQUEST['desc_role'.$k]
            );
        sql_insert('Role_', $role);
    }


    /*- liste des actions (avec cible et autorise) */
    for ($k = 0; $k < $_REQUEST['nb_actions']; $k++) {
        $id_modele_equipe_depart = $id_modele_equipe_tous;
        $id_modele_equipe_arrive = $id_modele_equipe_tous;
        $action = array(
                'id_modele_action' => null,
                'id_modele_jdr' => $id_modele_jdr,
                'titre_action' => $_REQUEST['titre_action'.$k],
                'action_fct' => $_REQUEST['effet_action'.$k],
                'horaire_activ' => $_REQUEST['horaire_action'.$k],
                'message_action' => $_REQUEST['msg_action'.$k],
                'action_effet_id_modele_equipe_depart' => $id_modele_equipe_depart,
                'action_effet_id_modele_equipe_arrive' => $id_modele_equipe_arrive,
                'desc_action' => $_REQUEST['desc_action'.$k]
            );
        $id_modele_action = sql_insert('ModeleAction', $action, null, 'id_modele_action');

        $autorise = array(
                'id_modele_equipe_autorise' => $_REQUEST['effecteur_action'.$k],
                'id_modele_action' => $id_modele_action
            );
        sql_insert('Autorise', $autorise);

        $cible = array(
                'id_modele_equipe_cible' => $_REQUEST['cibles_action'.$k],
                'id_modele_action' => $id_modele_action
            );
        sql_insert('Cible', $cible);
    }

    header("Location: ../../#");
?>
