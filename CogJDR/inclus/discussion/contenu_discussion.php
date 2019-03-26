<?php
    require_once __DIR__."/../session.php";
    require_once __DIR__."/../connexion.php";

    if (-1 < $_SESSION['indice_jdr_suivi'])
        $donnees_jdr = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']];
    if (empty($donnees_jdr) || empty($donnees_jdr['liste_equipe'])) {
        echo "Rejoiniez une équipe pour entamer une discussion !";
        if (isset($_REQUEST['page_form']))
            header("Location: ".$_REQUEST['page_form']);
        return false;
    }

    if (isset($_REQUEST['change_id_equipe'])) {
        $donnees_jdr['indice_equipe_discussion_suivi'] = $_REQUEST['change_id_equipe'];
        $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']]['indice_equipe_discussion_suivi'] = $_REQUEST['change_id_equipe'];
    }

    $id_equipe_discussion_suivi = $donnees_jdr['liste_equipe'][$donnees_jdr['indice_equipe_discussion_suivi']]['id_equipe'];

    if (!isset($_REQUEST['message_text'])) { // si pas de message, c'est qu'on est en train de recharger les messages    
        $r = sql_select(
            'Message_',
            array('id_joueur', 'horaire_publi', 'texte'),
            array('id_equipe' => $id_equipe_discussion_suivi),
            array('horaire_publi' => 'ASC')
        );

        $utilisateur_mj = sql_select('MJ', array('pseudo_mj', 'id_utilisateur'), array('id_jdr_dirige' => $donnees_jdr['id_jdr']))->fetch();
        $utilisateur_mj['pseudo'] = $utilisateur_mj['pseudo_mj'];

        while($message = $r->fetch()) {
            $utilisateur = $message['id_joueur'] == null ? $utilisateur_mj : sql_select('Joueur', array('pseudo', 'id_utilisateur'), array('id_joueur' => $message['id_joueur']))->fetch(); ?>
            <li class="discussion_message discussion_<?=$message['id_joueur'] == null ? "mj" : "joueur"?>">
                <b class="discussion_debut">[<?=$message['horaire_publi']?>]&nbsp;<a href="./compte.php?id=<?=$utilisateur['id_utilisateur']?>"><?=$utilisateur['pseudo']?></a>&nbsp;:&nbsp;</b><i class="discussion_texte"><?=$message['texte']?></i>
            </li><?php
        }
    } else { // sinon, c'est que la pages est solicitée pour evoyer un message
        if (isset($_REQUEST['message_text']) && $_REQUEST['message_text'] !== "")
            sql_insert('Message_', array(
                'id_message' => null,
                'id_joueur' => $donnees_jdr['est_mj'] ? null : $donnees_jdr['id_dans'],
                'id_equipe' => $id_equipe_discussion_suivi,
                'horaire_publi' => null,
                'texte' => str_replace("&amp;", "&", htmlentities($_REQUEST['message_text']))
            ));
    }

    return true;
?>
