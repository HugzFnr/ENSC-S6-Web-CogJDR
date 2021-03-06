<?php
    /*var_dump($_REQUEST);
    exit;*/

    require_once "./../connexion.php";
    require_once "./../session.php";
    
    /*- création du modèle */
    //$envoi_banniere = send_image($_REQUEST['finaux']['img_banniere'], $_REQUEST['parametres']['titre_modele'], "images/jdr/banniere/");
    //$envoi_fond = send_image($_REQUEST['finaux']['img_fond'], $_REQUEST['parametres']['titre_modele'], "images/jdr/fond/");
    //$envoi_logo = send_image($_REQUEST['finaux']['img_logo'], $_REQUEST['parametres']['titre_modele'], "images/jdr/logo/");
    //$envoi_regles = send_file($_REQUEST['finaux']['fichier_regles'], $_REQUEST['parametres']['titre_modele'], "fichiers/jdr/regles/", array("pdf", "docx", "doc", "odt"));
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
    sql_insert('ModeleJDR', $modele_jdr);
    $id_modele_jdr = sql_select('ModeleJDR', 'MAX(id_modele_jdr)')->fetch()[0];


    /*- équipes vivants / tous / morts */
    $equipe_tous = array(
            'id_modele_equipe' => null,
            'id_modele_jdr' => $id_modele_jdr,
            'titre_equipe' => "Tous",
            'taille_equipe_max' => -1,
            'discussion_autorisee' => false
        );
    sql_insert('ModeleEquipe', $equipe_tous);
    $id_modele_equipe_tous = sql_select('ModeleEquipe', 'MAX(id_modele_equipe)')->fetch()[0];

    $equipe_vivant = array(
            'id_modele_equipe' => null,
            'id_modele_jdr' => $id_modele_jdr,
            'titre_equipe' => "Vivants",
            'taille_equipe_max' => -1,
            'discussion_autorisee' => true
        );
    sql_insert('ModeleEquipe', $equipe_vivant);
    $id_modele_equipe_vivant = sql_select('ModeleEquipe', 'MAX(id_modele_equipe)')->fetch()[0];

    $equipe_morts = array(
            'id_modele_equipe' => null,
            'id_modele_jdr' => $id_modele_jdr,
            'titre_equipe' => "Morts",
            'taille_equipe_max' => -1,
            'discussion_autorisee' => true
        );
    sql_insert('ModeleEquipe', $equipe_morts);
    $id_modele_equipe_morts = sql_select('ModeleEquipe', 'MAX(id_modele_equipe)')->fetch()[0];


    /*- liste des équipes customs */
    foreach ($_REQUEST['equipes'] as $req_equipe) {
        $equipe = array(
                'id_modele_equipe' => null,
                'id_modele_jdr' => $id_modele_jdr,
                'titre_equipe' => $req_equipe['nom_equipe'],
                'taille_equipe_max' => $req_equipe['taille_equipe'],
                'discussion_autorisee' => $req_equipe['discussion']
            );
        sql_insert('ModeleEquipe', $equipe);
    }


    /*- liste des roles */
    foreach ($_REQUEST['roles'] as $req_role) {
        //$envoi_role = send_image($req_role['img_role'], $_REQUEST['parametres']['titre_modele']."_".$req_role['nom_role'], "images/jdr/role/");
        //echo $envoi_role['msg']."\n";

        $role = array(
                'id_role' => null,
                'id_modele_jdr' => $id_modele_jdr,
                'nom_role' => $req_role['nom_role'],
                'img_role' => "images/defaut/utilisateur.png", //$envoi_role['fileName'],
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
        sql_insert('ModeleAction', $role);
        $id_modele_action = sql_select('ModeleAction', 'MAX(id_modele_action)')->fetch()[0];

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