<ul>
    <?php
        require_once "./session.php";
        require_once "./connection.php";

        if (empty($_REQUEST['message_text'])) { // si 'message' est vide, c'est qu'on est en train de recharger les messages
            $r = sql_select(
                'Message_',
                array('id_joueur', 'horaire_publi', 'texte'),
                array('id_equipe' => $_SESSION['id_equipe_liste']),
                'ORDER BY horaire_publi'
            );

            while($message = $r->fetch()) { ?>
                <li class="discussion_message"><b class="discussion_debut">[<?=$message['horaire_publi']?>] <?=sql_select('Joueur', 'pseudo', array('id_joueur' => $message['id_joueur']))->fetch()['pseudo']?> : </b><i class="discussion_texte"><?=$message['texte']?></i></li>
            <?php }
        } else { // sinon, c'est que la pages est solicitée pour evoyer un message
            $r = sql_insert('Message_', array(
                'id_message' => null,
                'id_joueur' => $_SESSION['id_joueur'],
                'id_equipe' => $_SESSION['id_equipe_discussion'],
                'horaire_publi' => null,
                'texte' => $_REQUEST['message_text']
            ));

            header("Location: ".$_REQUEST['page_form']);
        }
    ?>
</ul>
