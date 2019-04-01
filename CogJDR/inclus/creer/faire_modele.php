<?php

    require_once "./../connexion.php";
    require_once "./../session.php";

    //sql_insert('Message_',array('id_message'=>null,'id_joueur'=>1,'id_equipe'=>1,'horaire_publi'=>null,'texte'=>var_export($_REQUEST,true)));
    var_dump($_REQUEST);

    /*- création du modèle */
    //$envoi_banniere = send_image($_REQUEST['finaux']['img_banniere'], "banniere_".$_REQUEST['parametres']['titre_modele'], "images/jdr/");
    //$envoi_fond = send_image($_REQUEST['finaux']['img_fond'], "fond_".$_REQUEST['parametres']['titre_modele'], "images/jdr/");
    //$envoi_logo = send_image($_REQUEST['finaux']['img_logo'], "logo_".$_REQUEST['parametres']['titre_modele'], "images/jdr/");
    //$envoi_regles = send_file($_REQUEST['finaux']['fichier_regles'], "regles_".$_REQUEST['parametres']['titre_modele'], "fichiers/jdr/", array("pdf"));

    //echo $envoi_banniere['msg']."\n"; // TODO: c'est du debug (x5)
    //echo $envoi_fond['msg']."\n";
    //echo $envoi_logo['msg']."\n";
    //echo $envoi_regles['msg']."\n";

    $modele_jdr = array(
            'id_modele_jdr' => null,
            'id_createur' => $_SESSION['id'],
            'titre' => $_REQUEST['parametres']['titre_modele'],
            'desc_jdr' => $_REQUEST['finaux']['desc_modele'],
            'fichier_regles' => "fichiers/regles.pdf",//$envoi_regles['fileName'],
            'img_banniere' => "images/jdr/banniereRigolo.png",//$envoi_banniere['fileName'],
            'img_fond' => "images/jdr/waterfall.gif",//$envoi_fond['fileName'],
            'img_logo' => "images/jdr/logoRigolo.png"//$envoi_logo['fileName']
        );
    $id_modele_jdr = sql_insert('ModeleJDR', $modele_jdr, 'id_modele_jdr');

    /*- équipes vivants / tous / morts */
    $equipe_tous = array(
            'id_modele_equipe' => null,
            'id_modele_jdr' => $id_modele_jdr,
            'titre_equipe' => "Tous",
            'taille_equipe_max' => -1,
            'discussion_autorisee' => true
        );
    $id_modele_equipe_tous = sql_insert('ModeleEquipe', $equipe_tous, null, 'id_modele_equipe');

    $equipe_vivant = array(
            'id_modele_equipe' => null,
            'id_modele_jdr' => $id_modele_jdr,
            'titre_equipe' => "Vivants",
            'taille_equipe_max' => -1,
            'discussion_autorisee' => true
        );
    $id_modele_equipe_vivant = sql_insert('ModeleEquipe', $equipe_tous, null, 'id_modele_equipe');

    $equipe_morts = array(
            'id_modele_equipe' => null,
            'id_modele_jdr' => $id_modele_jdr,
            'titre_equipe' => "Morts",
            'taille_equipe_max' => -1,
            'discussion_autorisee' => false
        );
    $id_modele_equipe_morts = sql_insert('ModeleEquipe', $equipe_tous, null, 'id_modele_equipe');

    $id_equipes = array($id_modele_equipe_tous, $id_modele_equipe_vivant, $id_modele_equipe_morts);

    /*- liste des équipes customs */
    foreach ($_REQUEST['equipes'] as $req_equipe) {
        $equipe = array(
                'id_modele_equipe' => null,
                'id_modele_jdr' => $id_modele_jdr,
                'titre_equipe' => $req_equipe['nom_equipe'],
                'taille_equipe_max' => $req_equipe['taille_equipe'],
                'discussion_autorisee' => $req_equipe['discussion']
            );
        $id_equipes[] = sql_insert('ModeleEquipe', $equipe, null, 'id_modele_equipe');
    }

    /*- liste des roles */
    foreach ($_REQUEST['roles'] as $req_role) {
        //$envoi_role = send_image($req_role['img_role'], "role_".$_REQUEST['parametres']['titre_modele']."_".$req_role['nom_role'], "images/jdr/");
        //echo $envoi_role['msg']."\n";

        $role = array(
                'id_role' => null,
                'id_modele_jdr' => $id_modele_jdr,
                'nom_role' => $req_role['nom_role'],
                'img_role' => "images/defaut/utilisateur.png",//$envoi_role['fileName'],
                'desc_role' => $req_role['desc_role']
            );
        sql_insert('Role', $role);
    }

    /*- liste des actions (avec cible et autorise) */
    foreach ($_REQUEST['actions'] as $req_action) {
        $id_modele_equipe_depart = $id_modele_equipe_tous;
        $id_modele_equipe_arrive = $id_modele_equipe_tous;

        $action = array(
                'id_modele_action' => null,
                'id_modele_jdr' => $id_modele_jdr,
                'titre_action' => $req_action['titre_action'],
                'action_fct' => $req_action['fct_action'],
                'horaire_limite' => $req_action['horaire_action'],
                'message_action' => $req_action['msg_action'],
                'action_effet_id_modele_equipe_depart' => $id_modele_equipe_depart,
                'action_effet_id_modele_equipe_arrive' => $id_modele_equipe_arrive,
                'desc_action' => $req_action['desc_action']
            );
        $id_modele_action = sql_insert('ModeleAction', $role, null, 'id_modele_action');

        $autorise = array(
                'id_modele_equipe_autorise' => $req_action['effecteur_action'],
                'id_modele_action' => $id_modele_action
            );
        sql_insert('Autorise', $autorise);

        $cible = array(
                'id_modele_equipe_cible' => $req_action['cibles_action'],
                'id_modele_action' => $id_modele_action
            );
        sql_insert('Cible', $cible);
    }
?>
