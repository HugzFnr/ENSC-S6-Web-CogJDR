<?php
    require_once __DIR__."/session.php";
    require_once __DIR__."/connection.php";

    $donnees_jdr = $_SESSION['liste_donnees_jd'][$_SESSION['indice_jdr_suivi']];

    if (!isset($_REQUEST['message_text'])) { // si 'message' est vide, c'est qu'on est en train de recharger les messages
        $r = sql_select(
            'Message_',
            array('id_joueur', 'horaire_publi', 'texte'),
            array('id_equipe' => $donnees_jdr['id_equipe_liste']),
            'ORDER BY horaire_publi ASC'
        );

        while($message = $r->fetch()) {
            $utilisateur = sql_select('Joueur', array('pseudo', 'id_utilisateur'), array('id_joueur' => $message['id_joueur']))->fetch(); ?>
            <li class="discussion_message"><b class="discussion_debut">[<?=$message['horaire_publi']?>] <a href="./gestion_compte.php?action=afficher&id=<?=$utilisateur['id_utilisateur']?>"><?=$utilisateur['pseudo']?></a> : </b><i class="discussion_texte"><?=$message['texte']?></i></li>
        <?php }
    } else { // sinon, c'est que la pages est solicitée pour evoyer un message
        if (!empty($_REQUEST['message_text']))
            $r = sql_insert('Message_', array(
                'id_message' => null,
                'id_joueur' => $donnees_jdr['id_joueur'],
                'id_equipe' => $donnees_jdr['id_equipe_discussion_suivi'],
                'horaire_publi' => null,
                'texte' => $_REQUEST['message_text']
            ));

        header("Location: ".$_REQUEST['page_form']);
    }
?>
