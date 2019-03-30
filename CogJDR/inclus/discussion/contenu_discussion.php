<?php
    // on utilise __DIR__ car le cwd change selon si on vient d'un include PHP ou d'un load JS
    require_once __DIR__."/../session.php";
    require_once __DIR__."/../connexion.php";

    if (-1 < $_SESSION['indice_jdr_suivi'])
        $donnees_jdr = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']];

    // si le but de l'appel est de changer d'indeice de l'équipe dont la discussion est suivi
    if (isset($_REQUEST['change_id_equipe'])) {
        $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']]['indice_equipe_discussion_suivi'] = $_REQUEST['change_id_equipe'];
        exit;
    }

    // cas où il n'y a aucune équipe à suivre ou où envoyer un message
    if (empty($donnees_jdr) || empty($donnees_jdr['liste_equipe'])) { ?>
        <p class="text-center">Rejoiniez une équipe pour entamer une discussion !</p><?php
        return false;
    }

    // cas ou la discussion n'est pas autorisée dans cette équipe
    if (!$donnees_jdr['liste_equipe'][$donnees_jdr['indice_equipe_discussion_suivi']]['discussion_autorisee']) { ?>
        <p class="text-center">Seul le MJ peut publier des messages ici !</p><?php
        if (!$donnees_jdr['est_mj']) // le MJ peut pubier (skip le return)
            return false;
    }

    $id_equipe_discussion_suivi = $donnees_jdr['liste_equipe'][$donnees_jdr['indice_equipe_discussion_suivi']]['id_equipe'];

    if (!isset($_REQUEST['message_text'])) { // si pas de message, c'est qu'on est en train de recharger les messages
        // récupère touts les messages de cette discussion
        $r = sql_select(
                'Message_',
                array('id_joueur', 'horaire_publi', 'texte'),
                array('id_equipe' => $id_equipe_discussion_suivi),
                array('horaire_publi' => 'ASC')
            );

        // récupère le pseudo et ID du MJ directement pour plus de simplicité
        $utilisateur_mj = sql_select('MJ', array('pseudo_mj', 'id_utilisateur'), array('id_jdr_dirige' => $donnees_jdr['id_jdr']))->fetch();
        $utilisateur_mj['pseudo'] = $utilisateur_mj['pseudo_mj'];

        // récupère la liste des gents ayant participé au fur-et-à mesure pour plus d'efficacité (?)
        // une alternatives étant récupérer touts les joueurs de l'équipe (cas critique : eg. si y en a que 1 qui a publier des messages)
        $liste_gents = array(null => $utilisateur_mj);

        while($message = $r->fetch()) {
            if (!array_key_exists($message['id_joueur'], $liste_gents))
                $liste_gents[$message['id_joueur']] = sql_select('Joueur', array('pseudo', 'id_utilisateur'), array('id_joueur' => $message['id_joueur']))->fetch();

            $utilisateur = $liste_gents[$message['id_joueur']]; ?>
            <li class="discussion_message discussion_<?=$message['id_joueur'] == null ? "mj" : "joueur"?>">
                <b class="discussion_debut">[<?=date("m/d G:i", strtotime($message['horaire_publi']))?>] <a href="./compte.php?id=<?=$utilisateur['id_utilisateur']?>"><?=$utilisateur['pseudo']?></a>&nbsp;: </b><i class="discussion_texte"><?=$message['texte']?></i>
            </li><?php
        }
    } elseif ($donnees_jdr['liste_equipe'][$donnees_jdr['indice_equipe_discussion_suivi']]['discussion_autorisee'] || $donnees_jdr['est_mj']) { // sinon, c'est que la pages est solicitée pour evoyer un message
        if ($_REQUEST['message_text'] !== "") // (note : le test `message != ""` est déja assuré par JS)
            // requêtte d'envoi du message
            sql_insert('Message_', array(
                    'id_message' => null,
                    'id_joueur' => $donnees_jdr['est_mj'] ? null : $donnees_jdr['id_dans'],
                    'id_equipe' => $id_equipe_discussion_suivi,
                    'horaire_publi' => null,
                    'texte' => str_replace("&amp;", "&", htmlentities($_REQUEST['message_text']))
                ));
        
        exit;
    }

    return true;
?>
